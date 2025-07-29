<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>پنل کاربری - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 right-0 z-30 w-64 overflow-y-auto transition-transform duration-300 transform bg-white shadow-lg lg:static lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'">

            <div class="flex items-center justify-center p-4 border-b">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-amber-600">دستور پخت من</a>
            </div>

            <nav class="mt-4">
                <a class="flex items-center px-6 py-3 mt-2 text-gray-700 {{ request()->routeIs('dashboard') ? 'bg-amber-100 border-r-4 border-amber-500 font-semibold' : '' }}" href="{{ route('dashboard') }}">
                    <span class="mx-3">پروفایل من</span>
                </a>
                <a class="flex items-center px-6 py-3 mt-2 text-gray-700 {{ request()->routeIs('my-recipes') ? 'bg-amber-100 border-r-4 border-amber-500 font-semibold' : '' }}" href="{{ route('my-recipes') }}">
                    <span class="mx-3">دستورهای من</span>
                </a>
                <a class="flex items-center px-6 py-3 mt-2 text-gray-700 {{ request()->routeIs('profile.edit') ? 'bg-amber-100 border-r-4 border-amber-500 font-semibold' : '' }}" href="{{ route('profile.edit') }}">
                    <span class="mx-3">ویرایش پروفایل و تنظیمات</span>
                </a>
                <a class="flex items-center px-6 py-3 mt-2 text-gray-500 hover:bg-gray-200" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="mx-3">خروج</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </button>
                    <div class="relative mx-4 lg:mx-0">
                        <h1 class="text-xl font-semibold text-gray-800">{{ $header }}</h1>
                    </div>
                </div>

                <div class="flex items-center">
                    <a href="{{ route('users.show', Auth::user()) }}" class="text-sm text-gray-600 hover:text-amber-600" target="_blank">مشاهده پروفایل عمومی</a>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
