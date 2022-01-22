@props([ 'users'])
<div x-show="show"
        class="fixed inset-0  w-screen h-screen flex justify-center items-center 	">

    <div class="absolute inset-0 bg-neutral-300 opacity-70 "></div>
    <div
        class="w-4/12 rounded-lg h-5/6 bg-white z-50 flex flex-col items-center justify-between   p-10  space-y-6">

        <div class="w-full min-h-0 text_and_checkboxes flex flex-col space-y-10 ">

            <div class="text-2xl flex-none	font-semibold text-center">Select user</div>

            <div
                class="w-full 	 flex-auto overflow-y-auto flex flex-col  justify-center items-center space-y-4 scroll-pt-2 ">


                @foreach($users as $user)
                    <x-checkbox_wrapper>
                        <x-user-checkbox :id="$loop->index" :user="$user"
                                         {{$attributes}} class="user_checkbox"></x-user-checkbox>
                    </x-checkbox_wrapper>

                @endforeach

            </div>


        </div>
        <div>
            <x-button type="button" x-data='open' id='button_select_confirm'
                      @click="show= ! show"
                      class=" text-2xl font-bold"><span class="text-xl">Confirm</span>
            </x-button>

        </div>


    </div>


</div>



