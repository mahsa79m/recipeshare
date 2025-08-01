{{-- این فایل فقط شامل لیست نظرات و پاسخ‌هاست --}}
<div class="mt-8 border-t pt-6 space-y-6">
    @forelse ($recipe->comments->sortByDesc('created_at') as $comment)
        <div class="flex space-x-4 space-x-reverse">
            <img src="{{ $comment->user->profile_image_path ? asset('storage/' . $comment->user->profile_image_path) : 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name) }}" alt="{{ $comment->user->name }}" class="w-12 h-12 rounded-full flex-shrink-0">
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <p class="font-semibold text-gray-800">{{ $comment->user->name }}</p>
                    <span class="text-xs text-gray-500">{{ verta($comment->created_at)->formatDifference() }}</span>
                </div>
                <p class="text-gray-600 mt-1">{{ $comment->body }}</p>

                @auth
                    @if(Auth::id() === $recipe->user_id)
                        <button @click="openReplyForm = (openReplyForm === {{ $comment->id }} ? null : {{ $comment->id }})" class="mt-2 text-xs font-semibold text-gray-500 hover:text-amber-600">پاسخ دادن</button>
                    @endif
                @endauth

                <div x-show="openReplyForm === {{ $comment->id }}" x-cloak class="mt-4">
                    <form @submit.prevent="submitForm($event, 'comment')" action="{{ route('comments.store', $recipe) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="body" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500" placeholder="پاسخ خود را بنویسید..."></textarea>
                        <div class="mt-2 flex items-center space-x-2 space-x-reverse">
                            <button type="submit" :disabled="isLoading" class="px-4 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700 disabled:bg-blue-400">ارسال پاسخ</button>
                            <button type="button" @click="openReplyForm = null" class="px-4 py-1.5 bg-gray-200 text-gray-700 text-xs font-semibold rounded-md hover:bg-gray-300">لغو</button>
                        </div>
                    </form>
                </div>

                @if($comment->replies->isNotEmpty())
                    <div class="mt-4 space-y-4 border-r-2 border-gray-200 pr-4">
                        @foreach($comment->replies->sortBy('created_at') as $reply)
                            <div class="flex space-x-3 space-x-reverse">
                                <img src="{{ $reply->user->profile_image_path ? asset('storage/' . $reply->user->profile_image_path) : 'https://ui-avatars.com/api/?name='.urlencode($reply->user->name) }}" alt="{{ $reply->user->name }}" class="w-10 h-10 rounded-full flex-shrink-0">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <p class="font-semibold text-sm text-gray-800">{{ $reply->user->name }}</p>
                                        <span class="text-xs text-gray-500">{{ verta($reply->created_at)->formatDifference() }}</span>
                                    </div>
                                    <p class="text-gray-600 text-sm mt-1">{{ $reply->body }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-center">اولین نفری باشید که نظر می‌دهد!</p>
    @endforelse
</div>
