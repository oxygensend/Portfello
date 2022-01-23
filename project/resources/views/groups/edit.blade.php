<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('groups.show', $group) }}">{{$group->name}}</a>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white v  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6  bg-white border-b border-gray-200">


                    <form method="post" action="{{ route('groups.update', $group) }}" enctype="multipart/form-data">

                        @csrf
                        @method("PUT")
                        <div >
                            <x-label for="name" :value="__('Change name')"/>

                            <x-input id="name" class="block mt-1 w-full"
                                     type="text"
                                     name="name"
                                     :value="$group->name" autofocus/>
                        </div>

                        <x-error class="mb-4" name="name"/>

                        <x-label class="mt-4" for="avatar" :value="__('Change avatar')"/>
                        <div class="mt-4 flex items-center ">
                            <x-image id="preview_avatar" src="{{ asset($group->avatar) }}" properties="w-32 h-32 box relative" />
                            <x-input id="avatar" class="ml-4 p-2 h-10  border border-gray-400 rounded  bg-white"
                                     type="file"
                                     name="avatar"
                                     :value="old('avatar')"
                            />
                        </div>

                        <x-error class="mb-4" name="avatar"/>


                        <div class="mt-4">
                            <x-label for="smart_billing" :value="__('Start using smart billing')"/>

                            <x-input id="smart_billing" class="p-2 border border-gray-400 rounded"
                                     type="checkbox"
                                     name="smart_billing"
                                     value=1
                            />
                        </div>

                        <div class="mt-4 flex space-x-2">
                            <x-button id="Update" name="Update" class="text-center">
                                Update
                            </x-button>

                    </form>

                    <x-action-button name="Delete"
                                     action="{{  route('groups.destroy', $group) }}"
                                     method='DELETE'
                    />

                </div>


                <div x-data="{ show: {{ session('show') ?? 'false' }} }">
                    <div class="mt-6" @click="show =! show">
                        <x-floating-button>
                            <x-slot name="button" class="opacity-80 sm:opacity-100"></x-slot>
                            <x-slot name="link" class="font-bold"> Add user
                            </x-slot>
                        </x-floating-button>
                    </div>
                    <x-add-dropdown :group="$group" />



                    </form>
                </div>
            </div>
        </div>

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
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        <x-image src="{{$user->avatar}}" properties="w-12 h-12 rounded-xl overflow-hidden" />
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        @admin($group)
                                        @if($user->id==auth()->user()->id)
                                        @else

                                            <form method="POST" action="{{route('groups.add-user.destroy', [$group,$user->id])}}" >
                                                @csrf
                                                @method('DELETE')
                                                <button class="delete" data-toggle="modal"><i class="material-icons text-red-600" data-toggle="tooltip" title="Delete">&#xE872;</i></button>
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

    </div>

    <script type="text/javascript">
        $('#avatar').change(function(){

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview_avatar').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);

        });
    </script>
</x-app-layout>
