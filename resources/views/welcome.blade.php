<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>دستور پخت من - جامعه آشپزی ایران</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
        .recipe-card:hover .recipe-image { transform: scale(1.05); }
        .hero-bg { background-image: url("{{ asset('images/hero-background.jpg') }}"); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-100 text-gray-800">

    <div class="bg-white shadow-sm sticky top-0 z-50">
        <header class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-6 space-x-reverse">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-amber-600">دستور پخت من</a>
                    <nav class="hidden md:flex items-center space-x-6 space-x-reverse">
                        <a href="{{ route('recipes.index') }}" class="text-sm font-semibold text-gray-700 hover:text-amber-600">تمام دستورها</a>
                    </nav>
                </div>

                <div class="flex items-center">
                    @auth
                        <a href="{{ route('recipes.create') }}" class="hidden sm:flex items-center px-3 py-1.5 text-sm font-semibold text-white bg-amber-500 rounded-full hover:bg-amber-600 transition-colors ml-4">
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>دستور جدید</span>
                        </a>

                        <div class="relative">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                                        <img class="h-8 w-8 rounded-full object-cover mr-2" src="{{ Auth::user()->profile_image_path ? asset('storage/' . Auth::user()->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" alt="{{ Auth::user()->name }}">
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
                                    <x-dropdown-link :href="route('users.show', Auth::user())">صفحه کاربر</x-dropdown-link>
                                    <div class="border-t border-gray-100"></div>
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
                            <a href="{{ route('register') }}" class="inline-block px-4 py-2 text-sm font-semibold text-white bg-amber-500 rounded-full hover:bg-amber-600 transition">ثبت نام</a>
                        </div>
                        <div x-data="{ open: false }" class="relative sm:hidden">
                            <button @click="open = !open" class="p-2 rounded-full hover:bg-slate-100 focus:outline-none" aria-label="Menu">
                                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20" x-transition x-cloak>
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">ورود</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">ثبت نام</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </header>
    </div>
    <main class="pb-16 sm:pb-0"> {{-- اضافه کردن پدینگ پایین برای جلوگیری از همپوشانی با منوی موبایل --}}
        <!-- Hero Section with Search -->
        <section class="hero-bg bg-cover bg-center h-[50vh] flex flex-col items-center justify-center text-white relative">
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
            <div class="relative z-10 text-center p-4">
                <h1 class="text-4xl md:text-5xl font-bold" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">امروز چه چیزی می‌پزید؟</h1>
                <p class="mt-4 mb-8 text-lg text-slate-200" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">هزاران دستور پخت را در جامعه ما جستجو کنید</p>
                <form action="{{ route('recipes.index') }}" method="GET" class="max-w-xl mx-auto">
                    <div class="relative">
                        <input type="text" name="search" placeholder="مثلاً: کیک شکلاتی، لازانیا..." class="w-full text-lg px-6 py-4 text-gray-700 border-2 border-transparent rounded-full focus:ring-amber-500 focus:border-amber-500 focus:outline-none shadow-lg">
                        <button type="submit" class="absolute left-2 top-1/2 -translate-y-1/2 p-2 text-gray-500 hover:text-amber-600" aria-label="Search">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <div class="container mx-auto px-4 py-12 -mt-20 relative z-20">
            <!-- Categories Section -->
            <section class="bg-amber-50 p-4 rounded-2xl shadow-lg mb-12 border border-amber-100">
                <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">دسته‌بندی‌ها</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', $category) }}" class="p-3 bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-md hover:-translate-y-1 transition-all duration-300 text-center">
                            <h3 class="font-semibold text-md text-amber-700">{{ $category->name }}</h3>
                            <p class="text-xs text-slate-500 mt-1">{{ $category->recipes_count }} دستور پخت</p>
                        </a>
                    @endforeach
                </div>
            </section>

            <!-- Popular Recipes Section (Moved Up) -->
            <section class="bg-white p-4 rounded-2xl shadow-lg mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">پرطرفدارترین دستورها</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($popularRecipes as $recipe)
                        <div class="recipe-card rounded-lg overflow-hidden group border border-slate-200 hover:shadow-xl transition-shadow duration-300">
                            <a href="{{ route('recipes.show', $recipe) }}">
                                <div class="overflow-hidden aspect-square">
                                    <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x400/f97316/ffffff?text=Dastoor+Pokht' }}" alt="{{ $recipe->title }}" class="recipe-image w-full h-full object-cover transition-transform duration-300">
                                </div>
                                <div class="p-3">
                                    <h3 class="font-bold text-md mb-2 truncate group-hover:text-amber-600">{{ $recipe->title }}</h3>
                                    <div class="flex items-center justify-between text-xs text-slate-600">
                                        <div class="flex items-center">
                                            <img src="{{ $recipe->user->profile_image_path ? asset('storage/' . $recipe->user->profile_image_path) : 'https://ui-avatars.com/api/?name='.urlencode($recipe->user->name) }}" alt="{{ $recipe->user->name }}" class="w-6 h-6 rounded-full ml-2 object-cover">
                                            <span>{{ $recipe->user->name }}</span>
                                        </div>
                                        {{-- START: CHANGE --}}
                                        <div class="flex items-center">
                                            <x-star-rating :rating="$recipe->ratings_avg_rating" />
                                            @if($recipe->ratings_avg_rating > 0)
                                                <span class="text-xs text-slate-500 mr-1">({{ number_format($recipe->ratings_avg_rating, 1) }})</span>
                                            @endif
                                        </div>
                                        {{-- END: CHANGE --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-slate-500">هنوز دستوری برای نمایش وجود ندارد.</p>
                    @endforelse
                </div>
            </section>

            <!-- Latest Recipes Section -->
            <section class="bg-white p-4 rounded-2xl shadow-lg mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">تازه‌ترین دستورها</h2>
                    <a href="{{ route('recipes.index') }}" class="text-sm font-semibold text-amber-600 hover:underline">مشاهده همه</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($latestRecipes as $recipe)
                        <div class="recipe-card rounded-lg overflow-hidden group border border-slate-200 hover:shadow-xl transition-shadow duration-300">
                            <a href="{{ route('recipes.show', $recipe) }}">
                                <div class="overflow-hidden aspect-square">
                                    <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x400/f97316/ffffff?text=Dastoor+Pokht' }}" alt="{{ $recipe->title }}" class="recipe-image w-full h-full object-cover transition-transform duration-300">
                                </div>
                                <div class="p-3">
                                    <h3 class="font-bold text-md mb-2 truncate group-hover:text-amber-600">{{ $recipe->title }}</h3>
                                    <div class="flex items-center justify-between text-xs text-slate-600">
                                        <div class="flex items-center">
                                            <img src="{{ $recipe->user->profile_image_path ? asset('storage/' . $recipe->user->profile_image_path) : 'https://ui-avatars.com/api/?name='.urlencode($recipe->user->name) }}" alt="{{ $recipe->user->name }}" class="w-6 h-6 rounded-full ml-2 object-cover">
                                            <span>{{ $recipe->user->name }}</span>
                                        </div>
                                        <span class="text-xs text-slate-500">{{ verta($recipe->created_at)->formatDifference() }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-slate-500">هنوز دستوری برای نمایش وجود ندارد.</p>
                    @endforelse
                </div>
            </section>

            <!-- Call to Action Section -->
            <section class="bg-amber-500 text-white p-8 rounded-2xl shadow-lg text-center">
                <h2 class="text-3xl font-bold">هنر آشپزی خود را به اشتراک بگذارید!</h2>
                <p class="mt-4 mb-6 max-w-2xl mx-auto">
                    به جامعه بزرگ آشپزان ما بپیوندید و دستورهای غذایی خلاقانه خود را با دیگران به اشتراک بگذارید. ما منتظر دیدن هنر شما هستیم.
                </p>
                <a href="{{ route('recipes.create') }}" class="inline-block px-8 py-3 bg-white text-amber-600 font-bold rounded-full hover:bg-amber-50 transition-colors">
                    افزودن دستور جدید
                </a>
            </section>

        </div>
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- منوی پایین صفحه (فقط موبایل) -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t sm:hidden z-40 shadow-lg" dir="rtl">
        <div class="flex justify-around items-center h-16">
             <a href="{{ route('home') }}" class="flex flex-col items-center text-gray-600 hover:text-amber-600 transition {{ request()->routeIs('home') ? 'text-amber-600' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                <span class="text-xs mt-1">خانه</span>
            </a>
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

</body>
</html>
