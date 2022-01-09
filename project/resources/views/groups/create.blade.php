<x-app-layout>

<div class="border border-gray-200 p-6 rounded-xl">
    <form method="POST" action="{{ route('groups.store') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <x-label for="name" :value="__('Name')" />

            <x-input id="name" class="block mt-1 w-full"
                            type="text"
                            name="name"
                            :value="old('name')" required autofocus />
        </div>

        <x-error name="name"/>

        <div class="mt-4">
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

        <div class="mt-4">
           <x-button class="mt-4 h-full text-center">
                Create
           </x-button>
        </div>
    </form>

</div>
</x-app-layout>
