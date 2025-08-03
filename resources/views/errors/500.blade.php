
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطای سرور (500)</title>

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
                <svg class="mx-auto h-24 w-24 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>

            <h1 class="text-6xl sm:text-8xl font-extrabold text-gray-800 tracking-wider">۵۰۰</h1>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-700 mt-4">خطای داخلی سرور</h2>

            <p class="text-gray-500 mt-4 text-base sm:text-lg">
             ! یه مشکلی برای سایت ما پیش اومده! تیم فنی ما در حال بررسیه. لطفاً چند دقیقه دیگه دوباره امتحان کن.
            </p>

            <div class="mt-8">
                <a href="{{ url('/') }}"
                   class="inline-block px-8 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition-colors duration-300">
                    بازگشت به صفحه اصلی
                </a>
            </div>
        </div>
    </div>

</body>
</html>
