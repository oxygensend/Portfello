<x-app-layout>
    <x-slot name="header">
        {{$group->name . ' - settings'}}
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white v  overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6  bg-white border-b border-gray-200">


                    <form method="post" action="{{ route('groups.update', $group) }}" enctype="multipart/form-data">

                        @csrf
                        @method("PUT")
                        <div>
                            <x-label for="name" :value="__('Change name')"/>

                            <x-input id="name" class="block mt-1 w-full"
                                     type="text"
                                     name="name"
                                     :value="$group->name" autofocus/>
                        </div>

                        <x-error class="mb-4" name="name"/>

                        <div class="mt-4">
                            <x-label for="avatar" :value="__('Change avatar')"/>

                            <x-input id="avatar" class="p-2 border border-gray-400 rounded w-full bg-white"
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
                            <x-button class="text-center">
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
                    <x-add-dropdown group={{ $group }} />

                    <x-add-dropdown :group=$group/>


                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
