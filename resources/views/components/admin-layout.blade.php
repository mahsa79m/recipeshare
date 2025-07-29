<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>پنل مدیریت - دستور پخت من</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 right-0 z-30 w-64 overflow-y-auto transition-transform duration-300 transform bg-gray-900 lg:static lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'">

            <div class="flex items-center justify-center mt-8">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-semibold">پنل ادمین</a>
            </div>

            <nav class="mt-10">
                <a class="flex items-center px-6 py-3 mt-4 text-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}" href="{{ route('admin.dashboard') }}">
                    <span class="mx-3">داشبورد</span>
                </a>
                <a class="flex items-center px-6 py-3 mt-4 text-gray-100 {{ request()->routeIs('admin.recipes.index') ? 'bg-gray-700' : '' }}" href="{{ route('admin.recipes.index') }}">
                    <span class="mx-3">مدیریت دستورها</span>
                </a>
                <a class="flex items-center px-6 py-3 mt-4 text-gray-100 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}" href="{{ route('admin.categories.index') }}">
                    <span class="mx-3">مدیریت دسته‌بندی‌ها</span>
                </a>
                <a class="flex items-center px-6 py-3 mt-4 text-gray-100 {{ request()->routeIs('admin.users.index') ? 'bg-gray-700' : '' }}" href="{{ route('admin.users.index') }}">
                    <span class="mx-3">مدیریت کاربران</span>
                </a>
                <a class="flex items-center px-6 py-3 mt-4 text-gray-100 {{ request()->routeIs('admin.comments.index') ? 'bg-gray-700' : '' }}" href="{{ route('admin.comments.index') }}">
                    <span class="mx-3">مدیریت نظرات</span>
                </a>
                <a class="flex items-center px-6 py-3 mt-4 text-gray-400 hover:bg-gray-700 hover:text-gray-100" href="{{ route('home') }}" target="_blank">
                    <span class="mx-3">مشاهده سایت</span>
                </a>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-amber-500">
                <div class="flex items-center">
                    {{-- دکمه همبرگری در حالت موبایل باید در سمت راست باشد --}}
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center">
                    <div class="relative">
                        {{ Auth::user()->name }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mr-4">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-red-500">خروج</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>
