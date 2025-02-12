<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        @fluxStyles

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        <title>{{ $title ? 'Mobile Fetch - '.__($title) : 'Mobile Fetch' }}</title>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800 flex flex-col sm:justify-center justify-end items-center px-6 py-12 lg:px-8">
        {{ $slot }}

        @persist('toast')
            <flux:toast position="left bottom right" />
        @endpersist

        @fluxScripts
    </body>
</html>
