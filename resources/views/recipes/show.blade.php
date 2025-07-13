<x-app-layout>
    {{-- هدر صفحه که عنوان دستور غذا را نمایش می‌دهد --}}
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $recipe->title }}
        </h2>
    </x-slot>

    <div dir="rtl" class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200">
                <div class="p-8">
                    
                    {{-- نمایش تصویر دستور غذا اگر وجود داشته باشد --}}
                    @if ($recipe->image_path)
                        <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-auto object-cover rounded-lg mb-6">
                    @endif
                    
                    {{-- اطلاعات نویسنده و دسته‌بندی --}}
					
					
                  <div class="mb-6 text-sm text-gray-600">
                        <span>نویسنده: </span>
                         <a href="{{ route('users.show', $recipe->user) }}" class="font-medium text-brand-orange hover:underline">
						 {{ $recipe->user->name }}
						 </a>
						<span class="mx-2">|</span>
                        <span>دسته‌بندی: </span>
                        <a href="{{ route('categories.show', $recipe->category) }}" class="font-medium text-gray-800 hover:underline">
						{{ $recipe->category->name }}
						</a>
						</div>
					

                    {{-- نمایش مواد لازم --}}
                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-3 text-gray-800 border-b pb-2">مواد لازم</h3>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($recipe->ingredients)) !!}
                        </div>
                    </div>

                    {{-- نمایش طرز تهیه --}}
                    <div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800 border-b pb-2">طرز تهیه</h3>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($recipe->description)) !!}
                        </div>
                    </div>
                    
                    {{-- دکمه‌های ویرایش و حذف که فقط به نویسنده نمایش داده می‌شود --}}
                    @can('update', $recipe)
                        <div class="mt-8 pt-6 border-t flex items-center space-x-4 space-x-reverse">
                            <a href="{{ route('recipes.edit', $recipe) }}" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold text-sm rounded-md hover:bg-blue-700 transition duration-150">
                                ویرایش
                            </a>
                    
                            <form method="POST" action="{{ route('recipes.destroy', $recipe) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-6 py-2 bg-red-600 text-white font-semibold text-sm rounded-md hover:bg-red-700 transition duration-150"
                                        onclick="return confirm('آیا از حذف این دستور غذا مطمئن هستید؟ این عمل غیرقابل بازگشت است.')">
                                    حذف
                                </button>
                            </form>
                        </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</x-app-layout>