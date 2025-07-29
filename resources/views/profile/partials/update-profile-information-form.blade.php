<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            اطلاعات پروفایل
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            اطلاعات پروفایل و آدرس ایمیل حساب خود را به‌روز کنید.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        @if ($user->profile_image_path)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $user->profile_image_path) }}" alt="عکس پروفایل" class="w-24 h-24 rounded-full object-cover">
            </div>
        @endif

        <div>
            <x-input-label for="profile_image" value="تغییر عکس پروفایل" />
            <input type="file" id="profile_image" name="profile_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
            <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
        </div>

        <div>
            <x-input-label for="name" value="نام" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="ایمیل" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        آدرس ایمیل شما تایید نشده است.
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            برای ارسال مجدد ایمیل تایید اینجا کلیک کنید.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            یک لینک تایید جدید به آدرس ایمیل شما ارسال شد.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>ذخیره</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">ذخیره شد.</p>
            @endif
        </div>
    </form>
</section>
