<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('groups.show', $group) }}">{{$group->name}}</a>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @admin($group)
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



                        <div class="mt-4 flex inline space-x-2">
                            <x-button id="Update" name="Update" class="text-center">
                                Update
                            </x-button>

                        </div>
                    </form>

                    <div class="mt-4 flex inline space-x-2">
                        <x-action-button name="Delete"
                                     id="delete"
                                     action="{{  route('groups.destroy', $group) }}"
                                     method='DELETE'
                                     onclick="return confirm('Are you sure you want to delete this group?')"
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


                </div>
            </div>
        </div>
        @endadmin
        <x-users-in-group-panel :users="$users" :group="$group" />

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
