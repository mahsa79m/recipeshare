<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>پنل مدیریت - دستور پخت من</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body, button, input, select, textarea, h1, h2, h3, h4, h5, h6 {
            font-family: 'Vazirmatn', 'Inter', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        <!--  mobile -->
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside
            x-cloak
            class="fixed inset-y-0 right-0 z-30 flex flex-col w-full max-w-xs sm:w-64 overflow-y-auto transition-transform duration-300 transform bg-gray-900 lg:static lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'">

            <div class="flex items-center justify-center mt-8">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-semibold">پنل ادمین</a>
            </div>

            <nav class="flex-1 mt-10 px-2 space-y-2">
                <a class="flex items-center px-4 py-2 text-gray-100 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}" href="{{ route('admin.dashboard') }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    <span class="mx-3">داشبورد</span>
                </a>
                <a class="flex items-center px-4 py-2 text-gray-100 rounded-md {{ request()->routeIs('admin.recipes.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}" href="{{ route('admin.recipes.index') }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    <span class="mx-3">مدیریت دستورها</span>
                </a>
                <a class="flex items-center px-4 py-2 text-gray-100 rounded-md {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}" href="{{ route('admin.categories.index') }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                    <span class="mx-3">مدیریت دسته‌بندی‌ها</span>
                </a>
                <a class="flex items-center px-4 py-2 text-gray-100 rounded-md {{ request()->routeIs('admin.users.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}" href="{{ route('admin.users.index') }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5zM10.5 19.5a3 3 0 003.75-2.625m-3.75 2.625a3 3 0 01-3.75-2.625m0 0A2.25 2.25 0 015.625 15H9a2.25 2.25 0 012.25 2.25v.75M10.5 19.5a2.25 2.25 0 002.25-2.25v-.75a2.25 2.25 0 00-2.25-2.25H5.625a2.25 2.25 0 00-2.25 2.25v.75a2.25 2.25 0 002.25 2.25h.75M10.5 19.5V16.5a2.25 2.25 0 00-2.25-2.25H5.625a2.25 2.25 0 00-2.25 2.25v.75m10.5-6.375a2.25 2.25 0 00-2.25-2.25H15a2.25 2.25 0 00-2.25 2.25v.75m2.25-4.5a2.25 2.25 0 002.25-2.25H15a2.25 2.25 0 00-2.25 2.25v.75m0 0v3.375m0 0h3.375m-3.375 0l3.375 3.375" /></svg>
                    <span class="mx-3">مدیریت کاربران</span>
                </a>
                <a class="flex items-center px-4 py-2 text-gray-100 rounded-md {{ request()->routeIs('admin.comments.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}" href="{{ route('admin.comments.index') }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.17 48.17 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" /></svg>
                    <span class="mx-3">مدیریت نظرات</span>
                </a>

                <a class="flex items-center px-4 py-2 text-gray-100 rounded-md {{ request()->routeIs('admin.reports.index') ? 'bg-gray-700' : 'hover:bg-gray-700' }}" href="{{ route('admin.reports.index') }}">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.374c-.866-1.5-3.032-1.5-3.898 0L2.697 16.376zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <span class="mx-3">
                        مدیریت گزارش‌ها
                        @php
                            $pendingReportsCount = \App\Models\Report::where('status', 'pending')->count();
                        @endphp
                        @if ($pendingReportsCount > 0)
                            <span class="mr-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                {{ $pendingReportsCount }}
                            </span>
                        @endif
                    </span>
                </a>

            </nav>

            <div class="mt-auto p-4 border-t border-gray-700">
                <a class="flex items-center px-4 py-2 text-gray-400 rounded-md hover:bg-gray-700 hover:text-gray-100" href="{{ route('home') }}" target="_blank">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-4.5 0V6.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V10.5m-4.5 0h4.5M12 15h.008v.008H12V15z" /></svg>
                    <span class="mx-3">مشاهده سایت</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="flex items-center px-4 py-2 mt-2 text-gray-400 rounded-md hover:bg-gray-700 hover:text-gray-100" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                        <span class="mx-3">خروج</span>
                    </a>
                </form>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-amber-500">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center">
                    <div class="font-semibold text-gray-700">
                        {{ Auth::user()->name }}
                    </div>
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
