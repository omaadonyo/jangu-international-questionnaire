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
</head>
<body class="min-h-screen bg-white antialiased">
    <div class="min-h-screen">
        {{-- Header --}}
        <header class="fixed top-0 left-0 right-0 z-50 border-b border-primary/10 bg-white/95 backdrop-blur-md">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <a href="https://janguinternational.org" target="_blank" class="flex items-center gap-3">
                    <img src="/logo.svg" alt="Jangu International" class="h-10 w-auto">
                    <span class="text-lg font-bold text-primary">Jangu International</span>
                </a>
                <nav class="flex items-center gap-3">
                    <a href="https://janguinternational.org" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-primary/70 hover:text-primary transition-colors">
                        <flux:icon name="globe-alt" class="size-4" /> Our Website
                    </a>
                    @if (Route::has('login'))
                        @auth
                            <flux:button :href="route('questionnaire')" variant="primary">
                                Admin Dashboard
                            </flux:button>
                        @else
                            <flux:button :href="route('login')" variant="primary">Staff Login</flux:button>
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        {{-- Hero Section --}}
        <section class="relative min-h-screen flex items-center overflow-hidden pt-16">
            <div class="absolute inset-0">
                <img src="/hero.jpg" alt="Jangu International" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-primary/90 via-primary/70 to-primary/40"></div>
            </div>
            <div class="relative mx-auto w-full max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full bg-secondary/20 backdrop-blur-sm px-4 py-1.5 text-sm font-medium text-secondary mb-6 border border-secondary/30">
                        <span class="flex size-2 rounded-full bg-secondary animate-pulse"></span>
                        Applications Open
                    </div>
                    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl leading-tight">
                        Empowering<br>
                        <span class="text-secondary">Entrepreneurs</span>
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-white/80">
                        Jangu International is dedicated to nurturing the next generation of entrepreneurs. Our program provides mentorship, resources, and a community to help you build a sustainable future.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="#application-form" class="inline-flex items-center gap-2 rounded-xl bg-secondary px-6 py-3 text-sm font-semibold text-primary-foreground hover:bg-secondary-600 transition-all shadow-lg shadow-secondary/25">
                            Apply Now
                            <flux:icon name="arrow-down" class="size-4" />
                        </a>
                        <a href="https://janguinternational.org" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-white/30 bg-white/10 backdrop-blur-sm px-6 py-3 text-sm font-semibold text-white hover:bg-white/20 transition-all">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white to-transparent"></div>
        </section>

        {{-- Program Details --}}
        <section class="py-20 bg-white">
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

        {{-- Application Form Section --}}
        <section id="application-form" class="py-20 bg-gradient-to-b from-primary/5 to-white">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-1.5 text-sm font-medium text-primary mb-4">Application Form</div>
                    <h2 class="text-3xl font-bold text-primary sm:text-4xl">Ready to Apply?</h2>
                    <p class="mt-4 text-lg text-primary/60">Complete the form below to start your journey with Jangu International.</p>
                </div>
                @livewire('public-form')
            </div>
        </section>

        {{-- Footer --}}
        <footer class="bg-primary text-white">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center gap-6 sm:flex-row sm:justify-between">
                    <div class="flex items-center gap-3">
                        <img src="/logo.svg" alt="Jangu International" class="h-8 w-auto brightness-0 invert">
                        <span class="text-lg font-bold">Jangu International</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="https://janguinternational.org" target="_blank" class="text-sm text-white/70 hover:text-white transition-colors">Website</a>
                        <a href="mailto:info@janguinternational.org" class="text-sm text-white/70 hover:text-white transition-colors">Contact</a>
                    </div>
                </div>
                <div class="mt-8 border-t border-white/10 pt-6 text-center text-sm text-white/50">
                    &copy; {{ date('Y') }} Jangu International. All rights reserved.
                </div>
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