<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>سایت اشتراک دستور غذا</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-brand-khaki text-gray-800">

    {{-- کامپوننت Alpine.js برای مدیریت نوار ناوبری --}}
    <div x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-50">
        <header class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- لوگو -->
                <a href="{{ route('home') }}" class="text-2xl font-bold text-brand-green">CookShare</a>

                <!-- منوی دسکتاپ -->
                <nav class="hidden md:flex items-center space-x-6 space-x-reverse">
                    @foreach ($categories as $category)
                        {{-- این خط تغییر کرده است --}}
                        <a href="{{ route('categories.show', $category) }}" class="text-gray-600 hover:text-brand-orange transition duration-300">{{ $category->name }}</a>
                    @endforeach
                </nav>

                <!-- فرم جستجو و دکمه‌های ورود -->
                <div class="hidden md:flex items-center space-x-4 space-x-reverse">
                     <form action="{{ route('recipes.index') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="جستجوی غذا..." class="border-gray-300 rounded-full pl-10 pr-4 py-1 text-sm focus:ring-brand-orange focus:border-brand-orange">
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-brand-green">داشبورد</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-brand-green">ورود</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-brand-green">ثبت نام</a>
                        @endif
                    @endauth
                </div>

                <!-- دکمه همبرگری برای موبایل -->
                <div class="md:hidden">
                    <button @click="open = !open">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- منوی موبایل -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden mt-4">
                 @foreach ($categories as $category)
                    {{-- این خط تغییر کرده است --}}
                    <a href="{{ route('categories.show', $category) }}" class="block py-2 text-gray-600 hover:text-brand-orange">{{ $category->name }}</a>
                @endforeach
                <hr class="my-2">
                 @auth
                    <a href="{{ url('/dashboard') }}" class="block py-2 font-semibold text-gray-600 hover:text-brand-green">داشبورد</a>
                @else
                    <a href="{{ route('login') }}" class="block py-2 font-semibold text-gray-600 hover:text-brand-green">ورود</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block py-2 font-semibold text-gray-600 hover:text-brand-green">ثبت نام</a>
                    @endif
                @endauth
            </div>
        </header>
    </div>

    <main class="container mx-auto px-4 py-12">
        <!-- بخش هیرو و جستجوی اصلی -->
        <section class="text-center py-16">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">امروز چه چیزی می‌پزید؟</h1>
            <p class="text-lg text-gray-600 mb-8">هزاران دستور پخت از سراسر جهان را کشف کنید</p>
            <form action="{{ route('recipes.index') }}" method="GET" class="max-w-xl mx-auto">
                <div class="relative">
                    <input type="text" name="search" placeholder="مثلاً: کیک شکلاتی، لازانیا، یا قورمه سبزی..." class="w-full text-lg px-6 py-4 border-2 border-gray-300 rounded-full focus:ring-brand-orange focus:border-brand-orange">
                    <button type="submit" class="absolute left-2 top-2 bg-brand-orange text-white rounded-full px-8 py-2.5 font-semibold hover:bg-orange-500 transition duration-300">جستجو</button>
                </div>
            </form>
        </section>

        {{-- این بخش را برای نمایش دستورهای محبوب اضافه کنید (اگر در کنترلر ارسال شده باشد) --}}
        @if(isset($popularRecipes) && $popularRecipes->count() > 0)
            <section class="mb-16">
                <h2 class="text-3xl font-bold mb-8 text-right">محبوب‌ترین‌ها ⭐</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($popularRecipes as $recipe)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition duration-300">
                            <a href="{{ route('recipes.show', $recipe) }}">
                                <div class="relative">
                                    <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x300/F5F5F5/333333?text=No+Image' }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover">
                                    <div class="absolute top-2 right-2 bg-brand-orange text-white text-sm font-bold px-3 py-1 rounded-full flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <span>{{ number_format($recipe->ratings_avg_rating, 1) }}</span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2 truncate">{{ $recipe->title }}</h3>
                                    <p class="text-sm text-gray-600">توسط: <a href="{{ route('users.show', $recipe->user) }}" class="font-medium text-brand-orange hover:underline">{{ $recipe->user->name }}</a></p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif


        <!-- بخش جدیدترین دستورهای غذایی -->
        <section>
            <h2 class="text-3xl font-bold mb-8 text-right">جدیدترین دستورها</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($latestRecipes as $recipe)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition duration-300">
                        <a href="{{ route('recipes.show', $recipe) }}">
                            <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x300/F5F5F5/333333?text=No+Image' }}" alt="{{ $recipe->title }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2 truncate">{{ $recipe->title }}</h3>
                                {{-- این خط تغییر کرده است --}}
                                <p class="text-sm text-gray-600">توسط: <a href="{{ route('users.show', $recipe->user) }}" class="font-medium text-brand-orange hover:underline">{{ $recipe->user->name }}</a></p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

</body>
</html>
