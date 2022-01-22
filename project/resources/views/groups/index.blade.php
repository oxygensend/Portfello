<x-app-layout>

    <x-slot name="header">
        <a href="{{ route('groups.index') }}">Groups</a>
    </x-slot>

    <div class=" overflow-auto  h-full w-full">
        <div class="overflow-auto flex flex-col space-y-10  items-start">

            @forelse ($groups as $group)
                <x-group-box name="{{$group->name}}"
                             avatar="{{asset($group->avatar)}}"
                             href="{{route('groups.show', $group)}}"
                             balance="true"
                :group="$group"
                />


{{--                <h2> {{Auth::user->balancePaymentInGroup( $group)}}</h2>--}}
            @empty
                <h2 class="text-xl font-semibold">Nie należysz jeszcze do żadnej grupy. </h2>
            @endforelse
{{--            TODO--}}
{{--            {{ $groups->links() }}--}}
        </div>

        <x-floating-button>

            <x-slot name="button" class="opacity-80 sm:opacity-100"></x-slot>
            <x-slot name="link" class="font-bold" href="{{ route('groups.create')}}">
                Create
            </x-slot>

        </x-floating-button>

    </div>

</x-app-layout>
