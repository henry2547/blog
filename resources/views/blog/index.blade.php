<x-layouts::app :title="__('All Posts')">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">All Posts</h1>
                <p class="text-neutral-600 dark:text-neutral-400">Browse published posts from the community.</p>
            </div>
            <a href="{{ route('blog.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-orange-600 px-4 py-2 font-semibold text-white shadow hover:shadow-lg transition">
                ✍️ New Post
            </a>
        </div>

        @if($posts->isEmpty())
            <div class="rounded-xl border border-dashed border-neutral-300 bg-white p-8 text-center dark:border-neutral-700 dark:bg-neutral-900">
                <p class="text-lg font-semibold text-neutral-900 dark:text-white">No posts yet</p>
                <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">The blog is waiting for its first story.</p>
            </div>
        @else
            <div class="grid gap-5 md:grid-cols-2">
                @foreach($posts as $post)
                    <article class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-neutral-800 dark:bg-neutral-900">
                        <div class="flex items-center justify-between text-sm text-neutral-500 dark:text-neutral-400">
                            <span class="rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700 dark:bg-orange-900/40 dark:text-orange-300">
                                {{ ucfirst($post->category ?? 'General') }}
                            </span>
                            <span>{{ $post->published_at?->format('M d, Y') ?? $post->created_at->format('M d, Y') }}</span>
                        </div>

                        <h2 class="mt-4 text-xl font-semibold text-neutral-900 dark:text-white">
                            <a href="{{ route('blog.show', $post) }}" class="hover:text-orange-600 dark:hover:text-orange-400">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <p class="mt-3 text-sm leading-6 text-neutral-600 dark:text-neutral-400">
                            {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 140) }}
                        </p>

                        <div class="mt-5 flex items-center justify-between text-sm text-neutral-500 dark:text-neutral-400">
                            <span>By <a href="{{ route('blog.profile', $post->user) }}" class="font-semibold text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300">{{ $post->user?->name ?? 'Unknown author' }}</a></span>
                            <a href="{{ route('blog.show', $post) }}" class="font-semibold text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300">
                                Read more →
                            </a>
                        </div>

                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <form action="{{ route('blog.like', $post) }}" method="POST" class="inline-flex">
                                @csrf
                                <button type="submit" class="rounded-full bg-orange-100 px-3 py-1 text-sm font-semibold text-orange-700 transition hover:bg-orange-200 dark:bg-orange-900/30 dark:text-orange-200">
                                    ❤️ Like
                                </button>
                            </form>
                            <a href="{{ route('blog.show', $post) }}#comment-form" class="rounded-full bg-neutral-100 px-3 py-1 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-200 dark:bg-neutral-800 dark:text-neutral-200">
                                💬 Comment
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts::app>
