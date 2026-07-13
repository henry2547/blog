<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Daily Quill - Modern Blog Platform</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    {{-- tailwind --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    @fonts
</head>

<body class="bg-white dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100 min-h-screen flex flex-col antialiased">
    
    <!-- Top Header & Navigation -->
    <header class="w-full sticky top-0 z-50 bg-white/95 dark:bg-neutral-950/95 backdrop-blur-md border-b border-neutral-200/60 dark:border-neutral-800/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <!-- Brand Logo / Name -->
                <a href="/" class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-white flex items-center gap-3 group">
                    <span class="h-8 w-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-black text-sm group-hover:shadow-lg transition-shadow">✍</span>
                    <span class="text-xl font-bold bg-gradient-to-r from-neutral-900 to-neutral-700 dark:from-white dark:to-neutral-300 bg-clip-text text-transparent">The Daily Quill</span>
                </a>

                <!-- Authentication Navigation -->
                @if (Route::has('login'))
                    <nav class="flex items-center gap-2 sm:gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center px-6 py-2.5 font-semibold text-sm rounded-lg bg-gradient-to-r from-amber-500 to-orange-600 text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center px-6 py-2.5 font-semibold text-sm rounded-lg bg-gradient-to-r from-amber-500 to-orange-600 text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                                Sign In
                            </a>
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="w-full flex-1 flex flex-col">
        
        <!-- Hero Section with Image -->
        <section class="w-full bg-gradient-to-b from-neutral-50 to-white dark:from-neutral-900 dark:to-neutral-950 py-12 md:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                    <!-- Text Content -->
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-900 dark:text-amber-300 text-sm font-semibold border border-amber-200 dark:border-amber-800">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                            </span>
                            Fresh Stories Daily
                        </div>
                        <h1 class="text-5xl md:text-6xl font-bold tracking-tight leading-tight">
                            <span class="bg-gradient-to-r from-neutral-900 via-orange-600 to-neutral-900 dark:from-white dark:via-orange-400 dark:to-neutral-300 bg-clip-text text-transparent">Your Daily Inspiration</span>
                        </h1>
                        <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-300 leading-relaxed">
                            Discover thought-provoking articles on technology, design, culture, and innovation. A curated collection of stories that inspire and educate.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center px-8 py-3 font-semibold text-lg rounded-lg bg-gradient-to-r from-amber-500 to-orange-600 text-white hover:shadow-xl hover:scale-105 transition-all duration-200">
                                Start Reading
                            </a>
                            <a href="#featured"
                                class="inline-flex items-center justify-center px-8 py-3 font-semibold text-lg rounded-lg border-2 border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors duration-200">
                                Explore Articles
                            </a>
                        </div>
                    </div>

                    <!-- Hero Image -->
                    <div class="hidden md:block relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-500/20 to-orange-600/20 rounded-2xl blur-2xl"></div>
                        <img src="https://img.magnific.com/free-vector/blogging-fun-content-creation-online-streaming-video-blog-young-girl-making-selfie-social-network-sharing-feedback-self-promotion-strategy_335657-2386.jpg?semt=ais_hybrid&w=740&q=80" 
                            alt="The Daily Quill Blog" 
                            class="relative rounded-2xl shadow-2xl w-full h-auto object-cover border border-neutral-200 dark:border-neutral-800">
                    </div>
                </div>
            </div>
        </section>

       

        <!-- CTA Section -->
        <section class="w-full bg-gradient-to-r from-amber-500/10 to-orange-600/10 dark:from-amber-900/20 dark:to-orange-900/20 py-16 md:py-24">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
                <div class="space-y-4">
                    <h2 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white">Ready to Join Us?</h2>
                    <p class="text-xl text-neutral-600 dark:text-neutral-300">Create your account and start your journey with The Daily Quill today.</p>
                </div>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-10 py-4 font-bold text-lg rounded-lg bg-gradient-to-r from-amber-500 to-orange-600 text-white hover:shadow-2xl hover:scale-105 transition-all duration-200">
                    Get Started Now
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="w-full bg-neutral-900 dark:bg-neutral-950 text-neutral-400 dark:text-neutral-500 border-t border-neutral-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="space-y-4">
                    <h3 class="text-white font-bold flex items-center gap-2">
                        <span class="h-6 w-6 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-sm">✍</span>
                        The Daily Quill
                    </h3>
                    <p class="text-sm">Your daily source of inspiration and quality content.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Explore</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Latest Articles</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Categories</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Authors</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Connect</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Twitter</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">LinkedIn</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-neutral-800 pt-8 flex flex-col sm:flex-row items-center justify-between">
                <p class="text-sm">&copy; {{ date('Y') }} The Daily Quill. All rights reserved.</p>
                <p class="text-sm">Crafted with <span class="text-red-500">❤️</span> for writers and readers</p>
            </div>
        </div>
    </footer>
</body>

</html>
