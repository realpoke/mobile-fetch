<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxStyles

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        <title>{{ $title ? 'Mobile Fetch - '.__($title) : 'Mobile Fetch' }}</title>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <flux:brand wire:navigate href="{{ route('landing.page') }}" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc." class="px-2 dark:hidden" />
            <flux:brand wire:navigate href="{{ route('landing.page') }}" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc." class="px-2 hidden dark:flex" />

            <flux:navlist variant="outline">
                <livewire:landing.landing-lists-component />
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item wire:navigate href="{{ route('landing.page') }}" icon="plus-circle">{{ __('list.new') }}</flux:navlist.item>
            </flux:navlist>

            <flux:modal.trigger class="hidden lg:block" name="edit-profile">
                <livewire:profile.profile-name-component />
            </flux:modal.trigger>
        </flux:sidebar>

        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:modal.trigger name="edit-profile">
                <livewire:profile.profile-name-component />
            </flux:modal.trigger>
        </flux:header>

        <flux:modal name="edit-profile" variant="flyout" position="right">
            <livewire:profile.profile-form-component />
        </flux:modal>

        <flux:main>
            {{ $slot }}
        </flux:main>

        @persist('toast')
            <flux:toast position="left bottom right" />
        @endpersist

        @fluxScripts
    </body>
</html>
