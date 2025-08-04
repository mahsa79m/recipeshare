@forelse ($recipes as $recipe)
    <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-1 transition-all duration-300 group">
        <a href="{{ route('recipes.show', $recipe) }}">
            <!-- تصویر -->

            <div class="relative aspect-square">

                 <img src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : 'https://placehold.co/400x300/F5F5F5/333333?text=No+Image' }}"
         alt="{{ $recipe->title }}"
         class="w-full h-full object-cover">
                 <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-40 transition-all duration-300"></div>
</div>

            <!-- محتوا -->
            <div class="p-4 flex flex-col flex-grow">
                <p class="text-xs text-amber-600 font-semibold">{{ $recipe->category->name }}</p>
                <h3 class="font-bold text-lg mt-1 mb-2 text-gray-800 truncate">{{ $recipe->title }}</h3>

                <!-- نویسنده -->
                <div class="flex items-center mt-auto pt-2 border-t border-gray-100">
                    <img class="h-8 w-8 rounded-full object-cover"
                         src="{{ $recipe->user->profile_image_path ? asset('storage/' . $recipe->user->profile_image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($recipe->user->name) }}"
                         alt="{{ $recipe->user->name }}">
                    <div class="mr-2">
                        <p class="text-sm font-medium text-gray-700">{{ $recipe->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ verta($recipe->created_at)->format('%d %B %Y') }}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
@empty
@endforelse
