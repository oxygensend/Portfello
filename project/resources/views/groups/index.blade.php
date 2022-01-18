<x-app-layout>

<div class=" overflow-auto  h-full w-full">
    <div class="overflow-auto flex flex-col space-y-10  items-start" >

        @forelse ($groups as $group)
            <x-group-box name="{{$group->name}}"
                         avatar="{{asset($group->avatar)}}"
                         href="{{route('groups.show', $group)}}"/>
        @empty
            <h2 class="text-xl font-semibold">Nie należysz jeszcze do żadnej grupy. </h2>
        @endforelse


        {{ $groups->links() }}
    </div>

    <x-floating-button>

        <x-slot name="button" class="opacity-80 sm:opacity-100"></x-slot>
        <x-slot name="link" class="font-bold"  href="{{ route('groups.create')}}">
            Create
        </x-slot>

    </x-floating-button>

</div>

</x-app-layout>
