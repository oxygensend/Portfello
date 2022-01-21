<x-app-layout>
    <x-slot name="header">
        User Panel
    </x-slot>
    <div>
        <div class="md:grid md:grid-cols-1 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">

                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="p-4 bg-white space-y-6 sm:p-6 rounded-md">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3 sm:col-span-2">
                                    <x-label class="block text-sm font-medium text-gray-700 mt-2">
                                        Username
                                    </x-label>
                                    <form method="POST" action="/edit-user/change-username">
                                        @csrf
                                        @method("PATCH")
                                        <div class="mt-1 flex ">
                                            <input type="text" name="name" id="name" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300 mr-2" value="{{$user->name}}">
                                        </div>
                                        <div class="mt-2 flex items-center py-2">
                                            <x-button type="submit">
                                                Change Username
                                            </x-button>
                                            <x-error name="name"/>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3 sm:col-span-2">
                                    <x-label class="block text-sm font-medium text-gray-700">
                                        Current e-mail
                                    </x-label>
                                        <div class="mt-1 flex ">
                                            <p class="mt-2 text-lg">
                                                {{$user->email}}
                                            </p>
                                        </div>
                                    <form method="POST" action="/edit-user/change-email">
                                        @csrf
                                        @method("PATCH")
                                        <div class="mt-1 flex ">
                                            <input type="text" name="email" id="email" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300 mr-2" placeholder="Enter a new email address">
                                            <input type="text" name="repeated_new_email" id="repeated_new_email" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300 mr-2" placeholder="Repeat the same address">
                                        </div>
                                        <div class="mt-2 flex items-center py-2">
                                            <x-button type="submit">
                                                Change Email
                                            </x-button>
                                            <x-error name="email"/>
                                            <x-error name="repeated_new_email"/>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div>
                                <x-label class="block text-sm font-medium text-gray-700">
                                    Update Avatar
                                </x-label>


                                    <form method="POST" action="/edit-user/change-avatar" enctype="multipart/form-data">
                                        @csrf
                                        @method("PATCH")
                                        <div class="flex items-center">
                                            <x-image id="image_preview" src="{{ asset($user->avatar) }}" properties=" mt-1 w-16 h-16 box relative" />
                                        <x-input id="image" class="ml-2 inline-block mt-1"
                                                 type="file"
                                                 name="image" />
                                        </div>
                                        <x-button class="mt-3" type="submit">
                                            Upload
                                        </x-button>
                                        <x-error name="image"/>
                                    </form>


                            </div>
                                <form method="POST" action="/edit-user/change-password">
                                @csrf
                                    @method("PATCH")
                                    <div class="mt-2 flex items-center">

                                        <input type="password" name="current_password" id="current_password" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md border-gray-300 mr-2" placeholder="Current password">
                                        <input type="password" name="new_password" id="new_password" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md border-gray-300 mr-2" placeholder="New password">
                                        <input type="password" name="repeated_new_password" id="repeated_new_password" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md border-gray-300 mr-2" placeholder="Repeat new password">

                                    </div>
                                    <div class="mt-2 flex items-center pb-2">
                                        <x-button type="submit">
                                            Change Password
                                        </x-button>
                                        <x-error name="current_password"/>
                                        <x-error name="new_password"/>
                                        <x-error name="repeated_new_password"/>
                                    </div>
                                </form>
                        </div>

                    </div>

            </div>
        </div>
    </div>
        <div>
            <div class="md:grid md:grid-cols-1 md:gap-6">
                <div class="md:col-span-1">
                    <div class="p-4 sm:px-0 " >
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Pending invites</h3>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class=" sm:rounded-md sm:overflow-hidden pb-2">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6 p-2 rounded-md">
                                @forelse($invites as $invite)
                                    <div class="mt-2 flex items-center">
                                        <strong>{{$invite->text}}</strong>
                                        <x-action-button name="Accept"
                                                         action="{{ route('invites.accept', $invite->id) }}" class="bg-green-500 hover:bg-green-400 flex-1 mr-2 ml-2"
                                        />


                                        <x-action-button name="Discard"
                                                         action="{{ route('invites.delete', $invite->id)}}" class="bg-red-500 hover:bg-red-400 flex-1 mr-2 ml-2"
                                                         method='DELETE'
                                        />
                                    </div>
                                @empty
                                    <p class="p-2">U have no pending invites.</p>
                                @endforelse
                            </div>
                        </div>
                </div>
            </div>
        </div>
    <script type="text/javascript">
        $('#image').change(function(){

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#image_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);

        });
    </script>
</x-app-layout>
