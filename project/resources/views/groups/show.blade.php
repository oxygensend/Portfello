<x-app-layout>


    <div class="flex flex-col space-y-10 items-start" >
        <x-group-box name="{{$group->name}}"
                     avatar="{{asset('/storage/' . $group->avatar)}}"
                     href="{{route('groups.show', $group)}}"/>


        <div class=" pb-2 flex justify-end mt-4">

            <x-button class="ml-4">
                <a href="{{ route('groups.edit', $group) }}">{{ __('Edit') }}</a>
            </x-button>

            <x-action-button name="Delete"
                             action="{{  route('groups.destroy', $group) }}"
                             method='DELETE'
                             class="ml-4"
            />

        </div>

        <div class="absolute right-0 w-full" x-data="{ show: {{ session('show') ?? 'false' }} }">
            <div  class="mt-6" @click="show =! show" >
                <x-floating-button>
                    <x-slot name="button" class="opacity-80 sm:opacity-100"></x-slot>
                    <x-slot name="link" class="font-bold" > Add user
                    </x-slot>
                </x-floating-button>
            </div>
            {{--            <x-add-dropdown group={{ $group }} />--}}

            <x-add-dropdown :group=$group />
        </div>

        <div class="pb-2 flex justify-end mt-4">
                <x-button class="ml-4">
                    <a href="{{route('groups.expenses.index', $group)}}" >{{__('Check history') }}</a>
                </x-button>
                <x-button class="ml-4">
                    <a href="{{ route('groups.expenses.create', $group) }}" > {{__('Add a new expense') }}</a>
                </x-button>
        </div>

    </div>
</x-app-layout>
