<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه پیدا نشد (404)</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700;800&display=swap');
        body {
            font-family: 'Vazirmatn', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex flex-col justify-center items-center text-center p-4">
        <div class="bg-white p-8 sm:p-12 rounded-2xl shadow-lg max-w-lg w-full">

            <div class="mb-6">
                <svg class="mx-auto h-24 w-24 text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>

            <h1 class="text-6xl sm:text-8xl font-extrabold text-gray-800 tracking-wider">۴۰۴</h1>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-700 mt-4">صفحه پیدا نشد</h2>

            <p class="text-gray-500 mt-4 text-base sm:text-lg">
                متاسفانه! این دستور هنوز به سایت اضافه نشده یا شاید آدرس رو اشتباه وارد کردی!
            </p>

            <div class="mt-8">
                <a href="{{ url('/') }}"
                   class="inline-block px-8 py-3 bg-orange-500 text-white font-semibold rounded-lg shadow-md hover:bg-orange-600 transition-colors duration-300">
                    بازگشت به سایت (صفحه اصلی)
                </a>
            </div>
        </div>
    </div>

</body>
</html>
