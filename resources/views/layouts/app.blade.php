<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])


    <style>
         body, button, input, select, textarea, h1, h2, h3, h4, h5, h6 {
            font-family: 'Vazirmatn', sans-serif;
        }
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="antialiased flex flex-col min-h-screen bg-slate-50">
    <div class="flex-grow pb-16 sm:pb-0">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    @include('layouts.footer')


    <div x-cloak class="fixed bottom-0 left-0 w-full bg-white border-t sm:hidden z-40 shadow-lg" dir="rtl">
        <div class="flex justify-around items-center h-16">

            {{-- خانه --}}
            <a href="{{ route('home') }}"
                class="flex flex-col items-center text-gray-600 hover:text-amber-600 transition {{ request()->routeIs('home') ? 'text-amber-600' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs mt-1">خانه</span>
            </a>

            {{-- تمام دستورها --}}
            <a href="{{ route('recipes.index') }}"
                class="flex flex-col items-center text-gray-600 hover:text-amber-600 transition {{ request()->routeIs('recipes.index') ? 'text-amber-600' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                <span class="text-xs mt-1">دستورها</span>
            </a>

            @auth
                {{-- افزودن دستور --}}
                <a href="{{ route('recipes.create') }}"
                    class="flex flex-col items-center text-gray-600 hover:text-amber-600 transition {{ request()->routeIs('recipes.create') ? 'text-amber-600' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs mt-1">افزودن</span>
                </a>


                <a href="{{ route('users.show', Auth::user()) }}"
                    class="flex flex-col items-center text-gray-600 hover:text-amber-600 transition {{ request()->routeIs('users.show', Auth::user()) ? 'text-amber-600' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-xs mt-1">پروفایل</span>
                </a>
            @else

                <a href="{{ route('login') }}"
                    class="flex flex-col items-center text-gray-600 hover:text-amber-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-10a3 3 0 013-3h11a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-xs mt-1">ورود</span>
                </a>
            @endauth
        </div>
    </div>

    @stack('scripts')

    @vite(['resources/js/app.js'])
</body>

</html>
