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
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .fade-in-delay-1 { animation-delay: 0.05s; }
        .fade-in-delay-2 { animation-delay: 0.1s; }
        .fade-in-delay-3 { animation-delay: 0.15s; }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .dropdown-content {
            display: none;
            animation: slideDown 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            transform-origin: top;
        }

        .dropdown-content.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .char-counter {
            font-variant-numeric: tabular-nums;
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

    <header class="sticky top-0 z-50 border-b border-white/40 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="icon-pill h-9 w-9 bg-[#0D47A1] text-white shadow-lg shadow-blue-200/60 sm:h-11 sm:w-11">
                    <i class="fa-solid fa-wand-magic-sparkles text-sm sm:text-base"></i>
                </div>
                <h1 class="text-base font-black tracking-tight text-slate-900 sm:text-xl">
                    <span data-role="app-title">{{ __('app_title') }}</span>
                </h1>
            </div>

            <div class="relative" id="languageDropdown">
                <button type="button" id="langBtn" class="flex items-center gap-2 rounded-xl border border-slate-200/80 bg-white/90 py-2 pl-3 pr-2.5 text-xs font-bold text-slate-800 transition hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-100 sm:rounded-full sm:px-4 sm:text-sm">
                <i class="fa-solid fa-globe text-blue-600"></i>    
                <span id="currentLangName">English</span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200" id="langChevron"></i>
                </button>
                <div id="langMenu" class="dropdown-content absolute right-0 rtl:right-auto rtl:left-0 mt-2 w-40 rounded-2xl border border-slate-200/80 bg-white p-1.5 shadow-2xl ring-1 ring-black/5 sm:w-48">
                    <button type="button" data-lang="en" class="lang-option flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-start text-xs font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-blue-600 sm:text-sm">
                        <span class="flex h-5 w-5 items-center justify-center rounded-md bg-slate-100 text-[10px]">🇺🇸</span>
                        <span data-role="language-en">English</span>
                    </button>
                    <button type="button" data-lang="fa" class="lang-option flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-start text-xs font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-blue-600 sm:text-sm" dir="rtl">
                        <span class="flex h-5 w-5 items-center justify-center rounded-md bg-slate-100 text-[10px]">🇮🇷</span>
                        <span data-role="language-fa">فارسی</span>
                    </button>
                    <button type="button" data-lang="ar" class="lang-option flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-start text-xs font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-blue-600 sm:text-sm" dir="rtl">
                        <span class="flex h-5 w-5 items-center justify-center rounded-md bg-slate-100 text-[10px]">🇸🇦</span>
                        <span data-role="language-ar">العربية</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="relative mx-auto w-full max-w-4xl px-3 py-4 sm:px-6 lg:max-w-6xl lg:px-8 lg:py-10">
        <section class="glass fade-in soft-border rounded-3xl p-4 sm:rounded-[2.5rem] sm:p-7 lg:p-10">
            <div class="max-w-3xl">
                <h2 class="text-2xl font-black tracking-tight text-slate-900 sm:text-5xl" data-role="hero-title">{{ __('hero_title') }}</h2>
                <p class="mt-3 text-sm leading-7 text-slate-500 sm:mt-4 sm:text-lg sm:leading-8" data-role="hero-description">{{ __('hero_description') }}</p>
            </div>

            <form id="captionForm" class="mt-6 space-y-4 sm:mt-8 sm:space-y-5">
                <div class="grid gap-4 md:grid-cols-2 sm:gap-5">
                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-xs font-bold text-slate-700 sm:text-sm" for="productType" data-role="product-type-label">{{ __('product_type_label') }}</label>
                        <div class="relative group">
                            <select id="productType" class="input-surface w-full appearance-none rounded-2xl border border-slate-200/80 pl-4 pr-10 rtl:pl-10 rtl:pr-4 py-3.5 text-sm font-semibold text-slate-800 outline-none transition focus:border-[#0D47A1] focus:ring-4 focus:ring-blue-100 sm:rounded-[1.25rem] sm:py-4 sm:text-base">
                                <option value="fashion" data-product-option>{{ __('product_fashion') }}</option>
                                <option value="electronics" data-product-option>{{ __('product_electronics') }}</option>
                                <option value="beauty" data-product-option>{{ __('product_beauty') }}</option>
                                <option value="home" data-product-option>{{ __('product_home') }}</option>
                                <option value="kitchen" data-product-option>{{ __('product_kitchen') }}</option>
                                <option value="food" data-product-option>{{ __('product_food') }}</option>
                                <option value="jewelry" data-product-option>{{ __('product_jewelry') }}</option>
                                <option value="sports" data-product-option>{{ __('product_sports') }}</option>
                                <option value="automotive" data-product-option>{{ __('product_automotive') }}</option>
                                <option value="kids" data-product-option>{{ __('product_kids') }}</option>
                                <option value="health" data-product-option>{{ __('product_health') }}</option>
                                <option value="office" data-product-option>{{ __('product_office') }}</option>
                                <option value="pets" data-product-option>{{ __('product_pets') }}</option>
                                <option value="toys" data-product-option>{{ __('product_toys') }}</option>
                                <option value="travel" data-product-option>{{ __('product_travel') }}</option>
                                <option value="phones" data-product-option>{{ __('product_phones') }}</option>
                                <option value="computers" data-product-option>{{ __('product_computers') }}</option>
                                <option value="books" data-product-option>{{ __('product_books') }}</option>
                                <option value="gifts" data-product-option>{{ __('product_gifts') }}</option>
                                <option value="others" data-product-option>{{ __('product_others') }}</option>
                            </select>
                            <i class="fa-solid fa-caret-down pointer-events-none absolute inset-y-0 right-4 rtl:right-auto rtl:left-4 flex items-center text-slate-400 transition-colors group-focus-within:text-blue-500"></i>
                        </div>
                    </div>

                    <div class="space-y-1.5 sm:space-y-2">
                        <label class="text-xs font-bold text-slate-700 sm:text-sm" for="captionLanguage" data-role="output-language-label">{{ __('output_language') }}</label>
                        <div class="relative group">
                            <select id="captionLanguage" class="input-surface w-full appearance-none rounded-2xl border border-slate-200/80 pl-4 pr-10 rtl:pl-10 rtl:pr-4 py-3.5 text-sm font-semibold text-slate-800 outline-none transition focus:border-[#0D47A1] focus:ring-4 focus:ring-blue-100 sm:rounded-[1.25rem] sm:py-4 sm:text-base">
                                <option value="en" data-role="language-en">{{ __('language_english') }}</option>
                                <option value="fa" data-role="language-fa">{{ __('language_persian') }}</option>
                                <option value="ar" data-role="language-ar">{{ __('language_arabic') }}</option>
                                <option value="es" data-role="language-es">{{ __('language_spanish') }}</option>
                                <option value="fr" data-role="language-fr">{{ __('language_french') }}</option>
                                <option value="de" data-role="language-de">{{ __('language_german') }}</option>
                                <option value="tr" data-role="language-tr">{{ __('language_turkish') }}</option>
                                <option value="ur" data-role="language-ur">{{ __('language_urdu') }}</option>
                                <option value="hi" data-role="language-hi">{{ __('language_hindi') }}</option>
                                <option value="ru" data-role="language-ru">{{ __('language_russian') }}</option>
                            </select>
                            <i class="fa-solid fa-caret-down pointer-events-none absolute inset-y-0 right-4 rtl:right-auto rtl:left-4 flex items-center text-slate-400 transition-colors group-focus-within:text-blue-500"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5 sm:space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-slate-700 sm:text-sm" for="productDescription" data-role="product-description-label">{{ __('product_description_label') }}</label>
                        <span id="charCount" class="char-counter text-[10px] font-bold text-slate-400 sm:text-xs">0 / 1000</span>
                    </div>
                    <textarea
                        id="productDescription"
                        data-role="product-description"
                        rows="5"
                        maxlength="1000"
                        class="input-surface w-full rounded-2xl border border-slate-200/80 px-4 py-3.5 text-sm leading-7 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#0D47A1] focus:ring-4 focus:ring-blue-100 sm:rounded-[1.5rem] sm:px-4 sm:py-4 sm:text-base sm:leading-8"
                        placeholder="{{ __('product_description_placeholder') }}"
                    ></textarea>
                </div>

                <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:pt-4">
                    <button type="submit" class="primary-button group relative inline-flex items-center justify-center gap-3 overflow-hidden rounded-2xl px-6 py-4 text-sm font-bold text-white transition-all hover:scale-[1.01] active:scale-95 sm:rounded-[1.35rem] sm:text-base">
                        <i class="fa-solid fa-sparkles transition-transform group-hover:rotate-12 group-hover:scale-110"></i>
                        <span data-role="generate-button">{{ __('generate_button') }}</span>
                    </button>
                    <button type="button" id="resetButton" class="inline-flex items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white/80 px-6 py-4 text-sm font-bold text-slate-700 transition hover:scale-[1.01] hover:border-slate-300 active:scale-95 sm:rounded-[1.35rem] sm:text-base">
                        <i class="fa-solid fa-rotate-left transition-transform active:rotate-180"></i>
                        <span data-role="reset-button">{{ __('reset_button') }}</span>
                    </button>
                </div>
            </form>

            <div id="loadingState" class="mt-4 hidden rounded-2xl border border-blue-100 bg-blue-50/60 p-4 sm:mt-6 sm:rounded-[1.5rem] sm:p-5">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl border-4 border-blue-100 border-t-[#0D47A1] animate-spin sm:h-11 sm:w-11 sm:rounded-2xl"></div>
                    <div>
                        <p class="text-sm font-bold text-slate-900 sm:text-base" data-role="loading-text">{{ __('loading_text') }}</p>
                    </div>
                </div>
            </div>

            <div id="errorState" class="mt-4 hidden rounded-2xl border border-rose-200 bg-rose-50/80 p-4 text-rose-700 sm:mt-6 sm:rounded-[1.5rem] sm:p-5">
                <div class="flex items-start gap-3">
                    <div class="icon-pill h-9 w-9 bg-rose-100 text-rose-600 sm:h-11 sm:w-11">
                        <i class="fa-solid fa-triangle-exclamation text-sm sm:text-base"></i>
                    </div>
                    <div class="text-xs font-semibold leading-6 sm:text-sm sm:leading-7">
                        <p id="errorText"></p>
                    </div>
                </div>
            </div>

            <div id="resultState" class="mt-4 hidden space-y-3 sm:mt-6 sm:space-y-4">
                <div class="grid gap-3 lg:grid-cols-2 sm:gap-4">
                    <div class="rounded-2xl border border-slate-200/80 bg-white/85 p-4 sm:rounded-[1.5rem] sm:p-5">
                        <div class="flex items-center justify-between gap-3">
                            <h4 class="text-sm font-black text-slate-900 sm:text-base" data-role="caption-title">{{ __('caption_title') }}</h4>
                            <button type="button" data-copy-target="caption" class="copy-btn inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-2.5 py-1.5 text-[10px] font-bold text-slate-700 transition hover:border-slate-300 sm:px-3 sm:py-2 sm:text-xs">
                                <i class="fa-solid fa-copy"></i>
                                <span>{{ __('copy_caption') }}</span>
                            </button>
                        </div>
                        <p id="captionText" class="mt-3 whitespace-pre-wrap text-xs leading-7 text-slate-700 sm:mt-4 sm:text-sm sm:leading-8"></p>
                    </div>

                    <div class="rounded-2xl border border-slate-200/80 bg-white/85 p-4 sm:rounded-[1.5rem] sm:p-5">
                        <div class="flex items-center justify-between gap-3">
                            <h4 class="text-sm font-black text-slate-900 sm:text-base" data-role="hashtags-title">{{ __('hashtags_title') }}</h4>
                            <button type="button" data-copy-target="hashtags" class="copy-btn inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-2.5 py-1.5 text-[10px] font-bold text-slate-700 transition hover:border-slate-300 sm:px-3 sm:py-2 sm:text-xs">
                                <i class="fa-solid fa-copy"></i>
                                <span>{{ __('copy_hashtags') }}</span>
                            </button>
                        </div>
                        <div id="hashtagsWrap" class="mt-3 flex flex-wrap gap-1.5 sm:mt-4 sm:gap-2"></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200/80 bg-white/85 p-4 sm:rounded-[1.5rem] sm:p-5">
                    <div class="flex flex-col gap-1.5 sm:gap-2">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-cyan-600 sm:text-xs" data-role="analysis-label">{{ __('analysis_label') }}</p>
                        <h4 id="angleText" class="text-base font-black text-slate-900 sm:text-lg"></h4>
                    </div>
                    <p id="suggestionText" class="mt-3 text-xs leading-6 text-slate-600 sm:mt-4 sm:text-sm sm:leading-7"></p>
                </div>

                <button type="button" id="copyAllButton" class="primary-button inline-flex w-full items-center justify-center gap-3 rounded-2xl px-6 py-4 text-sm font-bold text-white transition hover:scale-[1.01] active:scale-95 sm:rounded-[1.35rem] sm:text-base">
                    <i class="fa-solid fa-clone"></i>
                    <span data-role="copy-all">{{ __('copy_all') }}</span>
                </button>
            </div>

            <div id="emptyResultState" class="mt-6 hidden"></div>

        </section>
    </main>

    <div id="toast" class="pointer-events-none fixed bottom-4 right-4 z-50 translate-y-6 opacity-0 transition duration-300 sm:bottom-6 sm:right-6">
        <div class="glass-dark flex items-center gap-3 rounded-full px-4 py-3 text-white shadow-2xl">
            <i id="toastIcon" class="fa-solid fa-circle-check text-emerald-400"></i>
            <span id="toastText" class="text-xs font-semibold sm:text-sm"></span>
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
                languageSpanish: "Spanish",
                languageFrench: "French",
                languageGerman: "German",
                languageTurkish: "Turkish",
                languageUrdu: "Urdu",
                languageHindi: "Hindi",
                languageRussian: "Russian",
                products: {
                    fashion: "Fashion & apparel",
                    electronics: "Electronics",
                    beauty: "Beauty & cosmetics",
                    home: "Home & living",
                    kitchen: "Kitchen & dining",
                    food: "Food & beverage",
                    jewelry: "Jewelry",
                    sports: "Sports & outdoors",
                    automotive: "Automotive",
                    kids: "Kids & baby",
                    health: "Health & wellness",
                    office: "Office supplies",
                    pets: "Pet supplies",
                    toys: "Toys & games",
                    travel: "Travel & luggage",
                    phones: "Phones & accessories",
                    computers: "Computers & accessories",
                    books: "Books & stationery",
                    gifts: "Gifts & occasions",
                    others: "Other"
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
                languageSpanish: "اسپانیایی",
                languageFrench: "فرانسوی",
                languageGerman: "آلمانی",
                languageTurkish: "ترکی",
                languageUrdu: "اردو",
                languageHindi: "هندی",
                languageRussian: "روسی",
                products: {
                    fashion: "مد و پوشاک",
                    electronics: "لوازم الکترونیکی",
                    beauty: "زیبایی و آرایشی",
                    home: "خانه و زندگی",
                    kitchen: "آشپزخانه و پذیرایی",
                    food: "خوراکی و نوشیدنی",
                    jewelry: "زیورآلات",
                    sports: "ورزش و فضای باز",
                    automotive: "خودرو و لوازم جانبی",
                    kids: "کودک و نوزاد",
                    health: "سلامت و تندرستی",
                    office: "لوازم اداری",
                    pets: "لوازم حیوانات خانگی",
                    toys: "اسباب‌بازی و بازی",
                    travel: "سفر و چمدان",
                    phones: "موبایل و لوازم جانبی",
                    computers: "کامپیوتر و لوازم جانبی",
                    books: "کتاب و نوشت‌افزار",
                    gifts: "هدیه و مناسبت‌ها",
                    others: "سایر"
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
                languageSpanish: "الإسبانية",
                languageFrench: "الفرنسية",
                languageGerman: "الألمانية",
                languageTurkish: "التركية",
                languageUrdu: "الأردية",
                languageHindi: "الهندية",
                languageRussian: "الروسية",
                products: {
                    fashion: "الأزياء والملابس",
                    electronics: "الإلكترونيات",
                    beauty: "الجمال ومستحضرات التجميل",
                    home: "المنزل والديكور",
                    kitchen: "المطبخ والمائدة",
                    food: "الأطعمة والمشروبات",
                    jewelry: "المجوهرات",
                    sports: "الرياضة والأنشطة الخارجية",
                    automotive: "السيارات والإكسسوارات",
                    kids: "الأطفال والرضع",
                    health: "الصحة والعافية",
                    office: "مستلزمات المكتب",
                    pets: "مستلزمات الحيوانات الأليفة",
                    toys: "الألعاب",
                    travel: "السفر والحقائب",
                    phones: "الهواتف والإكسسوارات",
                    computers: "الكمبيوتر والإكسسوارات",
                    books: "الكتب والقرطاسية",
                    gifts: "الهدايا والمناسبات",
                    others: "أخرى"
                }
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const langBtn = document.getElementById('langBtn');
            const langMenu = document.getElementById('langMenu');
            const langChevron = document.getElementById('langChevron');
            const currentLangName = document.getElementById('currentLangName');
            const productType = document.getElementById('productType');
            const captionLanguage = document.getElementById('captionLanguage');
            const productDescription = document.getElementById('productDescription');
            const charCount = document.getElementById('charCount');
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

            // Custom Dropdown Logic
            langBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                langMenu.classList.toggle('show');
                langChevron.classList.toggle('rotate-180');
            });

            document.addEventListener('click', () => {
                langMenu.classList.remove('show');
                langChevron.classList.remove('rotate-180');
            });

            document.querySelectorAll('.lang-option').forEach(option => {
                option.addEventListener('click', () => {
                    const lang = option.getAttribute('data-lang');
                    applyLanguage(lang);
                    loadHistory();
                    langMenu.classList.remove('show');
                    langChevron.classList.remove('rotate-180');
                });
            });

            // Char Counter Logic
            productDescription.addEventListener('input', () => {
                const len = productDescription.value.length;
                charCount.textContent = `${len} / 1000`;
                charCount.classList.toggle('text-rose-500', len >= 1000);
            });

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
                
                // Update Current Lang Name in Button
                const langLabels = {
                    en: t.languageEnglish,
                    fa: t.languagePersian,
                    ar: t.languageArabic
                };
                currentLangName.textContent = langLabels[state.uiLang];

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
                setAllText('[data-role="language-es"]', t.languageSpanish);
                setAllText('[data-role="language-fr"]', t.languageFrench);
                setAllText('[data-role="language-de"]', t.languageGerman);
                setAllText('[data-role="language-tr"]', t.languageTurkish);
                setAllText('[data-role="language-ur"]', t.languageUrdu);
                setAllText('[data-role="language-hi"]', t.languageHindi);
                setAllText('[data-role="language-ru"]', t.languageRussian);

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
                    ar: getT().languageArabic,
                    es: getT().languageSpanish,
                    fr: getT().languageFrench,
                    de: getT().languageGerman,
                    tr: getT().languageTurkish,
                    ur: getT().languageUrdu,
                    hi: getT().languageHindi,
                    ru: getT().languageRussian,
                }[item.caption_language] || item.caption_language;

                return `
                    <article class="rounded-2xl border border-slate-200/80 bg-white/80 p-3.5 transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-lg sm:rounded-[1.35rem] sm:p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400 sm:gap-2 sm:text-[11px] sm:tracking-[0.18em]">
                                    <span class="truncate">${escapeHtml(productLabel)}</span>
                                    <span>•</span>
                                    <span>${escapeHtml(languageLabel)}</span>
                                </div>
                                <p class="mt-1.5 line-clamp-2 text-xs leading-6 text-slate-700 sm:mt-2 sm:text-sm sm:leading-7">${escapeHtml(item.generated_suggestion || '')}</p>
                            </div>
                            <button type="button" class="history-copy flex-shrink-0 rounded-xl border border-slate-200 bg-white p-2 text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 active:scale-95 sm:rounded-full sm:px-3 sm:py-2 sm:text-xs sm:font-bold" data-history-index="${escapeHtml(String(item._index))}">
                                <i class="fa-solid fa-copy sm:mr-1"></i>
                                <span class="hidden sm:inline">${escapeHtml(getT().copyAll)}</span>
                            </button>
                        </div>
                        <div class="mt-3 rounded-xl bg-slate-50 p-3 sm:mt-4 sm:rounded-2xl sm:p-4">
                            <p class="line-clamp-3 text-xs leading-6 text-slate-600 sm:line-clamp-4 sm:text-sm sm:leading-7">${escapeHtml(item.generated_caption || '')}</p>
                            <p class="mt-2 text-[10px] font-semibold text-cyan-700 sm:mt-3 sm:text-xs">${escapeHtml(item.generated_hashtags || '')}</p>
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

            resetButton.addEventListener('click', () => {
                form.reset();
                clearError();
                state.result = null;
                charCount.textContent = '0 / 1000';
                charCount.classList.remove('text-rose-500');
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

            resetButton.addEventListener('click', () => {
                form.reset();
                clearError();
                state.result = null;
                charCount.textContent = '0 / 1000';
                charCount.classList.remove('text-rose-500');
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
                        const message = data.details
                            ? `${data.error || getT().errorFailed}: ${data.details}`
                            : (data.error || getT().errorFailed);

                        throw new Error(message);
                    }

                    renderResult(data);
                    
                    // Smooth scroll to result
                    setTimeout(() => {
                        resultState.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start',
                            inline: 'nearest' 
                        });
                    }, 100);

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

            loadHistory();
        });
    </script>
</body>
</html>
