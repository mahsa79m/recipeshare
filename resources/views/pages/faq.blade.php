<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            سوالات متداول
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-10 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-8 text-center">پاسخ به سوالات شما</h1>

                    <div class="space-y-4" x-data="{ open: 1 }">
                        <!-- سوال ۱ -->
                        <div class="border rounded-lg">
                            <button @click="open = (open === 1 ? 0 : 1)" class="w-full flex justify-between items-center p-4 text-right font-semibold">
                                <span>چگونه می‌توانم یک دستور غذای جدید اضافه کنم؟</span>
                                <span x-text="open === 1 ? '-' : '+'" class="text-xl"></span>
                            </button>
                            <div x-show="open === 1" x-cloak class="p-4 pt-0 text-gray-600">
                                <p>برای افزودن دستور جدید، ابتدا باید در سایت ثبت‌نام کرده و وارد حساب کاربری خود شوید. سپس از طریق دکمه "افزودن دستور غذا" در هدر سایت، می‌توانید فرم مربوطه را تکمیل و ارسال کنید. دستور شما پس از تایید مدیر، در سایت نمایش داده خواهد شد.</p>
                            </div>
                        </div>

                        <!-- سوال ۲ -->
                        <div class="border rounded-lg">
                            <button @click="open = (open === 2 ? 0 : 2)" class="w-full flex justify-between items-center p-4 text-right font-semibold">
                                <span>آیا امکان ویرایش دستورهای غذایی پس از ثبت وجود دارد؟</span>
                                <span x-text="open === 2 ? '-' : '+'" class="text-xl"></span>
                            </button>
                            <div x-show="open === 2" x-cloak class="p-4 pt-0 text-gray-600" style="display:none;">
                                <p>بله، شما می‌توانید دستورهایی که خودتان ثبت کرده‌اید را ویرایش کنید. برای این کار به صفحه "دستورهای من" در پنل کاربری خود مراجعه کرده و از آنجا اقدام به ویرایش نمایید.</p>
                            </div>
                        </div>

                        <!-- سوال ۳ -->
                        <div class="border rounded-lg">
                            <button @click="open = (open === 3 ? 0 : 3)" class="w-full flex justify-between items-center p-4 text-right font-semibold">
                                <span>چگونه می‌توانم حساب کاربری خود را حذف کنم؟</span>
                                <span x-text="open === 3 ? '-' : '+'" class="text-xl"></span>
                            </button>
                            <div x-show="open === 3" x-cloak class="p-4 pt-0 text-gray-600" style="display:none;">
                                <p>برای حذف حساب کاربری، به پنل کاربری خود بروید و از بخش "ویرایش پروفایل و تنظیمات"، به زبانه "حذف حساب" مراجعه کنید. لطفاً توجه داشته باشید که این عمل غیرقابل بازگشت است.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
