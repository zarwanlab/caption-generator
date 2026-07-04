<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\HistoryService;

class AiController extends Controller
{
    public function __construct(
        protected HistoryService $historyService
    ) {
    }

    public function generateCaption(Request $request)
    {
        $request->validate([
            'product_type' => 'required|string',
            'caption_language' => 'required|string',
            'product_description' => 'required|string',
        ]);

        $productType = trim((string) $request->input('product_type'));
        $captionLanguage = trim((string) $request->input('caption_language'));
        $productDescription = trim((string) $request->input('product_description'));

        $baseUrl = config('services.ai.base_url');
        $token = config('services.ai.token');
        $model = config('services.ai.model');
        $timeout = (int) config('services.ai.timeout', 120);
        $connectTimeout = (int) config('services.ai.connect_timeout', 20);
        $verifySsl = filter_var(config('services.ai.verify_ssl', true), FILTER_VALIDATE_BOOL);

        if (!$baseUrl || !$token || !$model) {
            Log::error('AI API configuration missing.', [
                'baseUrl' => $baseUrl,
                'token' => $token ? '***' : 'null',
                'model' => $model,
            ]);

            return response()->json(['error' => 'AI API configuration missing.'], 500);
        }

        try {
            $aiPayload = [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->systemPrompt($captionLanguage),
                    ],
                    [
                        'role' => 'user',
                        'content' => $this->buildPrompt($productType, $captionLanguage, $productDescription),
                    ]
                ],
                'temperature' => 0.6,
                'max_tokens' => 5072,
                'stream' => false,
            ];

            $response = Http::timeout($timeout)
                ->connectTimeout($connectTimeout)
                ->acceptJson()
                ->withOptions([
                    'verify' => $verifySsl,
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    ],
                ])
                ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])
                ->post($baseUrl, $aiPayload);

            $response->throw();

            $aiResponse = $response->json();
            $generatedContent = data_get($aiResponse, 'choices.0.message.content', '');
            $parsed = $this->parseResponse($generatedContent, $captionLanguage);

            $historyEntry = [
                'product_type' => $productType,
                'caption_language' => $captionLanguage,
                'product_description' => $productDescription,
                'generated_caption' => $parsed['caption'],
                'generated_hashtags' => implode(' ', $parsed['hashtags']),
                'generated_suggestion' => $parsed['suggestion'],
                'generated_angle' => $parsed['angle'],
                'timestamp' => now()->toDateTimeString(),
            ];

            $history = $this->historyService->saveHistory($historyEntry);

            return response()->json([
                'caption' => $parsed['caption'],
                'hashtags' => $parsed['hashtags'],
                'suggestion' => $parsed['suggestion'],
                'angle' => $parsed['angle'],
                'history' => $history,
            ]);
        } catch (\Throwable $e) {
            $errorMessage = $this->formatAiError($e);
            $errorDetails = $this->formatAiDetails($e);

            Log::error('AI API call failed', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'baseUrl' => $baseUrl,
                'model' => $model,
                'timeout' => $timeout,
                'connectTimeout' => $connectTimeout,
                'verifySsl' => $verifySsl,
            ]);

            return response()->json([
                'error' => $errorMessage,
                'details' => $errorDetails,
            ], 500);
        }
    }

    private function systemPrompt(string $captionLanguage): string
    {
        $languageLabel = $this->languageLabel($captionLanguage);

        return <<<PROMPT
You are a senior ecommerce growth strategist, direct-response copywriter, and Instagram conversion specialist.
Think like a marketing lead who writes for real businesses that want attention, trust, and sales.
Return ONLY valid JSON with this exact schema:
{
  "caption": "string",
  "hashtags": ["#tag1", "#tag2"],
  "suggestion": "string",
  "angle": "string"
}

Rules:
- Write caption, suggestion, and angle in {$languageLabel}.
- Write as if you are the in-house marketing lead for the business, not a generic assistant.
- The caption must be business-grade, persuasive, and tailored for a storefront or brand account.
- The caption must be longer and more useful: 2 to 3 short paragraphs, about 90 to 160 words.
- Start with a strong hook, then highlight customer benefit, product value, and one trust-building detail.
- Include a clear call to action near the end.
- Use a confident but natural tone. Avoid fluff, clichés, filler, and repetitive phrasing.
- The suggestion must be a short strategic recommendation that helps a business improve reach or conversion.
- The angle must explain the strongest marketing angle in 3 to 6 words.
- Provide 12 to 18 highly relevant hashtags.
- Every hashtag must start with # and use no spaces.
- Use hashtags that support business discovery, niche visibility, and buyer intent.
- Do not mention that you are an AI.
- Do not include markdown, code fences, bullet lists, or extra commentary.
PROMPT;
    }

    private function buildPrompt($productType, $captionLanguage, $productDescription)
    {
        return <<<PROMPT
You are writing for a real business that wants stronger engagement, better trust, and more sales.

Business context:
- Product type: {$productType}
- Output language: {$this->languageLabel($captionLanguage)}
- Product description: {$productDescription}

Create copy that a business owner can post immediately.
Make the caption specific to the product details, not generic.
Focus on benefits, positioning, persuasion, and a clear next step for the customer.
PROMPT;
    }

    private function parseResponse(string $content, string $captionLanguage): array
    {
        $cleanContent = trim(preg_replace('/^```(?:json)?|```$/m', '', $content));
        $decoded = json_decode($cleanContent, true);

        if (! is_array($decoded)) {
            if (preg_match('/\{.*\}/s', $cleanContent, $matches)) {
                $decoded = json_decode($matches[0], true);
            }
        }

        $caption = trim((string) data_get($decoded, 'caption', ''));
        $hashtags = data_get($decoded, 'hashtags', []);
        $suggestion = trim((string) data_get($decoded, 'suggestion', ''));
        $angle = trim((string) data_get($decoded, 'angle', ''));

        if ($caption === '' && $cleanContent !== '') {
            $caption = $cleanContent;
        }

        if (! is_array($hashtags)) {
            $hashtags = preg_split('/[\s,]+/', (string) $hashtags, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        }

        $hashtags = array_values(array_unique(array_filter(array_map(function ($tag) {
            $tag = trim((string) $tag);

            if ($tag === '') {
                return null;
            }

            return str_starts_with($tag, '#') ? $tag : '#'.ltrim($tag, '#');
        }, $hashtags))));

        if ($suggestion === '') {
            $suggestion = $this->fallbackSuggestion($captionLanguage);
        }

        if ($angle === '') {
            $angle = $this->fallbackAngle($captionLanguage);
        }

        return [
            'caption' => $caption,
            'hashtags' => $hashtags,
            'suggestion' => $suggestion,
            'angle' => $angle,
        ];
    }

    private function fallbackSuggestion(string $captionLanguage): string
    {
        return match ($captionLanguage) {
            'fa' => 'روی مزیت اصلی محصول و یک دعوت‌به‌اقدام ساده تمرکز کنید.',
            'ar' => 'ركّز على الفائدة الأساسية للمنتج مع دعوة واضحة للتفاعل.',
            default => 'Focus on the product’s main benefit and add a short, clear call to action.',
        };
    }

    private function fallbackAngle(string $captionLanguage): string
    {
        return match ($captionLanguage) {
            'fa' => 'زاویه فروش محصول',
            'ar' => 'زاوية البيع الأساسية',
            default => 'Core sales angle',
        };
    }

    private function languageLabel(string $captionLanguage): string
    {
        return match ($captionLanguage) {
            'fa' => 'Persian',
            'ar' => 'Arabic',
            'es' => 'Spanish',
            'fr' => 'French',
            'de' => 'German',
            'tr' => 'Turkish',
            'ur' => 'Urdu',
            'hi' => 'Hindi',
            'ru' => 'Russian',
            default => 'English',
        };
    }

    private function formatAiError(\Throwable $e): string
    {
        if ($e instanceof RequestException) {
            $status = $e->response?->status();
            $body = $e->response?->body() ?? '';
            $body = trim((string) $body);

            if ($status === 401 || $status === 403) {
                return 'AI API returned an authentication error. Check AI_TOKEN and make sure the host is using the latest .env values.';
            }

            if ($status === 429) {
                return 'AI API rate limit reached. Try again later or reduce request frequency.';
            }

            if ($status && $body !== '') {
                return "AI API returned HTTP {$status}.";
            }
        }

        $message = $e->getMessage();
        $code = (int) $e->getCode();

        if ($code === 60 || str_contains($message, 'cURL error 60')) {
            return 'AI service connection failed because SSL certificate verification is not working on the server. Try setting AI_VERIFY_SSL=false on the host.';
        }

        if ($code === 7 || str_contains($message, 'cURL error 7')) {
            return 'AI service connection failed because the host could not reach the AI endpoint. Check outbound network access and firewall rules.';
        }

        if ($code === 28 || str_contains($message, 'cURL error 28') || str_contains($message, 'timed out')) {
            return 'AI service request timed out. Increase AI_TIMEOUT or AI_CONNECT_TIMEOUT in the host environment.';
        }

        if (str_contains($message, 'Could not resolve host')) {
            return 'AI service connection failed because the AI host name could not be resolved.';
        }

        return 'AI API call failed on the server.';
    }

    private function formatAiDetails(\Throwable $e): string
    {
        if ($e instanceof RequestException) {
            $status = $e->response?->status();
            $body = trim((string) ($e->response?->body() ?? ''));

            if ($body === '') {
                return $e->getMessage();
            }

            $decoded = json_decode($body, true);

            if (is_array($decoded)) {
                $message = data_get($decoded, 'error.message')
                    ?? data_get($decoded, 'message')
                    ?? data_get($decoded, 'detail');

                if (is_string($message) && $message !== '') {
                    return $status ? "HTTP {$status}: {$message}" : $message;
                }
            }

            return $status ? "HTTP {$status}: {$body}" : $body;
        }

        return $e->getMessage();
    }
}
