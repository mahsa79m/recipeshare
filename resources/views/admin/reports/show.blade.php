<x-admin-layout>
    <h1 class="text-2xl font-semibold text-gray-700 mb-4">
        جزئیات گزارش برای: {{ $report->recipe->title ?? 'دستور پخت حذف شده' }}
    </h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">اطلاعات گزارش</h3>
                <p class="text-gray-700 mt-2"><strong>کاربر گزارش‌دهنده:</strong> {{ $report->user->name ?? 'کاربر حذف شده' }}</p>
                <p class="text-gray-700 mt-2"><strong>دستور پخت:</strong>
                    {{-- در اینجا می‌توانید لینکی به صفحه دستور پخت قرار دهید --}}
                    <a href="{{ isset($report->recipe) ? route('recipes.show', $report->recipe) : '#' }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ $report->recipe->title ?? 'دستور پخت در دسترس نیست' }}
                    </a>
                </p>
                <p class="text-gray-700 mt-2"><strong>دلیل گزارش:</strong> <span class="font-bold text-red-600">{{ $report->reason }}</span></p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">توضیحات کاربر</h3>
                <p class="text-gray-600 bg-gray-50 p-4 rounded-md">{{ $report->details ?? 'توضیحاتی ثبت نشده است.' }}</p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t flex items-center space-x-4 space-x-reverse">
            {{-- دکمه برای تغییر وضعیت به "بررسی شده" --}}
            <form action="{{ route('admin.reports.resolve', $report) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full transition duration-300">
                    علامت‌گذاری به عنوان "بررسی شده"
                </button>
            </form>

            {{-- دکمه برای حذف گزارش --}}
            <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" onsubmit="return confirm('آیا از حذف این گزارش مطمئن هستید؟ این عمل غیرقابل بازگشت است.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full transition duration-300">
                    حذف گزارش
                </button>
            </form>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:underline flex items-center">
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            بازگشت به لیست گزارش‌ها
        </a>
    </div>
</x-admin-layout>
