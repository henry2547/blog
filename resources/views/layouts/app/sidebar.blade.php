<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-neutral-950">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-900">
            <flux:sidebar.header>
                <!-- Blog Branding -->
                <div class="flex items-center gap-3 px-4 py-3 group">
                    <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-black text-lg group-hover:shadow-lg transition-shadow">✍</div>
                    <div class="flex flex-col">
                        <span class="font-bold text-sm text-neutral-900 dark:text-white">The Daily Quill</span>
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Your Blog</span>
                    </div>
                </div>
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <!-- Main Navigation -->
                <flux:sidebar.group :heading="__('Main')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="hover:bg-orange-50 dark:hover:bg-orange-900/20">
                        <span class="font-medium">{{ __('Dashboard') }}</span>
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <!-- Content Management -->
                <flux:sidebar.group :heading="__('Content')" class="grid">
                    <flux:sidebar.item icon="document-plus" href="{{ route('blog.create') }}" class="hover:bg-blue-50 dark:hover:bg-blue-900/20">
                        <span class="font-medium">{{ __('New Post') }}</span>
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document-text" href="{{ route('blog.index') }}" class="hover:bg-blue-50 dark:hover:bg-blue-900/20">
                        <span class="font-medium">{{ __('All Posts') }}</span>
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="pencil-square" href="{{ route('blog.drafts') }}" class="hover:bg-yellow-50 dark:hover:bg-yellow-900/20">
                        <span class="font-medium">{{ __('Drafts') }}</span>
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="tag" href="{{ route('blog.categories') }}" class="hover:bg-purple-50 dark:hover:bg-purple-900/20">
                        <span class="font-medium">{{ __('Categories') }}</span>
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <!-- Engagement -->
                <flux:sidebar.group :heading="__('Engagement')" class="grid">
                    <flux:sidebar.item icon="chat-bubble-left" href="{{ route('blog.comments') }}" class="hover:bg-green-50 dark:hover:bg-green-900/20">
                        <span class="font-medium">{{ __('Comments') }}</span>
                        
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="heart" href="{{ route('blog.likes') }}" class="hover:bg-red-50 dark:hover:bg-red-900/20">
                        <span class="font-medium">{{ __('Likes & Views') }}</span>
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <!-- Analytics -->
                <flux:sidebar.group :heading="__('Analytics')" class="grid">
                    <flux:sidebar.item icon="chart-bar" href="{{ route('blog.statistics') }}" class="hover:bg-indigo-50 dark:hover:bg-indigo-900/20">
                        <span class="font-medium">{{ __('Statistics') }}</span>
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="users" href="{{ route('blog.followers') }}" class="hover:bg-cyan-50 dark:hover:bg-cyan-900/20">
                        <span class="font-medium">{{ __('Followers') }}</span>
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <!-- Settings & Resources -->
                <flux:sidebar.group :heading="__('Tools')" class="grid">
                    <flux:sidebar.item icon="cog-6-tooth" href="{{ route('profile.edit') }}" wire:navigate class="hover:bg-neutral-100 dark:hover:bg-neutral-800">
                        {{ __('Settings') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="question-mark-circle" href="#" class="hover:bg-neutral-100 dark:hover:bg-neutral-800">
                        {{ __('Help') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <!-- User Menu (Desktop) -->
            <div class="hidden lg:block border-t border-neutral-200 dark:border-neutral-800 p-4">
                <flux:dropdown position="top" align="start">
                    <button class="w-full flex items-center gap-3 rounded-lg p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                        <flux:avatar
                            :name="auth()->user()->name"
                            :initials="auth()->user()->initials()"
                            class="h-8 w-8"
                        />
                        <div class="flex-1 text-start">
                            <div class="text-sm font-semibold text-neutral-900 dark:text-white">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-neutral-500 dark:text-neutral-400 truncate">{{ auth()->user()->email }}</div>
                        </div>
                        <flux:icon icon="chevron-up" class="h-4 w-4" />
                    </button>

                    <flux:menu>
                        <flux:menu.item :href="route('profile.edit')" icon="user-circle" wire:navigate>
                            {{ __('Profile') }}
                        </flux:menu.item>
                        <flux:menu.item icon="cog-6-tooth" :href="route('profile.edit')" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item
                                as="button"
                                type="submit"
                                icon="arrow-right-start-on-rectangle"
                                class="w-full cursor-pointer text-red-600 dark:text-red-400"
                            >
                                {{ __('Log out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden border-b border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <div class="flex items-center gap-2">
                <span class="h-8 w-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-black text-sm">✍</span>
                <span class="font-bold text-neutral-900 dark:text-white">The Daily Quill</span>
            </div>

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
