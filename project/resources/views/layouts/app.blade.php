<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Portfello') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{--        <link href="https://unpkg.com/tailwindcss@^3.0.12/dist/tailwind.min.css" rel="stylesheet">--}}
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="h-screen bg-gray-100">
            <div class="relative  md:flex flex-row h-screen">
               <x-navigation>
               </x-navigation>
                <div class="w-full h-full flex flex-col">
                    <div class="w-full bg-white h-20 flex justify-start items-center ">
                 <h2 class=" margin_main_x text-3xl tracking-wide font-bold text"> Dashboard</h2>
{{--TODO:title--}}
                    </div>

                    <x-main-content>
                        <main>
                            {{ $slot }}
                        </main>
                    </x-main-content>

                </div>



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
