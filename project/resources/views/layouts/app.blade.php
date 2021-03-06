<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>{{ config('app.name', 'Portfello') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{--        <link href="https://unpkg.com/tailwindcss@^3.0.12/dist/tailwind.min.css" rel="stylesheet">--}}
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>
        <script>

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;
//TODO schowac ten klucz
            var pusher = new Pusher('{{ env('MIX_PUSHER_APP_KEY') }}', {
                cluster: 'eu'
            });



        </script>
    </head>
    <body class="font-sans antialiased ">
        <div class="h-screen bg-gray-100">
            <div class="relative  md:flex flex-row h-screen ">
               <x-navigation />
                <div class="w-full h-full flex flex-col">
                    <div class="w-full bg-white h-20 flex justify-start items-center ">
                 <h2 class=" margin_main_x text-3xl tracking-wide font-bold text">{{ $header ??"" }}</h2>
{{--TODO:title--}}
                    </div>

                    <x-main-content>
                        <main class="h-full w-full">
                            {{ $slot }}
                        </main>
                    </x-main-content>

                </div>


                <x-flash />

            </div>


            <!-- Page Heading -->
{{--            <header class="bg-white shadow">--}}
{{--                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
{{--                    {{ $header }}--}}
{{--                </div>--}}
{{--            </header>--}}

            <!-- Page Content -->



        </div>

    </body>
</html>
