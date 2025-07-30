<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تماس با ما
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-10 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">با ما در ارتباط باشید</h1>
                    <p class="text-gray-600 mb-8">
                        ما همیشه خوشحال می‌شویم که نظرات، پیشنهادها و سوالات شما را بشنویم. لطفاً از طریق فرم زیر پیام خود را برای ما ارسال کنید.
                    </p>

                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">نام شما</label>
                            <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">ایمیل شما</label>
                            <input type="email" name="email" id="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">پیام شما</label>
                            <textarea name="message" id="message" rows="5" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="px-6 py-2 bg-amber-500 text-white font-semibold rounded-lg shadow-md hover:bg-amber-600">
                                ارسال پیام
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
