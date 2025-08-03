<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>دستور پخت من - جامعه آشپزی ایران</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
        .recipe-card:hover .recipe-image { transform: scale(1.05); }
        .hero-bg { background-image: url("{{ asset('images/hero-background.jpg') }}"); }
        [x-cloak] { display: none !important; }
    </style>
</head>
{{-- کلاس font-sans از اینجا حذف شد تا فونت وزیرمتن به درستی اعمال شود --}}
<body class="antialiased bg-slate-100 text-gray-800">

    <div class="bg-white shadow-sm sticky top-0 z-50">
        @include('layouts.navigation')
    </div>

    <main class="pb-16 sm:pb-0">
        <!-- Hero Section -->
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

            <!-- بخش جدید: فید دنبال‌شوندگان (فقط برای کاربران وارد شده) -->
            @auth
                @if(isset($followedRecipes) && $followedRecipes->isNotEmpty())
                    <section class="bg-white p-4 rounded-2xl shadow-lg mb-12">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">آخرین دستورهای دنبال‌شوندگان</h2>
                            {{-- دکمه مشاهده همه اضافه شد --}}
                          <a href="{{ route('recipes.feed') }}" class="text-sm font-semibold text-amber-600 hover:underline">مشاهده همه</a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($followedRecipes as $recipe)
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
                                                <div class="flex items-center">
                                                    <x-star-rating :rating="$recipe->ratings_avg_rating" />
                                                    @if($recipe->ratings_avg_rating > 0)
                                                        <span class="text-xs text-slate-500 mr-1">({{ number_format($recipe->ratings_avg_rating, 1) }})</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endauth

            <!-- Popular Recipes Section -->
            <section class="bg-white p-4 rounded-2xl shadow-lg mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">پرطرفدارترین دستورها</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($popularRecipes as $recipe)
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
                                        <div class="flex items-center">
                                            <x-star-rating :rating="$recipe->ratings_avg_rating" />
                                            @if($recipe->ratings_avg_rating > 0)
                                                <span class="text-xs text-slate-500 mr-1">({{ number_format($recipe->ratings_avg_rating, 1) }})</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
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
                    @foreach ($latestRecipes as $recipe)
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
                    @endforeach
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

    @include('layouts.footer')
    @include('layouts.mobile-nav')
</body>
</html>
