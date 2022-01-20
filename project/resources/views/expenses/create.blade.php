<x-app-layout>

    <x-slot name="header">
        <a href="{{ route('groups.show', $group) }}">{{$group->name}}</a>
    </x-slot>

    <div class="flex justify-center items-center w-full h-full">
        <div x-data="{ show: false }"
             class="border border-gray-200  rounded-xl h-max	pt-6 pb-16 px-6  w-full  sm:w-8/12 md:w-5/12 min-w-[350px]">

            <form method="post" action="{{ route('groups.expenses.store', $group) }}">
                @csrf
                <div x-data="{ show_item:false}" class="flex flex-col   ">

                    <div>
                        <x-label for="description" :value="__('Description')"/>
                        <x-input id="description" class="block mt-1 w-full"
                                 type="text"
                                 name="description"
                                 :value="old('description')" autofocus/>

                    </div>

                    <div>
                        <x-label for="option" :value="__('How')"/>
                        <select id="how" name="how"
                                @change='event.target.value == "item" ? show_item = true : show_item = false'>
                            <option name="money" value="money">Money</option>
                            <option name="item" value="item">Item</option>
                        </select>

                    </div>

                    <x-show-item group={{ $group }} />


                    <div class="flex  items-center mt-10">
                        <x-button type="button" id='button_select' x-on:click="show = ! show"
                                  class=" font-medium font-bold">
                            Select users
                        </x-button>
                    </div>


                    {{--                    MODAL--}}
                    <div x-show="show" class="fixed inset-0  w-screen h-screen flex justify-center items-center 	">

                        <div class="absolute inset-0 bg-neutral-300 opacity-70 "></div>
                        <div
                            class="w-4/12 rounded-lg h-5/6 bg-white z-50 flex flex-col items-center justify-between   p-10  space-y-6">

                            <div class="w-full min-h-0 text_and_checkboxes flex flex-col space-y-10 ">

                                <div class="text-2xl flex-none	font-semibold text-center">Select users</div>

                                <div
                                    class="w-full 	 flex-auto overflow-y-auto flex flex-col  justify-center items-center space-y-4 scroll-pt-2 ">

                                    <x-user-checkbox></x-user-checkbox>
                                    <x-user-checkbox></x-user-checkbox>
                                    <x-user-checkbox></x-user-checkbox>
                                    <x-user-checkbox></x-user-checkbox>
                                    <x-user-checkbox></x-user-checkbox>
                                    <x-user-checkbox></x-user-checkbox>
                                    <x-user-checkbox></x-user-checkbox>
                                    <x-user-checkbox></x-user-checkbox>


                                </div>


                            </div>
                            <div>
                                {{--                                TODO something weird happens here--}}
                                <x-button type="button" x-data='open' id='button_select_confirm' @click="show= ! show"
                                          class=" text-2xl font-bold"><span class="text-xl">Confirm</span>
                                </x-button>

                            </div>


                        </div>


                    </div>
                    {{--END OF MODAL--}}
                    <script>
                        document.getElementById("button_select").addEventListener("click", function (event) {
                            event.preventDefault()
                        });
                        document.getElementById("button_select_confirm").addEventListener("click", function (event) {
                            event.preventDefault()
                        });

                    </script>


                    <div class="flex  items-center mt-10">
                        <x-button type="submit" class="  font-bold">
                            Confirm
                        </x-button>
                    </div>

                </div>


        </form>
    </div>
    </div>
    </div>
</x-app-layout>

