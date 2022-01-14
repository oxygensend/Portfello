<x-app-layout>


    <div class="flex flex-col space-y-10 items-start" >
            <x-group-box name="{{$group->name}}"
                         avatar="{{asset('/storage/' . $group->avatar)}}"
                         href="{{route('groups.show', $group)}}"/>


        <div class=" pb-2 flex justify-end mt-4">
            <form method="get" action="{{ route('groups.edit', $group) }}">

                <x-button class="ml-4">
                    {{ __('Edit') }}
                </x-button>
            </form>
            <form method="post" action="{{ route('groups.destroy', $group) }}"> @csrf @method("DELETE")

                <x-button class="ml-4">
                    {{ __('Delete') }}
                </x-button>
            </form>
        </div>
        <div class="absolute right-0 w-full" x-data="{ show: {{ $show ?? 'false' }} }">
            <div  class="mt-6" @click="show =! show" >
                <x-floating-button>
                    <x-slot name="button" class="opacity-80 sm:opacity-100"></x-slot>
                    <x-slot name="link" class="font-bold" > Add user
                    </x-slot>
                </x-floating-button>
            </div>
{{--            <x-add-dropdown group={{ $group }} />--}}

            <x-add-dropdown group={{ $group }} />
        </div>

    </div>
</x-app-layout>
