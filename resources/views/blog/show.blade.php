<x-layouts::app :title="$post->title">
    <div class="max-w-4xl mx-auto">
        <!-- Post Header -->
        <div class="space-y-4 mb-8">
            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="text-orange-600 dark:text-orange-400 font-semibold hover:text-orange-700 dark:hover:text-orange-300">
                    ← Back to Dashboard
                </a>
                @auth
                    @can('update', $post)
                        <a href="{{ route('blog.edit', $post) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            ✏️ Edit Post
                        </a>
                    @endcan
                @endauth
            </div>

            <!-- Title -->
            <h1 class="text-5xl font-bold text-neutral-900 dark:text-white">{{ $post->title }}</h1>

            <!-- Meta Information -->
            <div class="flex flex-wrap items-center gap-4 text-neutral-600 dark:text-neutral-400">
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.3-1.54c-.3-.36-.77-.36-1.07 0-.3.36-.3.96 0 1.32l1.98 2.36c.3.36.77.36 1.07 0L17 9.7c.3-.36.3-.96 0-1.32-.3-.36-.77-.36-1.07 0z"/></svg>
                    {{ $post->created_at->format('F j, Y') }}
                </span>
                <span class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.5C7.3 4.5 3.3 7.6 1.9 11.9c1.4 4.3 5.4 7.4 10.1 7.4s8.7-3.1 10.1-7.4c-1.4-4.3-5.4-7.4-10.1-7.4zm0 12c-2.5 0-4.5-2-4.5-4.5S9.5 7.5 12 7.5s4.5 2 4.5 4.5-2 4.5-4.5 4.5zm0-7c-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5 2.5-1.1 2.5-2.5-1.1-2.5-2.5-2.5z"/></svg>
                    {{ $post->views }} views
                </span>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 dark:bg-orange-900/40 text-orange-900 dark:text-orange-300">
                    {{ $post->category }}
                </span>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 dark:bg-green-900/40 text-green-900 dark:text-green-300">
                    Published
                </span>
            </div>

            <!-- Author -->
            <div class="flex items-center gap-3 pt-4 border-t border-neutral-200 dark:border-neutral-800">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-bold">
                    {{ $post->user->initials() }}
                </div>
                <div>
                    <p class="font-semibold text-neutral-900 dark:text-white">{{ $post->user->name }}</p>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Author</p>
                </div>
            </div>

            <!-- Excerpt -->
            @if($post->excerpt)
                <div class="italic text-lg text-neutral-600 dark:text-neutral-400 border-l-4 border-orange-500 pl-4 py-2">
                    "{{ $post->excerpt }}"
                </div>
            @endif
        </div>

        <!-- Featured Image -->
        @if($post->featured_image)
            <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
                <img src="{{ Storage::disk('public')->url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
            </div>
        @endif

        <!-- Engagement -->
        <div class="mb-8 flex flex-wrap items-center gap-3 rounded-2xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
            <form action="{{ route('blog.like', $post) }}" method="POST" class="inline-flex">
                @csrf
                <button class="rounded-full bg-orange-100 px-4 py-2 text-sm font-semibold text-orange-700 transition hover:bg-orange-200 dark:bg-orange-900/30 dark:text-orange-200">
                    ❤️ Like
                </button>
            </form>
            <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ $post->views }} views</span>
            <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ $post->comments_count ?? $post->comments->count() ?? 0 }} comments</span>
        </div>

        <div id="comment-form" class="mb-8 rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">Leave a comment</h2>
            <form action="{{ route('blog.comment', $post) }}" method="POST" class="mt-4 space-y-3">
                @csrf
                <textarea name="body" rows="4" class="w-full rounded-xl border border-neutral-300 bg-neutral-50 p-3 text-sm text-neutral-900 focus:border-orange-500 focus:outline-none dark:border-neutral-700 dark:bg-neutral-950 dark:text-white" placeholder="Share your thoughts..."></textarea>
                <button type="submit" class="rounded-full bg-neutral-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-neutral-700 dark:bg-white dark:text-neutral-900 dark:hover:bg-neutral-200">
                    Post comment
                </button>
            </form>
        </div>

        <div class="mb-12 rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">Comments</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Showing the latest conversations first.</p>
                </div>
                <span class="rounded-full bg-neutral-100 px-3 py-1 text-sm font-semibold text-neutral-700 dark:bg-neutral-800 dark:text-neutral-200">
                    {{ $post->comments->count() }} total
                </span>
            </div>

            <div class="space-y-4">
                @forelse($post->comments as $comment)
                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 p-4 dark:border-neutral-800 dark:bg-neutral-950">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold text-neutral-900 dark:text-white">{{ $comment->user->name }}</p>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700 dark:bg-orange-900/30 dark:text-orange-200">
                                {{ $comment->user->initials() }}
                            </span>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-neutral-700 dark:text-neutral-200">{{ $comment->body }}</p>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 p-8 text-center text-neutral-600 dark:border-neutral-700 dark:bg-neutral-950 dark:text-neutral-400">
                        No comments yet. Be the first to start the conversation.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Post Content -->
        <div class="prose dark:prose-invert max-w-none mb-12 text-neutral-800 dark:text-neutral-200">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Tags -->
        @if($post->tags)
            <div class="flex flex-wrap gap-2 mb-8 pb-8 border-t border-neutral-200 dark:border-neutral-800">
                @foreach(explode(',', $post->tags) as $tag)
                    <span class="px-4 py-2 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-white text-sm font-medium hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors cursor-pointer">
                        #{{ trim($tag) }}
                    </span>
                @endforeach
            </div>
        @endif

        <!-- Actions -->
        @auth
            @can('update', $post)
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('blog.edit', $post) }}" class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors text-center">
                        ✏️ Edit Post
                    </a>
                    <form action="{{ route('blog.destroy', $post) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')" class="w-full px-6 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors">
                            🗑️ Delete Post
                        </button>
                    </form>
                </div>
            @endcan
        @endauth
    </div>
</x-layouts::app>
