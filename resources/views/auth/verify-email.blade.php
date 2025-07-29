<x-guest-layout>
    <div class="flex min-h-screen">

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-100">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <a href="/" class="text-4xl font-bold text-amber-600">دستور پخت من</a>
                    <p class="mt-3 text-gray-500">فقط یک قدم دیگر باقی مانده!</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-lg">
                    <div class="mb-4 text-sm text-gray-600">
                        از ثبت‌نام شما متشکریم! قبل از شروع، لطفاً با کلیک بر روی لینکی که به تازگی برایتان ایمیل کرده‌ایم، آدرس ایمیل خود را تأیید کنید. اگر ایمیلی دریافت نکرده‌اید، با کمال میل ایمیل دیگری برایتان ارسال خواهیم کرد.
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            یک لینک تأیید جدید به آدرس ایمیلی که هنگام ثبت‌ نام ارائه دادید، ارسال شد.
                        </div>
                    @endif

                    <div class="mt-6 flex items-center justify-between">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <x-primary-button>
                                ارسال مجدد ایمیل تایید
                            </x-primary-button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                خروج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden lg:block w-1/2 bg-cover bg-center" style="background-image: url({{ asset('images/register-bg.jpg') }});">
        </div>
    </div>
</x-guest-layout>
