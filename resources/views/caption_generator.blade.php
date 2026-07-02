<!DOCTYPE html>
<html lang="{{ $initialLang ?? 'en' }}" dir="{{ in_array($initialLang ?? 'en', ['fa', 'ar'], true) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app_title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;800;900&family=Vazirmatn:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #0D47A1;
            --secondary: #00BCD4;
            --background: #F8FAFC;
            --surface: rgba(255, 255, 255, 0.72);
            --surface-dark: rgba(15, 23, 42, 0.84);
            --border: rgba(148, 163, 184, 0.16);
            --text: #0f172a;
            --muted: #64748b;
            --shadow: 0 24px 60px -28px rgba(13, 71, 161, 0.24);
            --radius-xl: 2.5rem;
            --radius-lg: 1.5rem;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', 'Vazirmatn', sans-serif;
            background:
                radial-gradient(circle at 0% 0%, rgba(13, 71, 161, 0.08), transparent 28%),
                radial-gradient(circle at 100% 0%, rgba(0, 188, 212, 0.09), transparent 26%),
                radial-gradient(circle at 100% 100%, rgba(16, 185, 129, 0.06), transparent 24%),
                var(--background);
            color: var(--text);
            overflow-x: hidden;
        }

        [dir="rtl"] body,
        body.rtl {
            font-family: 'Vazirmatn', 'Inter', sans-serif;
        }

        .glass {
            background: var(--surface);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.45);
            box-shadow: var(--shadow);
        }

        .glass-dark {
            background: var(--surface-dark);
            backdrop-filter: blur(12px);
        }

        .soft-border {
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .fade-in {
            animation: fadeIn 0.55s ease both;
        }

        .fade-in-delay-1 { animation-delay: 0.08s; }
        .fade-in-delay-2 { animation-delay: 0.16s; }
        .fade-in-delay-3 { animation-delay: 0.24s; }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floaty {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-12px) scale(1.03); }
        }

        .floating {
            animation: floaty 7s ease-in-out infinite;
        }

        .floating-alt {
            animation: floaty 9s ease-in-out infinite;
            animation-delay: 1.5s;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.45);
            border-radius: 999px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: rgba(226, 232, 240, 0.35);
        }

        .icon-pill {
            width: 2.75rem;
            height: 2.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
        }

        .primary-button {
            background: linear-gradient(135deg, var(--primary), #1565C0 55%, var(--secondary));
            box-shadow: 0 18px 34px -20px rgba(13, 71, 161, 0.65);
        }

        .primary-button:hover {
            box-shadow: 0 22px 42px -22px rgba(13, 71, 161, 0.72);
        }

        .input-surface {
            background: rgba(255, 255, 255, 0.8);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body class="min-h-screen text-slate-900">
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="floating absolute -top-28 -left-20 h-72 w-72 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="floating-alt absolute top-32 -right-20 h-80 w-80 rounded-full bg-cyan-400/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-64 w-64 rounded-full bg-emerald-400/10 blur-3xl"></div>
    </div>

    <header class="sticky top-0 z-40 border-b border-white/40 bg-white/70 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <div class="icon-pill bg-[#0D47A1] text-white shadow-lg shadow-blue-200/60">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <div>
                    <h1 class="text-lg font-black tracking-tight text-slate-900 sm:text-xl"><span data-role="app-title">{{ __('app_title') }}</span></h1>
                    </div>
                </div>

            <label class="flex items-center gap-3 rounded-full border border-slate-200/80 bg-white/85 px-3 py-2 shadow-sm">
                <span class="text-xs font-bold text-slate-500" data-role="ui-language-label">{{ __('ui_language') }}</span>
                <div class="relative">
                    <select id="uiLanguageSwitcher" class="appearance-none rounded-full border-0 bg-transparent py-0 pl-3 pr-7 text-sm font-semibold text-slate-800 focus:outline-none">
                        <option value="en" data-role="language-en">English</option>
                        <option value="fa" data-role="language-fa">فارسی</option>
                        <option value="ar" data-role="language-ar">العربية</option>
                    </select>
                    <i class="fa-solid fa-chevron-down pointer-events-none absolute inset-y-0 right-1 flex items-center text-[10px] text-slate-400"></i>
                </div>
            </label>
        </div>
    </header>

    <main class="relative mx-auto w-full max-w-4xl px-4 py-8 sm:px-6 lg:max-w-5xl lg:px-8 lg:py-10">
        <section class="glass fade-in soft-border rounded-[2.5rem] p-6 sm:p-8 lg:p-10">
            <div>
                <h2 class="text-3xl font-black tracking-tight text-slate-900 sm:text-5xl" data-role="hero-title">{{ __('hero_title') }}</h2>
                <p class="mt-4 max-w-2xl text-base leading-8 text-slate-500 sm:text-lg" data-role="hero-description">{{ __('hero_description') }}</p>
            </div>

            <form id="captionForm" class="mt-8 space-y-5">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700" for="productType" data-role="product-type-label">{{ __('product_type_label') }}</label>
                    <div class="relative">
                        <select id="productType" class="input-surface w-full rounded-[1.25rem] border border-slate-200/80 px-4 py-4 text-base font-semibold text-slate-800 outline-none transition focus:border-[#0D47A1] focus:ring-4 focus:ring-blue-100">
                            <option value="fashion" data-product-option>{{ __('product_fashion') }}</option>
                            <option value="electronics" data-product-option>{{ __('product_electronics') }}</option>
                            <option value="home_decor" data-product-option>{{ __('product_home_decor') }}</option>
                            <option value="beauty" data-product-option>{{ __('product_beauty') }}</option>
                            <option value="food" data-product-option>{{ __('product_food') }}</option>
                            <option value="jewelry" data-product-option>{{ __('product_jewelry') }}</option>
                            <option value="sports" data-product-option>{{ __('product_sports') }}</option>
                            <option value="other" data-product-option>{{ __('product_other') }}</option>
                        </select>
                        <i class="fa-solid fa-caret-down pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400"></i>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700" for="captionLanguage" data-role="output-language-label">{{ __('output_language') }}</label>
                    <div class="relative">
                        <select id="captionLanguage" class="input-surface w-full rounded-[1.25rem] border border-slate-200/80 px-4 py-4 text-base font-semibold text-slate-800 outline-none transition focus:border-[#0D47A1] focus:ring-4 focus:ring-blue-100">
                            <option value="en" data-role="language-en">{{ __('language_english') }}</option>
                            <option value="fa" data-role="language-fa">{{ __('language_persian') }}</option>
                            <option value="ar" data-role="language-ar">{{ __('language_arabic') }}</option>
                        </select>
                        <i class="fa-solid fa-caret-down pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400"></i>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700" for="productDescription" data-role="product-description-label">{{ __('product_description_label') }}</label>
                    <textarea
                        id="productDescription"
                        data-role="product-description"
                        rows="6"
                        class="input-surface w-full rounded-[1.5rem] border border-slate-200/80 px-4 py-4 text-base leading-8 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#0D47A1] focus:ring-4 focus:ring-blue-100"
                        placeholder="{{ __('product_description_placeholder') }}"
                    ></textarea>
                </div>

                <div class="flex flex-col gap-3 pt-2 sm:flex-row">
                    <button type="submit" class="primary-button inline-flex items-center justify-center gap-3 rounded-[1.35rem] px-6 py-4 text-base font-bold text-white transition hover:scale-[1.01]">
                        <i class="fa-solid fa-sparkles"></i>
                        <span data-role="generate-button">{{ __('generate_button') }}</span>
                    </button>
                    <button type="button" id="resetButton" class="inline-flex items-center justify-center gap-3 rounded-[1.35rem] border border-slate-200 bg-white/80 px-6 py-4 text-base font-bold text-slate-700 transition hover:scale-[1.01] hover:border-slate-300">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span data-role="reset-button">{{ __('reset_button') }}</span>
                    </button>
                </div>
            </form>

            <div id="loadingState" class="mt-6 hidden rounded-[1.5rem] border border-blue-100 bg-blue-50/60 p-5">
                <div class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-2xl border-4 border-blue-100 border-t-[#0D47A1] animate-spin"></div>
                    <div>
                        <p class="font-bold text-slate-900" data-role="loading-text">{{ __('loading_text') }}</p>
                    </div>
                </div>
            </div>

            <div id="errorState" class="mt-6 hidden rounded-[1.5rem] border border-rose-200 bg-rose-50/80 p-5 text-rose-700">
                <div class="flex items-start gap-3">
                    <div class="icon-pill bg-rose-100 text-rose-600">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="text-sm font-semibold leading-7">
                        <p id="errorText"></p>
                    </div>
                </div>
            </div>

            <div id="resultState" class="mt-6 hidden space-y-4">
                <div class="rounded-[1.5rem] border border-slate-200/80 bg-white/85 p-5">
                    <div class="flex items-center justify-between gap-3">
                        <h4 class="text-base font-black text-slate-900" data-role="caption-title">{{ __('caption_title') }}</h4>
                        <button type="button" data-copy-target="caption" class="copy-btn inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 transition hover:border-slate-300">
                            <i class="fa-solid fa-copy"></i>
                            <span>{{ __('copy_caption') }}</span>
                        </button>
                    </div>
                    <p id="captionText" class="mt-4 whitespace-pre-wrap text-sm leading-8 text-slate-700"></p>
                </div>

                <div class="rounded-[1.5rem] border border-slate-200/80 bg-white/85 p-5">
                    <div class="flex items-center justify-between gap-3">
                        <h4 class="text-base font-black text-slate-900" data-role="hashtags-title">{{ __('hashtags_title') }}</h4>
                        <button type="button" data-copy-target="hashtags" class="copy-btn inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 transition hover:border-slate-300">
                            <i class="fa-solid fa-copy"></i>
                            <span>{{ __('copy_hashtags') }}</span>
                        </button>
                    </div>
                    <div id="hashtagsWrap" class="mt-4 flex flex-wrap gap-2"></div>
                </div>

                <div class="rounded-[1.5rem] border border-slate-200/80 bg-white/85 p-5">
                    <div class="flex flex-col gap-2">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-cyan-600" data-role="analysis-label">{{ __('analysis_label') }}</p>
                        <h4 id="angleText" class="text-lg font-black text-slate-900"></h4>
                    </div>
                    <p id="suggestionText" class="mt-4 text-sm leading-7 text-slate-600"></p>
                </div>

                <button type="button" id="copyAllButton" class="primary-button inline-flex w-full items-center justify-center gap-3 rounded-[1.35rem] px-6 py-4 text-base font-bold text-white transition hover:scale-[1.01]">
                    <i class="fa-solid fa-clone"></i>
                    <span data-role="copy-all">{{ __('copy_all') }}</span>
                </button>
            </div>

            <div id="emptyResultState" class="mt-6 hidden"></div>

            <section class="glass fade-in fade-in-delay-1 soft-border mt-6 rounded-[2.5rem] p-6 sm:p-7">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="text-xl font-black tracking-tight text-slate-900" data-role="history-title">{{ __('history_title') }}</h3>
                    <button type="button" id="clearHistoryButton" class="inline-flex items-center gap-2 rounded-full border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 transition hover:border-rose-300 hover:bg-rose-100">
                        <i class="fa-solid fa-broom"></i>
                        <span data-role="history-clear">{{ __('history_clear') }}</span>
                    </button>
                </div>
                <div id="historyList" class="scrollbar-thin mt-5 space-y-3 max-h-[28rem] overflow-auto pr-1"></div>
            </section>
        </section>
    </main>

    <div id="toast" class="pointer-events-none fixed bottom-6 right-6 z-50 translate-y-6 opacity-0 transition duration-300">
        <div class="glass-dark flex items-center gap-3 rounded-full px-4 py-3 text-white shadow-2xl">
            <i id="toastIcon" class="fa-solid fa-circle-check text-emerald-400"></i>
            <span id="toastText" class="text-sm font-semibold"></span>
        </div>
    </div>

    <script>
        window.__toolTranslations = {
            en: {
                appTitle: "Instagram Caption Generator",
                appTagline: "AI caption tool",
                heroBadge: "",
                heroTitle: "Create captions that sell.",
                heroDescription: "Choose product, language, and description.",
                uiLanguage: "Interface language",
                outputLanguage: "Caption language",
                productTypeLabel: "Product type",
                productDescriptionLabel: "Product description",
                productDescriptionPlaceholder: "Example: premium leather wallet with RFID protection, magnetic closure, and a gift-ready box.",
                generateButton: "Generate",
                resetButton: "Reset",
                copyAll: "Copy",
                copyCaption: "Copy caption",
                copyHashtags: "Copy hashtags",
                copySuggestion: "Copy note",
                resultTitle: "Result",
                suggestionTitle: "Note",
                captionTitle: "Caption",
                hashtagsTitle: "Hashtags",
                historyTitle: "History",
                historyEmpty: "Recent items will appear here.",
                historyClear: "Clear",
                historyHint: "",
                footer: "",
                loadingText: "Generating...",
                errorMissingApi: "Missing AI config.",
                errorFailed: "Generation failed.",
                successCopied: "Copied to clipboard.",
                successGenerated: "Generated.",
                historyCleared: "Cleared.",
                noDb: "",
                fileHistory: "",
                multilingual: "",
                onePage: "",
                analysisLabel: "Angle",
                languageEnglish: "English",
                languagePersian: "Persian",
                languageArabic: "Arabic",
                products: {
                    fashion: "Fashion & apparel",
                    electronics: "Electronics",
                    home_decor: "Home decor",
                    beauty: "Beauty & cosmetics",
                    food: "Food & beverage",
                    jewelry: "Jewelry",
                    sports: "Sports & outdoors",
                    other: "Other"
                }
            },
            fa: {
                appTitle: "تولیدکننده کپشن اینستاگرام",
                appTagline: "ابزار کپشن",
                heroBadge: "",
                heroTitle: "کپشن‌های فروش‌ساز",
                heroDescription: "محصول، زبان و توضیح را وارد کنید.",
                uiLanguage: "زبان رابط",
                outputLanguage: "زبان کپشن",
                productTypeLabel: "نوع محصول",
                productDescriptionLabel: "توضیحات محصول",
                productDescriptionPlaceholder: "مثال: کیف پول چرمی ممتاز با محافظ RFID، قفل مغناطیسی و جعبه مناسب هدیه.",
                generateButton: "تولید",
                resetButton: "شروع دوباره",
                copyAll: "کپی",
                copyCaption: "کپی کپشن",
                copyHashtags: "کپی هشتگ‌ها",
                copySuggestion: "کپی نکته",
                resultTitle: "نتیجه",
                suggestionTitle: "نکته",
                captionTitle: "کپشن",
                hashtagsTitle: "هشتگ‌ها",
                historyTitle: "تاریخچه",
                historyEmpty: "موارد اخیر اینجا دیده می‌شوند.",
                historyClear: "پاک کردن",
                historyHint: "",
                footer: "",
                loadingText: "در حال تولید...",
                errorMissingApi: "تنظیمات AI ناقص است.",
                errorFailed: "تولید ناموفق بود.",
                successCopied: "در کلیپ‌بورد کپی شد.",
                successGenerated: "تولید شد.",
                historyCleared: "پاک شد.",
                noDb: "",
                fileHistory: "",
                multilingual: "",
                onePage: "",
                analysisLabel: "زاویه",
                languageEnglish: "انگلیسی",
                languagePersian: "فارسی",
                languageArabic: "عربی",
                products: {
                    fashion: "مد و پوشاک",
                    electronics: "لوازم الکترونیکی",
                    home_decor: "دکوراسیون منزل",
                    beauty: "زیبایی و آرایشی",
                    food: "خوراکی و نوشیدنی",
                    jewelry: "زیورآلات",
                    sports: "ورزش و فضای باز",
                    other: "سایر"
                }
            },
            ar: {
                appTitle: "مولد عناوين إنستغرام",
                appTagline: "أداة عناوين",
                heroBadge: "",
                heroTitle: "عناوين تبيع",
                heroDescription: "اختر المنتج واللغة والوصف.",
                uiLanguage: "لغة الواجهة",
                outputLanguage: "لغة العنوان",
                productTypeLabel: "نوع المنتج",
                productDescriptionLabel: "وصف المنتج",
                productDescriptionPlaceholder: "مثال: محفظة جلدية فاخرة مع حماية RFID، وإغلاق مغناطيسي، وصندوق جاهز للإهداء.",
                generateButton: "توليد",
                resetButton: "إعادة الضبط",
                copyAll: "نسخ",
                copyCaption: "نسخ العنوان",
                copyHashtags: "نسخ الهاشتاغات",
                copySuggestion: "نسخ الملاحظة",
                resultTitle: "النتيجة",
                suggestionTitle: "ملاحظة",
                captionTitle: "العنوان",
                hashtagsTitle: "الهاشتاغات",
                historyTitle: "السجل",
                historyEmpty: "ستظهر العناصر الأخيرة هنا.",
                historyClear: "مسح",
                historyHint: "",
                footer: "",
                loadingText: "جارٍ التوليد...",
                errorMissingApi: "إعدادات AI ناقصة.",
                errorFailed: "فشل التوليد.",
                successCopied: "تم النسخ إلى الحافظة.",
                successGenerated: "تم.",
                historyCleared: "تم المسح.",
                noDb: "",
                fileHistory: "",
                multilingual: "",
                onePage: "",
                analysisLabel: "زاوية",
                languageEnglish: "الإنجليزية",
                languagePersian: "الفارسية",
                languageArabic: "العربية",
                products: {
                    fashion: "الأزياء والملابس",
                    electronics: "الإلكترونيات",
                    home_decor: "ديكور المنزل",
                    beauty: "الجمال ومستحضرات التجميل",
                    food: "الأطعمة والمشروبات",
                    jewelry: "المجوهرات",
                    sports: "الرياضة والأنشطة الخارجية",
                    other: "أخرى"
                }
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const uiLanguageSwitcher = document.getElementById('uiLanguageSwitcher');
            const productType = document.getElementById('productType');
            const captionLanguage = document.getElementById('captionLanguage');
            const productDescription = document.getElementById('productDescription');
            const form = document.getElementById('captionForm');
            const resetButton = document.getElementById('resetButton');
            const clearHistoryButton = document.getElementById('clearHistoryButton');
            const copyAllButton = document.getElementById('copyAllButton');
            const loadingState = document.getElementById('loadingState');
            const errorState = document.getElementById('errorState');
            const errorText = document.getElementById('errorText');
            const resultState = document.getElementById('resultState');
            const emptyResultState = document.getElementById('emptyResultState');
            const angleText = document.getElementById('angleText');
            const suggestionText = document.getElementById('suggestionText');
            const captionText = document.getElementById('captionText');
            const hashtagsWrap = document.getElementById('hashtagsWrap');
            const historyList = document.getElementById('historyList');
            const toast = document.getElementById('toast');
            const toastText = document.getElementById('toastText');
            const toastIcon = document.getElementById('toastIcon');

            const state = {
                uiLang: 'en',
                result: null,
                history: []
            };

            const dirFor = (lang) => (lang === 'fa' || lang === 'ar' ? 'rtl' : 'ltr');

            const setUrlLang = (lang) => {
                const url = new URL(window.location.href);
                url.searchParams.set('lang', lang);
                window.history.replaceState({}, '', url);
            };

            const getT = (lang = state.uiLang) => window.__toolTranslations[lang] || window.__toolTranslations.en;

            const showToast = (message, type = 'success') => {
                toastText.textContent = message;
                toastIcon.className = type === 'error'
                    ? 'fa-solid fa-circle-exclamation text-rose-400'
                    : 'fa-solid fa-circle-check text-emerald-400';

                toast.classList.remove('opacity-0', 'translate-y-6');
                toast.classList.add('opacity-100', 'translate-y-0');

                window.clearTimeout(window.__toastTimer);
                window.__toastTimer = window.setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-y-6');
                    toast.classList.remove('opacity-100', 'translate-y-0');
                }, 2200);
            };

            const escapeHtml = (value) => {
                const div = document.createElement('div');
                div.textContent = value ?? '';
                return div.innerHTML;
            };

            const applyLanguage = (lang) => {
                state.uiLang = ['en', 'fa', 'ar'].includes(lang) ? lang : 'en';
                document.documentElement.lang = state.uiLang;
                document.documentElement.dir = dirFor(state.uiLang);
                document.body.classList.toggle('rtl', state.uiLang !== 'en');

                const t = getT(state.uiLang);
                const setText = (selector, value) => {
                    const element = document.querySelector(selector);
                    if (element) {
                        element.textContent = value;
                    }
                };

                const setAllText = (selector, value) => {
                    document.querySelectorAll(selector).forEach((element) => {
                        element.textContent = value;
                    });
                };

                setText('[data-role="app-title"]', t.appTitle);
                setText('[data-role="app-tagline"]', t.appTagline);
                setText('[data-role="hero-title"]', t.heroTitle);
                setAllText('[data-role="hero-description"]', t.heroDescription);
                setText('[data-role="ui-language-label"]', t.uiLanguage);
                setText('[data-role="product-type-label"]', t.productTypeLabel);
                setText('[data-role="output-language-label"]', t.outputLanguage);
                setText('[data-role="product-description-label"]', t.productDescriptionLabel);
                const descriptionField = document.querySelector('[data-role="product-description"]');
                if (descriptionField) {
                    descriptionField.placeholder = t.productDescriptionPlaceholder;
                }
                setText('[data-role="generate-button"]', t.generateButton);
                setText('[data-role="reset-button"]', t.resetButton);
                setText('[data-role="result-title"]', t.resultTitle);
                setText('[data-role="caption-title"]', t.captionTitle);
                setText('[data-role="hashtags-title"]', t.hashtagsTitle);
                setText('[data-role="history-empty"]', t.historyEmpty);
                setText('[data-role="history-clear"]', t.historyClear);
                setText('[data-role="history-hint"]', t.historyHint);
                setAllText('[data-role="loading-text"]', t.loadingText);
                setText('[data-role="error-missing-api"]', t.errorMissingApi);
                setText('[data-role="error-failed"]', t.errorFailed);
                setAllText('[data-role="no-db"]', t.noDb);
                setAllText('[data-role="file-history"]', t.fileHistory);
                setAllText('[data-role="multilingual"]', t.multilingual);
                setAllText('[data-role="one-page"]', t.onePage);
                setAllText('[data-role="analysis-label"]', t.analysisLabel);
                setAllText('[data-role="hero-badge"]', t.heroBadge);
                setAllText('[data-role="history-title"]', t.historyTitle);
                setAllText('[data-role="footer-text"]', t.footer);
                setAllText('[data-role="copy-all"]', t.copyAll);
                setText('[data-role="suggestion-title"]', t.suggestionTitle);

                document.querySelectorAll('[data-product-option]').forEach((option) => {
                    option.textContent = t.products[option.value] || option.textContent;
                });

                setAllText('[data-role="language-en"]', t.languageEnglish);
                setAllText('[data-role="language-fa"]', t.languagePersian);
                setAllText('[data-role="language-ar"]', t.languageArabic);

                uiLanguageSwitcher.value = state.uiLang;
                setUrlLang(state.uiLang);

                if (!productDescription.value) {
                    emptyResultState.classList.remove('hidden');
                    resultState.classList.add('hidden');
                }
            };

            const setLoading = (isLoading) => {
                loadingState.classList.toggle('hidden', !isLoading);
                form.querySelector('button[type="submit"]').disabled = isLoading;
                form.querySelector('button[type="submit"]').classList.toggle('opacity-80', isLoading);
                form.querySelector('button[type="submit"]').classList.toggle('cursor-wait', isLoading);
            };

            const setError = (message) => {
                errorText.textContent = message;
                errorState.classList.remove('hidden');
            };

            const clearError = () => {
                errorState.classList.add('hidden');
                errorText.textContent = '';
            };

            const formatHashtags = (hashtags) => hashtags.join(' ');

            const renderResult = (payload) => {
                state.result = payload;
                angleText.textContent = payload.angle || '';
                suggestionText.textContent = payload.suggestion || '';
                captionText.textContent = payload.caption || '';
                hashtagsWrap.innerHTML = '';

                (payload.hashtags || []).forEach((tag) => {
                    const chip = document.createElement('span');
                    chip.className = 'inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-sm font-semibold text-slate-700';
                    chip.textContent = tag;
                    hashtagsWrap.appendChild(chip);
                });

                emptyResultState.classList.add('hidden');
                resultState.classList.remove('hidden');
            };

            const historyCardMarkup = (item) => {
                const productLabel = getT().products[item.product_type] || item.product_type;
                const languageLabel = {
                    en: getT().languageEnglish,
                    fa: getT().languagePersian,
                    ar: getT().languageArabic
                }[item.caption_language] || item.caption_language;

                return `
                    <article class="rounded-[1.35rem] border border-slate-200/80 bg-white/80 p-4 transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-lg">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="flex flex-wrap items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">
                                    <span>${escapeHtml(productLabel)}</span>
                                    <span>•</span>
                                    <span>${escapeHtml(languageLabel)}</span>
                                </div>
                                <p class="mt-2 text-sm leading-7 text-slate-700">${escapeHtml((item.generated_suggestion || '').slice(0, 140))}</p>
                            </div>
                            <button type="button" class="history-copy rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 transition hover:border-slate-300" data-history-index="${escapeHtml(String(item._index))}">
                                <i class="fa-solid fa-copy mr-1"></i>
                                ${escapeHtml(getT().copyAll)}
                            </button>
                        </div>
                        <div class="mt-4 rounded-2xl bg-slate-50 p-4">
                            <p class="line-clamp-4 text-sm leading-7 text-slate-600">${escapeHtml(item.generated_caption || '')}</p>
                            <p class="mt-3 text-xs font-semibold text-cyan-700">${escapeHtml(item.generated_hashtags || '')}</p>
                        </div>
                    </article>
                `;
            };

            const renderHistory = (items) => {
                state.history = Array.isArray(items) ? items : [];

                if (!state.history.length) {
                    historyList.innerHTML = `
                        <div class="rounded-[1.35rem] border border-dashed border-slate-200 bg-white/70 p-5 text-sm text-slate-500">
                            ${escapeHtml(getT().historyEmpty)}
                        </div>
                    `;
                    return;
                }

                historyList.innerHTML = state.history
                    .map((item, index) => historyCardMarkup({ ...item, _index: index }))
                    .join('');

                historyList.querySelectorAll('.history-copy').forEach((button) => {
                    button.addEventListener('click', async () => {
                        const idx = Number(button.getAttribute('data-history-index'));
                        const item = state.history[idx];
                        if (!item) return;
                        const text = `${item.generated_caption || ''}\n\n${item.generated_hashtags || ''}\n\n${item.generated_suggestion || ''}`;
                        await navigator.clipboard.writeText(text.trim());
                        showToast(getT().successCopied);
                    });
                });
            };

            const loadHistory = async () => {
                try {
                    const response = await fetch('/history', {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    const data = await response.json();
                    renderHistory(data.items || []);
                } catch (error) {
                    renderHistory([]);
                }
            };

            const copyText = async (text) => {
                await navigator.clipboard.writeText(text);
                showToast(getT().successCopied);
            };

            document.querySelectorAll('.copy-btn').forEach((button) => {
                button.addEventListener('click', async () => {
                    if (!state.result) return;
                    const target = button.getAttribute('data-copy-target');
                    const t = getT();
                    if (target === 'caption') {
                        await copyText(state.result.caption || '');
                    } else if (target === 'hashtags') {
                        await copyText(formatHashtags(state.result.hashtags || []));
                    } else if (target === 'angle') {
                        await copyText(`${state.result.angle || ''}\n\n${state.result.suggestion || ''}`.trim());
                    }
                });
            });

            uiLanguageSwitcher.addEventListener('change', (event) => {
                applyLanguage(event.target.value);
                loadHistory();
            });

            resetButton.addEventListener('click', () => {
                form.reset();
                clearError();
                state.result = null;
                captionLanguage.value = state.uiLang;
                emptyResultState.classList.remove('hidden');
                resultState.classList.add('hidden');
            });

            clearHistoryButton.addEventListener('click', async () => {
                try {
                    await fetch('/history', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });
                    await loadHistory();
                    showToast(getT().historyCleared);
                } catch (error) {
                    setError(getT().errorFailed);
                }
            });

            copyAllButton.addEventListener('click', async () => {
                if (!state.result) return;
                const text = [
                    state.result.caption || '',
                    formatHashtags(state.result.hashtags || []),
                    state.result.suggestion || ''
                ].filter(Boolean).join('\n\n');
                await copyText(text);
            });

            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                clearError();
                setLoading(true);

                const payload = {
                    product_type: productType.value,
                    caption_language: captionLanguage.value,
                    product_description: productDescription.value.trim()
                };

                try {
                    const response = await fetch('/generate-caption', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || getT().errorFailed);
                    }

                    renderResult(data);
                    await loadHistory();
                    showToast(getT().successGenerated);
                } catch (error) {
                    setError(error.message || getT().errorFailed);
                } finally {
                    setLoading(false);
                }
            });

            const initialLang = new URL(window.location.href).searchParams.get('lang') || '{{ $initialLang ?? 'en' }}';
            applyLanguage(initialLang);
            captionLanguage.value = state.uiLang;
            uiLanguageSwitcher.value = state.uiLang;

            loadHistory();
        });
    </script>
</body>
</html>
