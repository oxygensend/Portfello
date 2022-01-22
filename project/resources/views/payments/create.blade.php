<x-app-layout>
    <x-slot name="header">
        Payments in <a :href="route('groups.show',$group )"> {{ $group->name }}</a>
    </x-slot>

    <div class="flex justify-center items-center w-full h-full">
        <div
            class="border border-gray-200  bg-white rounded-xl h-max	pt-6 pb-16 px-6  w-full  sm:w-8/12 md:w-5/12 min-w-[350px]">
            <div class="flex  mt-3 justify-center text-xl">

                <span>Payments</span>
            </div>
            <div x-data="{show:false}">
                <form method="post" action="{{ route('groups.pay.store',$group )}}">
                    @csrf
                    <div x-data="{show_item:false}" class="flex flex-col   ">
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

                        <x-select-users-panel name="selected_user" type="radio" :users="auth()->user()->whomOwe($group)"/>

                        <div class="flex  items-center mt-8">
                            <x-button type="button"
                            >transfer
                            </x-button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("button_select").addEventListener("click", function (event) {
            event.preventDefault()
        });
        document.getElementById("button_select_confirm").addEventListener("click", function (event) {
            event.preventDefault()
        });
    </script>
</x-app-layout>
