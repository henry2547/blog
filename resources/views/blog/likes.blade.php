<x-layouts::app :title="__('Likes & Views')">
    <div class="space-y-8">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">Likes & Views</h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">Track how your posts are performing across views and engagement.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            @forelse($posts as $post)
                <div class="rounded-3xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">{{ $post->title }}</h2>
                            <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}</p>
                        </div>
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800 dark:bg-amber-900/30 dark:text-amber-200">
                            {{ $post->status }}
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-neutral-50 p-4 dark:bg-neutral-950">
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">Views</p>
                            <p class="mt-1 text-2xl font-bold text-neutral-900 dark:text-white">{{ $post->views }}</p>
                        </div>
                        <div class="rounded-2xl bg-neutral-50 p-4 dark:bg-neutral-950">
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">Likes</p>
                            <p class="mt-1 text-2xl font-bold text-neutral-900 dark:text-white">{{ $post->likes_count ?? $post->likes->count() }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="lg:col-span-2 rounded-3xl border border-dashed border-neutral-300 dark:border-neutral-700 bg-neutral-50 p-10 text-center text-neutral-600 dark:bg-neutral-950 dark:text-neutral-400">
                    No posts yet. Create a post to start seeing engagement metrics.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts::app>
