<x-layouts::app :title="__('Dashboard')">
    <div class="space-y-8">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">Welcome back, {{ $user->name }}!</h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">Here is your blog activity, updated from the database.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6 hover:shadow-lg transition-shadow">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-full blur-2xl -mr-10 -mt-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400 uppercase tracking-wide">Published Posts</h3>
                        <span class="h-10 w-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-xl">📝</span>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $stats['published_posts'] }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400">Live count from your posts</p>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6 hover:shadow-lg transition-shadow">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-500/20 to-orange-600/20 rounded-full blur-2xl -mr-10 -mt-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400 uppercase tracking-wide">Total Views</h3>
                        <span class="h-10 w-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-xl">👁️</span>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $stats['total_views'] }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400">Updated from published posts</p>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6 hover:shadow-lg transition-shadow">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-500/20 to-pink-600/20 rounded-full blur-2xl -mr-10 -mt-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400 uppercase tracking-wide">Drafts</h3>
                        <span class="h-10 w-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-xl">📝</span>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $stats['draft_posts'] }}</p>
                        <p class="text-xs text-amber-600 dark:text-amber-400">Saved but not published</p>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6 hover:shadow-lg transition-shadow">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-full blur-2xl -mr-10 -mt-10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400 uppercase tracking-wide">Latest Published</h3>
                        <span class="h-10 w-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-xl">✨</span>
                    </div>
                    <div class="space-y-1">
                        <p class="text-lg font-bold text-neutral-900 dark:text-white">{{ optional($stats['latest_published'])->title ?? 'No published posts yet' }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400">{{ optional($stats['latest_published'])->published_at?->diffForHumans() ?? 'Start by publishing your first post' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-amber-500/10 to-orange-600/10 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl border border-amber-200 dark:border-amber-800 p-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-1">Start Creating</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">Share your next story with your readers</p>
                </div>
                <a href="{{ route('blog.create') }}" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 dark:bg-amber-600 dark:hover:bg-amber-700 text-white font-semibold rounded-lg transition-colors">
                    + New Post
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4">Recent Posts</h2>

                    @if($userPosts->isEmpty())
                        <div class="rounded-xl border border-dashed border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-8 text-center text-neutral-600 dark:text-neutral-400">
                            You have not created any posts yet. Publish your first story to see it here.
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($userPosts->take(5) as $post)
                                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 overflow-hidden hover:shadow-lg transition-all group">
                                    <div class="p-6 space-y-4">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <h3 class="text-xl font-bold text-neutral-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                                                    {{ $post->title }}
                                                </h3>
                                                <div class="flex items-center gap-4 mt-2 flex-wrap">
                                                    <span class="inline-flex items-center gap-1 text-sm text-neutral-600 dark:text-neutral-400">
                                                        📅 {{ $post->created_at->format('F j, Y') }}
                                                    </span>
                                                    <span class="inline-flex items-center gap-1 text-sm text-neutral-600 dark:text-neutral-400">
                                                        👁️ {{ $post->views }} views
                                                    </span>
                                                    <span class="inline-flex items-center gap-1 text-sm text-neutral-600 dark:text-neutral-400">
                                                        🏷️ {{ $post->category ?? 'General' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $post->status === 'published' ? 'bg-green-100 dark:bg-green-900/40 text-green-900 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-900 dark:text-yellow-300' }}">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                        </div>
                                        <p class="text-neutral-600 dark:text-neutral-400 line-clamp-2">
                                            {{ $post->excerpt ?: Illuminate\Support\Str::limit(strip_tags($post->content), 140) }}
                                        </p>
                                        <div class="flex flex-wrap gap-3 pt-2">
                                            <a href="{{ route('blog.edit', $post) }}" class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 rounded-lg border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                                                Edit
                                            </a>
                                            <a href="{{ route('blog.show', $post) }}" class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 rounded-lg border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                                                View
                                            </a>
                                            <form action="{{ route('blog.destroy', $post) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 rounded-lg border border-red-200 dark:border-red-900/50 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Top Posts</h3>
                    <div class="space-y-4">
                        @forelse($topPosts as $index => $post)
                            <div class="flex items-start gap-3 {{ !$loop->last ? 'pb-4 border-b border-neutral-200 dark:border-neutral-700' : '' }}">
                                <span class="text-2xl font-bold text-amber-500">{{ $index + 1 }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-neutral-900 dark:text-white truncate">{{ $post->title }}</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $post->views }} views</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">No published posts yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-6">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        @forelse($userPosts->take(3) as $post)
                            <div class="flex items-start gap-3">
                                <div class="h-2 w-2 rounded-full {{ $post->status === 'published' ? 'bg-green-500' : 'bg-amber-500' }} mt-2 flex-shrink-0"></div>
                                <div>
                                    <p class="text-sm text-neutral-900 dark:text-white">
                                        {{ $post->status === 'published' ? 'Published' : 'Saved as draft' }}: <span class="font-semibold">{{ $post->title }}</span>
                                    </p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $post->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">No activity yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
