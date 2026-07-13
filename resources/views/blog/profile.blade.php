<x-layouts::app :title="$user->name">
    <div class="space-y-8">
        <div class="rounded-3xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-amber-500 to-orange-600 text-xl font-bold text-white">
                        {{ $user->initials() }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $user->name }}</h1>
                        <p class="text-neutral-600 dark:text-neutral-400">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-3 items-stretch sm:items-end">
                    @auth
                        @if(Auth::id() !== $user->id)
                            <form action="{{ route('blog.follow', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-orange-500 px-5 py-2 text-sm font-semibold text-white hover:bg-orange-600 transition-colors">
                                    {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                                </button>
                            </form>
                        @endif
                    @endauth
                    <div class="rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-800 dark:bg-amber-900/30 dark:text-amber-200">
                        Author profile
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-4">
                    <div class="rounded-3xl border border-neutral-200 bg-white p-6 text-center shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                        <p class="text-sm uppercase tracking-[0.2em] text-neutral-500 dark:text-neutral-400">Posts</p>
                        <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">{{ $posts->count() }}</p>
                    </div>
                    <div class="rounded-3xl border border-neutral-200 bg-white p-6 text-center shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                        <p class="text-sm uppercase tracking-[0.2em] text-neutral-500 dark:text-neutral-400">Followers</p>
                        <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">{{ $followersCount ?? 0 }}</p>
                    </div>
                    <div class="rounded-3xl border border-neutral-200 bg-white p-6 text-center shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                        <p class="text-sm uppercase tracking-[0.2em] text-neutral-500 dark:text-neutral-400">Following</p>
                        <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">{{ $followingCount ?? 0 }}</p>
                    </div>
                </div>
                <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                    <p class="text-sm uppercase tracking-[0.2em] text-neutral-500 dark:text-neutral-400">Total likes</p>
                    <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">{{ $likesCount ?? 0 }}</p>
                </div>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">About this author</h2>
                <p class="mt-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $user->name }} is sharing stories and insights on the blog. Follow to stay updated on their latest published posts.</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            @forelse($posts as $post)
                <article class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">{{ $post->title }}</h2>
                    <p class="mt-3 text-sm leading-6 text-neutral-600 dark:text-neutral-400">{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 140) }}</p>
                    <div class="mt-5 flex items-center justify-between">
                        <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ $post->published_at?->format('M d, Y') }}</span>
                        <a href="{{ route('blog.show', $post) }}" class="font-semibold text-orange-600 hover:text-orange-700">View post →</a>
                    </div>
                </article>
            @empty
                <div class="lg:col-span-2 rounded-3xl border border-dashed border-neutral-300 bg-white p-10 text-center text-neutral-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400">
                    This author has not published any posts yet.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts::app>
