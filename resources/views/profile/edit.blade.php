<x-hub-layout>
    <x-slot name="header">
        ویرایش پروفایل و تنظیمات
    </x-slot>
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{
            tab: new URLSearchParams(window.location.search).get('tab') || 'profile',
            profileData: {
                name: '{{ auth()->user()->name }}',
                imageUrl: '{{ auth()->user()->profile_image_path ? asset('storage/' . auth()->user()->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random&color=fff' }}'
            },
            previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.profileData.imageUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        }" class="space-y-6">

        <div x-cloak>
            {{-- اطلاعات پروفایل --}}
            <div x-show="tab === 'profile'">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


                    <div class="lg:col-span-2 p-4 sm:p-8 bg-white shadow rounded-lg">
                        <div class="max-w-xl">
                            <section>
                                <header>
                                    <h2 class="text-lg font-medium text-gray-900">
                                        اطلاعات پروفایل
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600">
                                        نام، ایمیل و عکس پروفایل خود را به‌روزرسانی کنید.
                                    </p>
                                </header>

                                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')

                                    <!-- Name -->
                                    <div>
                                        <label for="name" class="block font-medium text-sm text-gray-700">نام</label>
                                        <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-model="profileData.name" required autofocus autocomplete="name" />
                                        @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Email Address -->
                                    <div>
                                        <label for="email" class="block font-medium text-sm text-gray-700">ایمیل</label>
                                        <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                                        @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Profile Image -->
                                    <div>
                                        <label for="profile_image" class="block font-medium text-sm text-gray-700">عکس پروفایل</label>
                                        <input id="profile_image" name="profile_image" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" @change="previewImage">
                                        @error('profile_image') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">ذخیره</button>
                                    </div>
                                </form>
                            </section>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                         <div class="p-4 sm:p-8 bg-white shadow rounded-lg sticky top-24">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                پیش‌نمایش پروفایل
                            </h3>
                            <div class="flex flex-col items-center p-4 border rounded-lg bg-slate-50">
                                <img class="h-24 w-24 rounded-full object-cover border-4 border-amber-200"
                                     :src="profileData.imageUrl"
                                     alt="Profile Preview">
                                <h4 class="mt-4 text-xl font-bold text-gray-800" x-text="profileData.name"></h4>
                                <p class="text-sm text-gray-500">
                                    {{ auth()->user()->followers()->count() }} دنبال‌کننده
                                </p>
                            </div>
                         </div>
                    </div>
                </div>
            </div>

            {{-- تغییر رمز عبور --}}
            <div x-show="tab === 'password'" class="p-4 sm:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- حذف حساب کاربری --}}
            <div x-show="tab === 'delete'" class="p-4 sm:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-hub-layout>
