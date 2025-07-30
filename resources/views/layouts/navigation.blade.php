<nav class="bg-white border-b border-gray-100" dir="rtl">
    <!-- منوی اصلی برای دسکتاپ و موبایل -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- سمت راست هدر -->
            <div class="flex-1 flex justify-start">
                @auth
                    <!-- منوی کشویی تنظیمات کاربر (فقط دسکتاپ) -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                    <div class="ml-1">{{ Auth::user()->name }}</div>
                                    <div class="mr-2">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @if (Auth::user()->is_admin)
                                    <x-dropdown-link :href="route('admin.dashboard')">پنل مدیریت</x-dropdown-link>
                                @endif
                                <x-dropdown-link :href="route('dashboard')">پنل کاربری</x-dropdown-link>
                                <x-dropdown-link :href="route('users.show', Auth::user())">مشاهده پروفایل عمومی</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        خروج
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="hidden sm:flex items-center space-x-4 space-x-reverse">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-amber-600 transition">ورود</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold text-gray-600 hover:text-amber-600 transition">ثبت نام</a>
                    </div>
                @endauth
            </div>

            <!-- وسط هدر (لوگو) -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}">
                    <span class="text-3xl font-extrabold text-amber-600 hover:text-amber-700 transition duration-200 ease-in-out">
                        دستور پخت من
                    </span>
                </a>
            </div>

            <!-- سمت چپ هدر -->
            <div class="flex-1 flex justify-end">
                <!-- دکمه افزودن دستور (فقط دسکتاپ) -->
                @auth
                    @if (!request()->routeIs('recipes.create'))
                        <a href="{{ route('recipes.create') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            افزودن دستور غذا
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- منوی پایین صفحه (فقط موبایل) -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t sm:hidden z-40 shadow-lg" dir="rtl">
        <div class="flex justify-around items-center h-16">
             <a href="{{ route('recipes.index') }}" class="flex flex-col items-center text-gray-600 hover:text-amber-600 transition {{ request()->routeIs('recipes.index') ? 'text-amber-600' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                <span class="text-xs mt-1">دستورها</span>
            </a>

            @auth
                <a href="{{ route('recipes.create') }}" class="flex flex-col items-center text-gray-600 hover:text-amber-600 transition {{ request()->routeIs('recipes.create') ? 'text-amber-600' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs mt-1">افزودن</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-gray-600 hover:text-amber-600 transition {{ request()->routeIs('dashboard') ? 'text-amber-600' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-xs mt-1">پروفایل</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="flex flex-col items-center text-gray-600 hover:text-amber-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-10a3 3 0 013-3h11a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-xs mt-1">ورود</span>
                </a>
            @endauth
        </div>
    </div>
</nav>
