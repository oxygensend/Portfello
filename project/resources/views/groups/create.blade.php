<x-app-layout>
    <x-slot name="header">
        Create group
    </x-slot>
<div class="flex justify-center items-center w-full h-full">
<div class="border border-gray-200  rounded-xl h-max	pt-6 pb-16 px-6  w-full  sm:w-8/12 md:w-5/12 min-w-[350px]">
    <form method="POST" action="{{ route('groups.store') }}" enctype="multipart/form-data" class="w-full h-full flex flex-col justify-between">
        @csrf

        <div>
            <x-label for="name" :value="__('Name')" />

            <x-input id="name" class="block mt-1 w-full"
                            type="text"
                            name="name"
                            :value="old('name')" required autofocus />
        </div>

        <x-error name="name"/>

        <div class="mt-4 w-max">
            <x-label for="avatar" :value="__('Avatar')" />

            <x-input id="avatar" class="p-2 border border-gray-400 rounded w-full bg-white"
                            type="file"
                            name="avatar"
                            :value="old('avatar')"
                            />
        </div>

        <x-error name="avatar"/>


        <div class="mt-4">
            <x-label for="smart_billing" :value="__('Smart billing')" />

            <x-input id="smart_billing" class="p-2 border border-gray-400 rounded"
                            type="checkbox"
                            name="smart_billing"
                            value="1"
                             />
        </div>

        <div class="mt-4 ">
           <x-button class="mt-4 h-full text-center">
                Create
           </x-button>
        </div>
    </form>

</div>
</div>
</x-app-layout>
