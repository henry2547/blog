<x-layouts::app :title="__('Draft Posts')">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Draft Posts</h1>
                <p class="text-neutral-600 dark:text-neutral-400">All your unpublished posts in one place.</p>
            </div>
            <a href="{{ route('blog.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-orange-600 px-4 py-2 font-semibold text-white shadow hover:shadow-lg transition">
                ✍️ New Post
            </a>
        </div>

        @if($posts->isEmpty())
            <div class="rounded-xl border border-dashed border-neutral-300 bg-white p-8 text-center dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-lg font-semibold text-neutral-900 dark:text-white">No drafts yet</p>
                <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">Save a post as a draft to see it here.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($posts as $post)
                    <div class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-neutral-800 dark:bg-neutral-900">
                        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">{{ $post->title }}</h2>
                                <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                                    Last updated {{ $post->updated_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-900 dark:bg-yellow-900/40 dark:text-yellow-300">Draft</span>
                                <a href="{{ route('blog.edit', $post) }}" class="rounded-lg border border-neutral-300 px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts::app>
