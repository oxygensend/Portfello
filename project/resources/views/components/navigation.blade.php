
    <!-- mobile menu bar -->
    <div class="bg-sidebar_main_color text-gray-100 flex justify-between md:hidden">
        <!-- logo -->
        <a href="#" class="block p-4 text-white font-bold"> </a>

        <!-- mobile menu button -->
        <button class="mobile-menu-button p-4 focus:outline-none focus:bg-gray-700">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>


<!-- sidebar -->
    <div class="sidebar h-full left-0 top-0 md:min-h-screen	 bg-sidebar_main_color text-blue-100 w-64 space-y-6 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">
<div class ="sidebar-content justify-between h-full flex flex-col	" >
        <!-- logo -->

    <x-sidebar-padding-box><div class="sidebar-upper_box">
            <a href="#" class="text-white flex items-center space-x-2 px-4">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span class="text-2xl font-extrabold">{{ __('Portfello') }}</span>
            </a>

            <!-- nav -->
            <nav class="mt-7">
                <x-side-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-side-link>
                <x-side-link :href="route('dashboard')" :active="request()->routeIs('groups')">
                    {{ __('Groups') }}
                </x-side-link>
                <x-side-link :href="route('dashboard')" :active="request()->routeIs('history')">
                    {{ __('History') }}
                </x-side-link>
                <x-side-link :href="route('dashboard')">
                    {{ __('Log out') }}
                </x-side-link>

                {{--            <div>{{ Auth::user()->name }}</div>--}}

            </nav>
        </div></x-sidebar-padding-box>

<x-sidebar-userbox></x-sidebar-userbox>

    </div>


</div>
