<x-layouts::app :title="__('Comments')">
    <div class="space-y-8">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">Comments</h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">Review your recent post conversations and feedback.</p>
        </div>

        <div class="rounded-3xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 p-6 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Recent discussion</h2>
                    <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Comments are ready for your next engagement experience.</p>
                </div>
                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-200">
                    0 new
                </span>
            </div>

            <div class="mt-8 space-y-4">
                @forelse($comments as $comment)
                    <div class="rounded-2xl border border-neutral-200 dark:border-neutral-800 bg-neutral-50 p-4 dark:bg-neutral-950">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="font-semibold text-neutral-900 dark:text-white">{{ $comment->post->title }}</p>
                                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Commented by {{ $comment->user->name }} · {{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('blog.show', $comment->post) }}#comment-form" class="rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700 dark:bg-orange-900/30 dark:text-orange-200">
                                View Post
                            </a>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-neutral-700 dark:text-neutral-200">{{ $comment->body }}</p>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-neutral-300 dark:border-neutral-700 bg-neutral-50 p-8 text-center text-neutral-600 dark:bg-neutral-950 dark:text-neutral-400">
                        No comments yet. Once readers leave feedback, it will appear here.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts::app>
