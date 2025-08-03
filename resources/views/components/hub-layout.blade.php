<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>پنل کاربری - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- فونت وزیرمتن برای فارسی و فونت Inter برای انگلیسی --}}
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* اعمال فونت‌های وزیرمتن و Inter به کل صفحه */
        body, button, input, select, textarea, h1, h2, h3, h4, h5, h6 {
            font-family: 'Vazirmatn', 'Inter', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-gray-100"> {{-- کلاس font-sans حذف شد --}}
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity lg:hidden" @click="sidebarOpen = false"></div>

        <aside
            x-cloak
            class="fixed inset-y-0 right-0 z-30 flex flex-col w-full max-w-xs sm:w-64 overflow-y-auto transition-transform duration-300 transform bg-white shadow-lg lg:static lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'">

            <div class="flex items-center justify-center p-4 border-b h-20">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-amber-600 hover:text-amber-700 transition-colors">
                    دستور پخت من
                </a>
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2">
                <a class="flex items-center px-4 py-2 text-gray-700 rounded-md transition-colors hover:bg-gray-100" href="{{ route('home') }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg>
                    <span class="mx-3">بازگشت به سایت</span>
                </a>
                <hr class="my-2">
                <a class="flex items-center px-4 py-2 text-gray-700 rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-amber-100 text-amber-700 font-bold' : 'hover:bg-gray-100' }}" href="{{ route('dashboard') }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span class="mx-3">داشبورد</span>
                </a>
                <hr class="my-2">
                <p class="px-4 pt-2 pb-1 text-xs font-semibold text-gray-400 uppercase">تنظیمات حساب</p>
                <a class="flex items-center px-4 py-2 text-gray-700 rounded-md transition-colors {{ request()->routeIs('profile.edit') && !request('tab') ? 'bg-amber-100 text-amber-700 font-bold' : 'hover:bg-gray-100' }}" href="{{ route('profile.edit') }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    <span class="mx-3">ویرایش پروفایل</span>
                </a>
                <a class="flex items-center px-4 py-2 text-gray-700 rounded-md transition-colors {{ request('tab') === 'password' ? 'bg-amber-100 text-amber-700 font-bold' : 'hover:bg-gray-100' }}" href="{{ route('profile.edit', ['tab' => 'password']) }}">
                     <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    <span class="mx-3">تغییر رمز عبور</span>
                </a>
                 <a class="flex items-center px-4 py-2 text-gray-700 rounded-md transition-colors {{ request('tab') === 'delete' ? 'bg-red-100 text-red-700 font-bold' : 'hover:bg-gray-100' }}" href="{{ route('profile.edit', ['tab' => 'delete']) }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    <span class="mx-3">حذف حساب</span>
                </a>
            </nav>

            <div class="mt-auto p-4 border-t">
                <a class="flex items-center px-4 py-2 text-gray-500 rounded-md hover:bg-red-100 hover:text-red-700" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    <span class="mx-3">خروج</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b h-20">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </button>
                    <div class="relative mx-4 lg:mx-0">
                        <h1 class="text-xl font-semibold text-gray-800">{{ $header }}</h1>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('users.show', Auth::user()) }}" class="text-sm text-gray-600 hover:text-amber-600" target="_blank">پروفایل کاربر</a>
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
