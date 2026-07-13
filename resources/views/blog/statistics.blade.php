<x-layouts::app :title="__('Statistics')">
    <div class="space-y-8">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">Statistics</h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">A quick snapshot of your publishing activity.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-sm font-semibold uppercase tracking-wide text-neutral-500">Published</p>
                <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">{{ $stats['published'] }}</p>
            </div>
            <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-sm font-semibold uppercase tracking-wide text-neutral-500">Drafts</p>
                <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">{{ $stats['drafts'] }}</p>
            </div>
            <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-sm font-semibold uppercase tracking-wide text-neutral-500">Total Views</p>
                <p class="mt-3 text-3xl font-bold text-neutral-900 dark:text-white">{{ $stats['views'] }}</p>
            </div>
            <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                <p class="text-sm font-semibold uppercase tracking-wide text-neutral-500">Top Post</p>
                <p class="mt-3 text-lg font-semibold text-neutral-900 dark:text-white">{{ optional($stats['top_viewed'])->title ?? 'No published posts yet' }}</p>
            </div>
        </div>
    </div>
</x-layouts::app>
