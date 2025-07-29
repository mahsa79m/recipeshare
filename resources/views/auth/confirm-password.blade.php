<x-guest-layout>
    <div class="flex min-h-screen">

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-100">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <a href="/" class="text-4xl font-bold text-amber-600">دستور پخت من</a>
                    <p class="mt-3 text-gray-500">تایید هویت</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <div class="mb-4 text-sm text-gray-600">
                        این یک بخش امن برنامه است. لطفاً قبل از ادامه، رمز عبور خود را تأیید کنید.
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                        @csrf

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" value="رمز عبور" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-primary-button class="w-full justify-center">
                                تایید
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="hidden lg:block w-1/2 bg-cover bg-center" style="background-image: url({{ asset('images/login-bg.jpg') }});">
        </div>
    </div>
</x-guest-layout>
