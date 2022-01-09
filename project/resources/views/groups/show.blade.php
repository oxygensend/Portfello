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
            <form method="post" action="{{ route('groups.destroy', $group) }}">
                @csrf
                @method("DELETE")

                <x-button class="ml-4">
                    {{ __('Delete') }}
                </x-button>
            </form>
        </div>

    </div>
</x-app-layout>
