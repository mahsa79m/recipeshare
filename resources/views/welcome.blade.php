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
    </style>
</head>
<body class="font-sans antialiased bg-slate-100 text-gray-800">

    <div class="bg-white shadow-sm sticky top-0 z-50">
        <!-- Header -->
        <header class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- سمت راست: لوگو و لینک‌های اصلی -->
                <div class="flex items-center space-x-6 space-x-reverse">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-amber-600">دستور پخت من</a>
                    <nav class="hidden md:flex items-center space-x-6 space-x-reverse">
                        <a href="{{ route('recipes.index') }}" class="text-sm font-semibold text-gray-700 hover:text-amber-600">تمام دستورها</a>
                    </nav>
                </div>

                <!-- سمت چپ: دکمه افزودن و منوی کاربری -->
                <div class="flex items-center">
                    @auth
                        <a href="{{ route('recipes.create') }}" class="hidden sm:flex items-center px-3 py-1.5 text-sm font-semibold text-white bg-amber-500 rounded-full hover:bg-amber-600 transition-colors ml-4">
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span>دستور جدید</span>
                        </a>
                    @endauth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="p-2 rounded-full hover:bg-slate-100 focus:outline-none" aria-label="User Menu">
                            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-20" x-transition>
                            <a href="{{ route('recipes.index') }}" class="block md:hidden px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">تمام دستورها</a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">پنل کاربری</a>
                                @if(Auth::user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">پنل مدیریت</a>
                                @endif
                                <div class="border-t my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50">خروج</a>
                                </form>
                            @else
                                <div class="border-t my-1"></div>
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">ورود</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">ثبت نام</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <main>
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
                                        <x-star-rating :rating="$recipe->ratings_avg_rating" />
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-slate-500">هنوز دستوری برای نمایش وجود ندارد.</p>
                    @endforelse
                </div>
            </section>

            <!-- Popular Recipes Section -->
            <section class="bg-white p-4 rounded-2xl shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">پرطرفدارترین دستورها</h2>

                    <a href="{{ route('recipes.index') }}" class="text-sm font-semibold text-amber-600 hover:underline">مشاهده همه</a>
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
                                        <x-star-rating :rating="$recipe->ratings_avg_rating" />
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-slate-500">هنوز دستوری برای نمایش وجود ندارد.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-800 text-white mt-12">
        <div class="container mx-auto px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-right">
                <div>
                    <h3 class="text-lg font-bold mb-4">دستور پخت من</h3>
                    <p class="text-sm text-slate-400">جامعه‌ای برای اشتراک‌گذاری و کشف دستورهای غذایی جدید. به ما بپیوندید و خلاقیت آشپزی خود را به نمایش بگذارید.</p>
                </div>
                <div>
                    <h3 class="text-md font-semibold mb-4">لینک‌های سریع</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-slate-400 hover:text-white">درباره ما</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white">تماس با ما</a></li>
                        <li><a href="{{ route('recipes.index') }}" class="text-slate-400 hover:text-white">تمام دستورها</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-md font-semibold mb-4">ما را دنبال کنید</h3>
                    <div class="flex justify-center md:justify-start space-x-4 space-x-reverse">
                        <a href="#" class="text-slate-400 hover:text-white">اینستاگرام</a>
                        <a href="#" class="text-slate-400 hover:text-white">تلگرام</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-slate-700 mt-8 pt-6 text-center text-slate-500 text-xs">
                <p>&copy; {{ date('Y') }} دستور پخت من. تمام حقوق محفوظ است.</p>
            </div>
        </div>
    </footer>

</body>
</html>
