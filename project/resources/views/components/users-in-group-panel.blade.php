@props(['users', 'group'])
<div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table class="min-w-full text-center">
                    <thead class="border-b bg-gray-800">
                    <tr>
                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                            #
                        </th>
                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                            Name
                        </th>
                        <th scope="col" class="text-sm items-center justify-center  font-medium text-white px-6 py-4">
                            Avatar
                        </th>
                        <th scope="col" class="text-sm font-medium text-white px-6 py-4">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $id=1 @endphp
                    @foreach($users as $user)

                        <tr class="bg-white border-b">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $id++ }}</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                @if($user->id==auth()->user()->id)
                                    {{$user->name."(You)"}}
                                @else
                                    {{$user->name}}
                                @endif
                            </td>
                            <td class="text-sm text-gray-900 font-light  px-6 py-4 whitespace-nowrap">
                                <x-image src="{{$user->avatar}}" properties=" w-12 h-12 rounded-xl overflow-hidden" />
                            </td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                @admin($group)
                                @if($user->id==auth()->user()->id)
                                @else

                                    <form method="POST" action="{{route('groups.add-user.destroy', [$group,$user->id])}}" >
                                        @csrf
                                        @method('DELETE')
                                        <button id="{{"delete".$user->id}}" class="delete" data-toggle="modal"><i class="material-icons text-red-600"
                                                                                      onclick="return confirm('Are you sure you want to remove this user from group?')"
                                                                                      data-toggle="tooltip" title="Delete">&#xE872;</i></button>
                                    </form>
                                    <script src="https://code.iconify.design/2/2.1.1/iconify.min.js"></script>
                                    <form method="POST" action="{{route('groups.add-user.update', [$group,$user->id])}}" >
                                        @csrf
                                        @method('PATCH')
                                        <button class="update" ><i class="iconify text-yellow-600" data-icon="mdi:crown" data-width="24" data-height="24"
                                                                                      onclick="return confirm('Are you sure you want grant admin role to this user?')"
                                                                                       title="Update"></i></button>
                                    </form>
                                @endif
                                @endadmin
                                @elseadmin($group)
                                @if($user->id==auth()->user()->id)
                                    <form method="POST" action="{{route('groups.add-user.destroy', [$group,$user->id])}}" >
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete" data-toggle="modal"><i class="material-icons text-red-600" data-toggle="tooltip" title="Delete">&#xE872;</i></button>
                                    </form>

                                @endif
                                @endelseadmin
                            </td>
                        </tr >
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
