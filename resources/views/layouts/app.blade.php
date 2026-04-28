<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            window.initIcons = () => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            };
            document.addEventListener('livewire:navigated', window.initIcons);
            document.addEventListener('DOMContentLoaded', window.initIcons);
            
            document.addEventListener('livewire:initialized', () => {
                Livewire.hook('morph.updated', (el, component) => {
                    window.initIcons();
                });
            });
        </script>

        @livewireStyles
        @stack('styles')
    </head>
    <body>
        {{ $slot }}

        @livewireScripts
    </body>
</html>
