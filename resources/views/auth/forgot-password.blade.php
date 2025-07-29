<x-guest-layout>
    <div class="flex min-h-screen">
        <!-- بخش فرم  -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-100">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <a href="/" class="text-4xl font-bold text-amber-600">دستور پخت من</a>
                    <p class="mt-3 text-gray-500">بازیابی رمز عبور</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <div class="mb-4 text-sm text-gray-600">
                        رمز عبور خود را فراموش کرده‌اید؟ مشکلی نیست. فقط آدرس ایمیل خود را به ما اطلاع دهید تا یک لینک بازنشانی رمز عبور برایتان ارسال کنیم که به شما امکان می‌دهد یک رمز جدید انتخاب کنید.
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" value="آدرس ایمیل" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-primary-button class="w-full justify-center">
                                ارسال لینک بازنشانی رمز عبور
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        <a class="font-semibold text-amber-600 hover:underline" href="{{ route('login') }}">
                            بازگشت به صفحه ورود
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="hidden lg:block w-1/2 bg-cover bg-center" style="background-image: url({{ asset('images/forgot-password-bg.jpg') }});">
        </div>
    </div>
</x-guest-layout>
