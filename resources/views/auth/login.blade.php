<x-guest-layout>
    <div class="flex min-h-screen">
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-100">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <a href="/" class="text-4xl font-bold text-amber-600">دستور پخت من</a>
                    <p class="mt-3 text-gray-500">دوباره خوش آمدید! وارد حساب خود شوید</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg">

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    @if (session('error'))
                        <div class="mb-4 font-medium text-sm text-red-700 bg-red-100 p-4 rounded-lg" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="email" value="آدرس ایمیل" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <div class="flex justify-between items-center">
                                <x-input-label for="password" value="رمز عبور" />
                                @if (Route::has('password.request'))
                                    <a class="text-sm text-gray-600 hover:underline" href="{{ route('password.request') }}">
                                        فراموش کرده‌اید؟
                                    </a>
                                @endif
                            </div>
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="block">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500" name="remember">
                                <span class="mr-2 text-sm text-gray-600">مرا به خاطر بسپار</span>
                            </label>
                        </div>

                        <div>
                            <x-primary-button class="w-full justify-center">
                                ورود به حساب کاربری
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        هنوز حساب کاربری ندارید؟
                        <a class="font-semibold text-amber-600 hover:underline" href="{{ route('register') }}">
                            ثبت نام کنید
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="hidden lg:block w-1/2 bg-cover bg-center" style="background-image: url({{ asset('images/login-bg.jpg') }});">
        </div>
    </div>
</x-guest-layout>
