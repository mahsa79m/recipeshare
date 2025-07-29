<x-guest-layout>
    <div class="flex min-h-screen">

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-100">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <a href="/" class="text-4xl font-bold text-amber-600">دستور پخت من</a>
                    <p class="mt-3 text-gray-500">رمز عبور جدید خود را تنظیم کنید</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" value="آدرس ایمیل" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" value="رمز عبور جدید" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" value="تکرار رمز عبور جدید" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div>
                            <x-primary-button class="w-full justify-center">
                                بازنشانی رمز عبور
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="hidden lg:block w-1/2 bg-cover bg-center" style="background-image: url({{ asset('images/forgot-password-bg.jpg') }});">
        </div>
    </div>
</x-guest-layout>
