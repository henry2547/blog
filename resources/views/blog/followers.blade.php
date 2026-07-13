<x-layouts::app :title="__('Followers')">
    <div class="space-y-8">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold text-neutral-900 dark:text-white">Followers</h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">Follow your favorite writers and keep up with their latest work.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">Following</h2>
                <div class="mt-4 space-y-3">
                    @forelse($following as $person)
                        <div class="flex items-center justify-between rounded-2xl bg-neutral-50 p-4 dark:bg-neutral-950">
                            <div>
                                <p class="font-semibold text-neutral-900 dark:text-white">{{ $person->name }}</p>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $person->email }}</p>
                            </div>
                            <a href="{{ route('blog.profile', $person) }}" class="text-sm font-semibold text-orange-600 hover:text-orange-700">View profile</a>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">You are not following anyone yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">Suggested authors</h2>
                <div class="mt-4 space-y-3">
                    @forelse($suggestions as $person)
                        <div class="flex items-center justify-between rounded-2xl bg-neutral-50 p-4 dark:bg-neutral-950">
                            <div>
                                <p class="font-semibold text-neutral-900 dark:text-white">{{ $person->name }}</p>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $person->email }}</p>
                            </div>
                            <a href="{{ route('blog.profile', $person) }}" class="text-sm font-semibold text-orange-600 hover:text-orange-700">Follow</a>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">No suggestions available right now.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
