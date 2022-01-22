<x-app-layout  >
<x-slot name="header">
    Dashboard
</x-slot>
    <h2 class="text-3xl mb-10 font-semibold">Overall you are owed {{Auth::user()->getBilance()}}</h2>
    <div class="  flex flex-col space-y-10  items-start" >

        @forelse ($groups as $group)
            <x-group-box name="{{$group->name}}"
                         avatar="{{asset($group->avatar)}}"
                         href="{{route('groups.show', $group)}}"
                         :group="$group"
            />

        @emptygrab
            <h2 class="text-xl font-semibold">Nie należysz jeszcze do żadnej grupy. </h2>
        @endforelse



    </div>

</x-app-layout>




