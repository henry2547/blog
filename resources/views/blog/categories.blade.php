<x-layouts::app :title="__('Categories')">
    <div class="space-y-8">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">Categories</h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">Browse the categories your posts are organized under.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-3xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 p-6">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Your post categories</h2>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">A quick view of category counts for your blog content.</p>
                        </div>
                        <a href="{{ route('blog.create') }}" class="inline-flex items-center gap-2 rounded-full bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600 transition-colors">
                            <span>New post</span>
                        </a>
                    </div>

                    @if($categories->isEmpty())
                        <div class="rounded-2xl border border-dashed border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-950 p-10 text-center text-neutral-600 dark:text-neutral-400">
                            <p class="text-lg font-medium">No categories found yet.</p>
                            <p class="mt-2">Create your first post and add a category to get started.</p>
                        </div>
                    @else
                        <div class="grid gap-4">
                            @foreach($categories as $category)
                                <div class="rounded-3xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-6 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <h3 class="text-xl font-semibold text-neutral-900 dark:text-white">{{ ucfirst($category->category) }}</h3>
                                            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">{{ $category->posts_count }} {{ $category->posts_count === 1 ? 'post' : 'posts' }}</p>
                                        </div>
                                        <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-200">
                                            {{ $category->posts_count }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-3xl border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 p-6">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-3">Category tips</h3>
                    <ul class="space-y-3 text-neutral-600 dark:text-neutral-400 text-sm">
                        <li class="space-y-1">
                            <span class="font-semibold">Use meaningful names.</span>
                            <p>Choose categories that describe what readers will find in the post.</p>
                        </li>
                        <li class="space-y-1">
                            <span class="font-semibold">Keep categories concise.</span>
                            <p>One or two words is usually enough, like News, Tech, Design.</p>
                        </li>
                        <li class="space-y-1">
                            <span class="font-semibold">Stay consistent.</span>
                            <p>Reuse category names across posts so readers can explore similar content.</p>
                        </li>
                    </ul>
                </div>

                <div class="rounded-3xl border border-neutral-200 dark:border-neutral-800 bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/10 dark:to-orange-900/10 p-6">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-3">Need a category?</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">Use the post editor to assign a category while writing. It helps readers find your stories faster.</p>
                </div>
            </aside>
        </div>
    </div>
</x-layouts::app>
