<footer class="bg-gray-800 text-white mt-12" dir="rtl">
    <div class="container mx-auto px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-right">

            <!-- بخش درباره ما -->
            <div>
                <h3 class="text-lg font-bold mb-4">دستور پخت من</h3>
                <p class="text-sm text-gray-400">
                    اینجا یک دنیای خوشمزه ایه، برای اشتراک‌گذاری و کشف دستورهای غذایی جدید و خلاقانه شما. به جمع گرم ما بپیوندید و هنر آشپزی خود را به نمایش بذارید.
                </p>
            </div>

            <!-- بخش لینک‌های سریع -->
            <div>
                <h3 class="text-md font-semibold mb-4">لینک‌های سریع</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('recipes.index') }}" class="text-gray-400 hover:text-white transition-colors">تمام دستورها</a></li>
                    <li><a href="{{ route('pages.about') }}" class="text-gray-400 hover:text-white transition-colors">درباره ما</a></li>
                    <li><a href="{{ route('pages.contact') }}" class="text-gray-400 hover:text-white transition-colors">تماس با ما</a></li>
                    <li><a href="{{ route('pages.faq') }}" class="text-gray-400 hover:text-white transition-colors">سوالات متداول</a></li>
                </ul>
            </div>

            <!-- بخش شبکه‌های اجتماعی -->
            <div>
                <h3 class="text-md font-semibold mb-4">ما را دنبال کنید</h3>
                <div class="flex justify-center md:justify-start space-x-4 space-x-reverse">
                    {{-- لینک کانال تلگرام با آیدی ashpazimah3a --}}
                    <a href="https://t.me/ashpazimah3a" target="_blank" class="text-gray-400 hover:text-white transition-colors">تلگرام</a>
                    {{-- اگر لینک اینستاگرام دارید، اینجا اضافه کنید --}}
                    {{-- <a href="#" class="text-gray-400 hover:text-white transition-colors">اینستاگرام</a> --}}
                </div>
            </div>

        </div>

        <!-- بخش کپی رایت -->
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-500 text-xs">
            <p>&copy; {{ date('Y') }} دستور پخت من. تمام حقوق محفوظ است.</p>
        </div>
    </div>
</footer>
