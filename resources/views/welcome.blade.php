<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Jangu International') }}</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    @fonts
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-blue-50 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 antialiased">
    <div class="min-h-screen">
        {{-- Header --}}
        <header class="border-b border-emerald-200/50 bg-white/80 backdrop-blur-sm dark:border-emerald-800/30 dark:bg-zinc-900/80">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600">
                        <flux:icon name="document-text" variant="solid" class="size-5 text-white" />
                    </div>
                    <span class="text-lg font-bold bg-gradient-to-r from-emerald-600 to-blue-600 bg-clip-text text-transparent">{{ config('app.name', 'Jangu International') }}</span>
                </div>
                <nav class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <flux:button :href="route('questionnaire')" variant="primary" icon="chart-bar">
                                Admin Dashboard
                            </flux:button>
                        @else
                            <flux:button :href="route('login')" variant="ghost">Log in</flux:button>
                            @if (Route::has('register'))
                                <flux:button :href="route('register')" variant="primary">Register</flux:button>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        {{-- Hero --}}
        <section class="relative overflow-hidden border-b border-emerald-200/30 dark:border-emerald-800/20">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 via-transparent to-blue-500/10"></div>
            <div class="absolute -top-24 -right-24 size-96 rounded-full bg-emerald-500/5 blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 size-96 rounded-full bg-blue-500/5 blur-3xl"></div>
            <div class="relative mx-auto max-w-4xl px-4 py-16 text-center sm:px-6 lg:px-8">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-200/50 bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 dark:border-emerald-700/30 dark:bg-emerald-900/20 dark:text-emerald-300">Now accepting applications</div>
                <flux:heading size="xl" class="mb-3">Apply for the Entrepreneurship Program</flux:heading>
                <flux:text class="mx-auto max-w-2xl text-base">
                    We are excited that you are interested in joining our program. Please complete the application form below with accurate information. All fields marked with <span class="text-red-500">*</span> are required.
                </flux:text>
            </div>
        </section>

        {{-- Form --}}
        <main class="relative mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 via-transparent to-blue-500/5 pointer-events-none"></div>
            <div class="relative">
                @livewire('public-form')
            </div>
        </main>

        {{-- Footer --}}
        <footer class="border-t border-emerald-200/30 bg-gradient-to-r from-emerald-50 via-white to-blue-50 dark:border-emerald-800/20 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900">
            <div class="mx-auto max-w-7xl px-4 py-8 text-center sm:px-6 lg:px-8">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <a href="https://janguinternational.org" target="_blank" class="flex items-center gap-1.5 text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                        <flux:icon name="globe-alt" class="size-4" /> Website
                    </a>
                </div>
                <flux:text variant="subtle" class="text-sm">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Jangu International') }}. All rights reserved.
                </flux:text>
            </div>
        </footer>
    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>
