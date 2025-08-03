<nav class="bg-white border-b border-gray-100" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- سمت راست هدر -->
            <div class="flex-1 flex justify-start items-center">
                @auth
                    <!-- منوی کشویی کاربر (فقط دسکتاپ) -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                    <div class="ml-1">{{ Auth::user()->name }}</div>
                                    <div class="mr-2">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                @if (Auth::user()->is_admin)
                                    <x-dropdown-link :href="route('admin.dashboard')">پنل مدیریت</x-dropdown-link>
                                @endif
                                <x-dropdown-link :href="route('dashboard')">پنل کاربری</x-dropdown-link>
                                <x-dropdown-link :href="route('users.show', Auth::user())">صفحه کاربر</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">خروج</x-dropdown-link>
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

                <!-- منوی همبرگری (فقط موبایل) - منتقل شده به سمت راست -->
                <div x-data="{ open: false }" class="relative sm:hidden">
                    <button @click="open = !open" class="p-2 rounded-md hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20" x-transition x-cloak>
                        @auth
                            <x-dropdown-link :href="route('dashboard')">پنل کاربری</x-dropdown-link>
                            @if (Auth::user()->is_admin)
                                <x-dropdown-link :href="route('admin.dashboard')">پنل مدیریت</x-dropdown-link>
                            @endif
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">خروج</x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('login')">ورود</x-dropdown-link>
                            <x-dropdown-link :href="route('register')">ثبت نام</x-dropdown-link>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- وسط هدر (لوگو) -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}"><span class="text-3xl font-extrabold text-amber-600 hover:text-amber-700 transition">دستور پخت من</span></a>
            </div>

            <!-- سمت چپ هدر -->
            <div class="flex-1 flex justify-end items-center">
                @auth
                    <a href="{{ route('recipes.create') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-amber-600 focus:outline-none transition shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                        افزودن دستور غذا
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
