<x-app-layout>

    <x-slot name="header">
        <a href="{{ route('groups.show', $group) }}">{{$group->name}}</a>
    </x-slot>

    <div class="flex justify-center items-center w-full h-full">
        <div x-data="show()"
             class="border border-gray-200  rounded-xl h-max	pt-6 pb-16 px-6  w-full  sm:w-8/12 md:w-5/12 min-w-[350px]">

            <form method="post" action="{{ route('groups.expenses.store', $group) }}">
                @csrf
                <div class="flex flex-col   ">

                    <div>
                        <x-label for="description" :value="__('Description')"/>
                        <x-input id="description" class="block mt-1 w-full"
                                 type="text"
                                 name="description"
                                 :value="old('description')" autofocus/>

                        <x-error name="description"/>
                    </div>

                    <div>
                        <x-label for="option" :value="__('How')"/>
                        <select id="how" name="how"
                                @change='event.target.value == "item" ? openItem: closeItem'>
                            <option name="money" value="money">Money</option>
                            <option name="item" value="item">Item</option>
                        </select>

                    </div>

                    <x-show-item group={{ $group }} />


                    <div class="flex  items-center mt-10">
                        <x-button type="button" id='button_select' x-on:click="toggleUsers"
                                  class=" font-medium font-bold">
                            Select users
                        </x-button>
                    </div>
                    <x-error name="selected_users"/>


                    {{--                    MODAL--}}
                    <div x-show="isOpenedUsers()"  class="fixed inset-0  w-screen h-screen flex justify-center items-center 	">

                        <div class="absolute inset-0 bg-neutral-300 opacity-70 "></div>
                        <div x-on:click.away="toggleUsers"
                            class="w-4/12 rounded-lg h-5/6 bg-white z-50 flex flex-col items-center justify-between   p-10  space-y-6">

                            <div class="w-full min-h-0 text_and_checkboxes flex flex-col space-y-10 ">

                                <div class="text-2xl flex-none	font-semibold text-center">Select users</div>

                                <div
                                    class="w-full 	 flex-auto overflow-y-auto flex flex-col  justify-center items-center space-y-4 scroll-pt-2 ">

                                    <x-checkbox_wrapper>
                                        <x-label for="all" class="text-lg font-bold">All users</x-label>

                                        <x-input  id="all" class="block ml-4"
                                                  type="checkbox"
                                                  name="all"
                                                  checked />

                                    </x-checkbox_wrapper>


                                    @foreach($group->users as $user)
                                        <x-checkbox_wrapper>
                                            <x-user-checkbox  :user="$user" class="user_checkbox"></x-user-checkbox>
                                        </x-checkbox_wrapper>

                                        @endforeach

                                </div>


                            </div>
                            <div>
                                {{--                                TODO something weird happens here--}}
                                <x-button type="button" id='button_select_confirm' @click="toggleUsers"
                                          class=" text-2xl font-bold"><span class="text-xl">Confirm</span>
                                </x-button>

                            </div>


                        </div>


                    </div>
                    {{--END OF MODAL--}}
                    <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                            all_checkbox= document.getElementById("all");
                            console.log(all_checkbox);

                            document.getElementById("button_select").addEventListener("click", function (event) {
                                event.preventDefault()
                            });
                            document.getElementById("button_select_confirm").addEventListener("click", function (event) {
                                event.preventDefault()
                            });
                            {{--//TODO security--}}
                                n_of_checkboxes={!! json_encode(sizeof( $group->users)) !!};




                            n_of_checked=n_of_checkboxes;
                         var all_checked=true;



                            var user_checkboxes=document.getElementsByClassName("user_checkbox");

                            all_checkbox.checked=all_checked;

                            all_checkbox.addEventListener("click", function (event) {
                                all_checked=! all_checked;

                                for (const checkbox of user_checkboxes) {
                                    checkbox.checked= all_checked;
                                }
                                if(all_checked)  n_of_checked=n_of_checkboxes;
                                else n_of_checked=0;

                            });

                            for (const checkbox of user_checkboxes) {
                                checkbox.addEventListener('click',function (event){
                                    if(checkbox.checked){
                                        if(n_of_checked<n_of_checkboxes)n_of_checked+=1;

                                    }else{
                                        if(n_of_checked>0) n_of_checked-=1;
                                    }
                                    // console.log(n_of_checkboxes);
                                    // console.log(n_of_checked);
                                    console.log(n_of_checked);
                                    all_checked=(n_of_checked== n_of_checkboxes);
                                    all_checkbox.checked=all_checked;
                                });
                            }



                        })



                        function show() {
                            return {
                                show_users:false,
                                show_item: false,
                                toggleUsers(){this.show_users = !this.show_users},
                                isOpenedUsers(){return this.show_users ===true},
                                openItem() { this.show_item = true },
                                closeItem() { this.show_item= false },
                                isOpenItem() { return this.show_item === true },
                            }
                        }






                    </script>


                    <div id="user_confirm" class="flex  items-center mt-10">
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

