<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                'temperature' => 0.7,
                'max_tokens' => 2048,
                'stream' => false,
            ];

            $response = Http::timeout(120)
                ->acceptJson()
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
        } catch (\Exception $e) {
            Log::error('AI API call failed', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json(['error' => 'AI API call failed: ' . $e->getMessage()], 500);
        }
    }

    private function systemPrompt(string $captionLanguage): string
    {
        $languageLabel = $this->languageLabel($captionLanguage);

        return <<<PROMPT
You are a senior Instagram growth strategist and ecommerce copywriter.
Return ONLY valid JSON with this exact schema:
{
  "caption": "string",
  "hashtags": ["#tag1", "#tag2"],
  "suggestion": "string",
  "angle": "string"
}

Rules:
- Write caption, suggestion, and angle in {$languageLabel}.
- The caption must sound premium, conversion-focused, and natural for Instagram.
- The suggestion must be a short practical marketing recommendation.
- The angle must explain the strongest creative angle in 3 to 8 words.
- Provide 8 to 15 hashtags.
- Every hashtag must start with # and use no spaces.
- Do not include markdown, code fences, or extra commentary.
PROMPT;
    }

    private function buildPrompt($productType, $captionLanguage, $productDescription)
    {
        return <<<PROMPT
Product type: {$productType}
Output language: {$this->languageLabel($captionLanguage)}
Product description: {$productDescription}

Use the product details to create an Instagram-ready caption, relevant hashtags, and a concise strategic suggestion for a store owner.
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
}
