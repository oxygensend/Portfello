<x-app-layout>


<div class=" flex flex-col space-y-10  items-start" >

    @forelse ($groups as $group)
        <x-group-box name="{{$group->name}}"
             avatar="{{asset('/storage/' . $group->avatar)}}"
             href="{{route('groups.show', $group)}}"/>
        @empty
            <h2 class="text-xl font-semibold">Nie należysz jeszcze do żadnej grupy. </h2>
    @endforelse

    <a href="{{ route('groups.create')}}" class="mt-2 inline-block text-center bg-gray-800 border border-transparent rounded-md py-3 px-8 font-medium text-white hover:bg-gray-700">Create</a>
    {{$groups->links()  }}

</div>
</x-app-layout>
