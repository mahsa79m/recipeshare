<x-guest-layout>
    <div class="flex min-h-screen">
        <!-- بخش فرم  -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-100">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <a href="/" class="text-4xl font-bold text-amber-600">دستور پخت من</a>
                    <p class="mt-3 text-gray-500">به بزرگترین جامعه آشپزی ایران بپیوندید</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" value=" اسم اکانت " />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="email" value="آدرس ایمیل" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="password" value="رمز عبور" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" value="تکرار رمز عبور" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                        <div>
                            <x-primary-button class="w-full justify-center">
                                ساخت حساب کاربری
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        قبلاً ثبت‌ نام کرده‌اید؟
                        <a class="font-semibold text-amber-600 hover:underline" href="{{ route('login') }}">
                            وارد شوید
                        </a>
                    </p>
                </div>
            </div>
        </div>


        <div class="hidden lg:block w-1/2 bg-cover bg-center" style="background-image: url({{ asset('images/register-bg.jpg') }});">
        </div>
    </div>
</x-guest-layout>
