<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Jangu International') }}</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    @fonts
    <style>
        .hero-fixed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }
        .hero-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,51,102,0.92) 0%, rgba(0,51,102,0.75) 50%, rgba(0,51,102,0.85) 100%);
            z-index: 1;
        }
        .hero-section {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .content-below {
            position: relative;
            z-index: 3;
            background: #ffffff;
        }
    </style>
</head>
<body class="min-h-screen bg-white antialiased">
    <div class="relative">
        {{-- Fixed Hero Background --}}
        <img src="/hero.jpg" alt="" class="hero-fixed">
        <div class="hero-overlay"></div>

        {{-- Minimal Header --}}
        <header class="fixed top-0 left-0 right-0 z-50 bg-transparent">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="https://janguinternational.org" target="_blank">
                    <img src="/logo.svg" alt="Jangu International" class="h-10 w-auto brightness-0 invert">
                </a>
                <nav class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('questionnaire') }}" class="rounded-lg bg-secondary px-4 py-2 text-sm font-semibold text-primary hover:bg-secondary-600 transition-all">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-lg border border-white/30 px-4 py-2 text-sm font-medium text-white hover:bg-white/10 transition-all">Staff Login</a>
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        {{-- Hero Section with Split Layout --}}
        <section class="hero-section pt-20">
            <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid gap-12 lg:grid-cols-2 lg:gap-16 items-start">
                    {{-- Left: Text Content --}}
                    <div class="pt-8 lg:pt-16">
                        <div class="inline-flex items-center gap-2 rounded-full bg-secondary/20 backdrop-blur-sm px-4 py-1.5 text-sm font-medium text-secondary mb-6 border border-secondary/30">
                            <span class="flex size-2 rounded-full bg-secondary animate-pulse"></span>
                            Applications Open
                        </div>
                        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl leading-tight">
                            Empowering<br>
                            <span class="text-secondary">Entrepreneurs</span>
                        </h1>
                        <p class="mt-6 max-w-xl text-lg leading-relaxed text-white/80">
                            Jangu International nurtures the next generation of entrepreneurs through mentorship, resources, and community.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <a href="https://janguinternational.org" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-white/30 bg-white/10 backdrop-blur-sm px-6 py-3 text-sm font-semibold text-white hover:bg-white/20 transition-all">
                                Learn More
                            </a>
                        </div>
                    </div>

                    {{-- Right: Form --}}
                    <div class="w-full">
                        <div class="rounded-2xl bg-white shadow-2xl shadow-primary/20 overflow-hidden">
                            <div class="bg-primary px-6 py-4">
                                <h3 class="text-lg font-bold text-white">Apply Now</h3>
                                <p class="text-sm text-white/70">Complete the form to join our program</p>
                            </div>
                            <div class="p-6 max-h-[600px] overflow-y-auto">
                                @livewire('public-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Below-fold content --}}
        <div class="content-below">
            {{-- Program Details --}}
            <section class="py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-primary sm:text-4xl">Why Join Our Program?</h2>
                        <p class="mt-4 text-lg text-primary/60 max-w-2xl mx-auto">We provide the tools, mentorship, and network you need to turn your business idea into reality.</p>
                    </div>
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="rounded-2xl border border-primary/10 bg-primary/5 p-8 text-center hover:shadow-lg hover:shadow-primary/5 transition-all">
                            <div class="mx-auto flex size-14 items-center justify-center rounded-xl bg-secondary/20 mb-5">
                                <flux:icon name="academic-cap" variant="solid" class="size-7 text-secondary" />
                            </div>
                            <h3 class="text-lg font-semibold text-primary">Mentorship</h3>
                            <p class="mt-2 text-sm text-primary/60">One-on-one guidance from experienced business leaders and industry experts.</p>
                        </div>
                        <div class="rounded-2xl border border-primary/10 bg-primary/5 p-8 text-center hover:shadow-lg hover:shadow-primary/5 transition-all">
                            <div class="mx-auto flex size-14 items-center justify-center rounded-xl bg-secondary/20 mb-5">
                                <flux:icon name="banknotes" variant="solid" class="size-7 text-secondary" />
                            </div>
                            <h3 class="text-lg font-semibold text-primary">Resources</h3>
                            <p class="mt-2 text-sm text-primary/60">Access to funding opportunities, workspace, and business development tools.</p>
                        </div>
                        <div class="rounded-2xl border border-primary/10 bg-primary/5 p-8 text-center hover:shadow-lg hover:shadow-primary/5 transition-all">
                            <div class="mx-auto flex size-14 items-center justify-center rounded-xl bg-secondary/20 mb-5">
                                <flux:icon name="user-group" variant="solid" class="size-7 text-secondary" />
                            </div>
                            <h3 class="text-lg font-semibold text-primary">Community</h3>
                            <p class="mt-2 text-sm text-primary/60">Join a vibrant network of like-minded entrepreneurs and changemakers.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Minimal Footer --}}
            <footer class="border-t border-primary/10 py-8">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                    <img src="/logo.svg" alt="Jangu International" class="h-8 w-auto">
                    <div class="flex items-center gap-4 text-sm text-primary/50">
                        <a href="https://janguinternational.org" target="_blank" class="hover:text-primary transition-colors">Website</a>
                        <a href="mailto:info@janguinternational.org" class="hover:text-primary transition-colors">Contact</a>
                        <span>&copy; {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>