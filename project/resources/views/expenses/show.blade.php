
<x-app-layout>

    <x-slot name="header">
 {{"Viewing Expense"}}
    </x-slot>
    <div class="w-full h-full flex justify-center  pb-10 ">

        <div class="border border-gray-200 h-fit rounded-xl 	pt-6 pb-16 px-6  w-full  sm:w-8/12 md:w-5/12 min-w-[350px] mt-10 bg-white">
            <div class="flex flex-col  items-center h-full w-full ">
                @if(Auth::user()==$expense->user )
                <div class="flex justify-end w-full items-end space-x-2">

                    <x-action-button name="Delete"
                                     action="{{  route('groups.expenses.destroy', ['group'=>$group, 'expense'=>$expense]) }}"
                                     method='DELETE'
                    />

                    <x-button class="text-center">
                        <a href={{  route('groups.expenses.edit', ['group'=>$group, 'expense'=>$expense]) }}>Edit</a>
                    </x-button>


                </div>
                @endif
                <div class="flex flex-col space-y-6 mt-16 items-center h-full w-full ">

                <div class="text-4xl font-semibold">{{$expense->description}}
                </div>

                <div class="text-3xl font-semibold"> {{$expense->getAmountString()}}
                </div>
                    <div>
                    Created by <span class="font-semibold     text-lg"


                >{{$expense->user->name}}</span>
                </div>
                <div >Added on {{$expense->getDate()}}</div>

                <div> In group {{$expense->group->name}}</div>


<div>
                <div class="w-fit mt-8 flex flex-col  justify-center items-end space-y-4 ">


                    @foreach($expense->users() as $user)

<x-user-list-box :user="$user" ></x-user-list-box>


                    @endforeach
                </div>
</div>


            </div>

        </div>
        </div>





        </div>



</x-app-layout>
