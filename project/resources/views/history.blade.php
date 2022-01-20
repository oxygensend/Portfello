<x-app-layout>
    <x-slot name="header">
        Your activity
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="flex justify-center items-center w-full h-full text-2xl font-mono"> History of your expenses </div>
        <br>
        <div class="bg-white v  overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6  bg-white border-b border-gray-200">

                @if($history ->isEmpty())
                    <p class="p-6"> No expenses have been created yet</p>
                @else
                    @foreach($history as $h)
                    You add {{ $h->title }} to {{ $h->id }}
                        <br>
                    @endforeach
                @endif
            </div>
        </div>
    </div>


</x-app-layout>
