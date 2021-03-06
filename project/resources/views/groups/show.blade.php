<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('groups.show', $group) }}">{{$group->name}}</a>
    </x-slot>
    <script>

        function toggleList( id){

            var list = document.getElementById(`user_list${id}`);

            if (list.style.display == "none"){
                list.style.display = "block";
            }else{
                list.style.display = "none";
            }


        }

    </script>

    <div class="w-full h-full ">

        <div x-data class="absolute  top-16 md:top-28 right-8 md:right-16 "
             @click="window.location.href='{{route('groups.edit', ['group'=>$group ]) }}'">
            <img class="w-10 h-10"
                 src="{{asset("/images/settings_icon.svg")}}"
                 alt=""
                 @click="window.location.href='{{route('groups.edit', ['group'=>$group ]) }}'">
        </div>


        <div x-data>

            <div class="flex flex-col space-y-10 items-center h-full w-full ">

                <x-group-box imgsize=' w-72 h-72 md:w-72 md:h-72'
                             name="{{$group->name}}"
                             avatar="{{asset($group->avatar)}}"
                             href="{{route('groups.show', $group)}}"
                             vertical='space-y-10'
                             :group="$group"
                             balance="true"
                             group_show="false"
                >
                </x-group-box>
                @php

                    @endphp

<div class="balance_box flex flex-col justify-start space-y-4">
@forelse($group->users as $user)

    @php
        $balance_money=  auth()->user()->getBalanceWithUser($user, $group);
$balance_items=auth()->user()->getItemBalanceWithUser($user, $group);

        @endphp

    @if($balance_money==0 && sizeof($balance_items) == 0)
        @else


                                    <div class=" text-xl"><div class=" border-indigo-500 border-b-2"> <h2 onclick="toggleList({{$user->id}})" >Balance with user: {{$user->name}} </h2>
                            </div>
                            <ul class="mt-2 text-lg" id="user_list{{$user->id}}" style="display:none;">

                        @if($balance_money !=0 )

                            <li>You {{ ($balance_money >0 ? "are owed " :'owe ').  abs($balance_money ) .' $'}}  </li>
                            @endif


                                @foreach( $balance_items as $item =>$amount)
                                @if($amount != 0)
                                    <li>You {{ ($amount >0 ? "are owed " :'owe ') . abs($amount). " " .$item   }}  </li>
                                @endif
                                @endforeach


                            </ul>
                        </div>


        @endif


                @empty

                @endforelse
</div>


                <div class="grow  w-full">
                    <div class="items-center justify-center overflow-auto h-full w-full flex ">
                        <div class="flex flex-col space-y-6">


                            @forelse ($expenses_payments as $merged_object)


                                @if($merged_object instanceof \App\Models\Payment)

                                    <x-payment-box :payment="$merged_object"></x-payment-box>

@else


                                <x-expense-box id="{{ 'expense' . $merged_object->expense_id}}" group_show="false" :expense="$merged_object"
                                               @click="window.location.href='{{route('groups.expenses.show', ['group'=>$group ,'expense'=>$merged_object] ) }}'"></x-expense-box>
                                @endif

                            @empty
                                <h2 class="text-xl font-semibold"> No expenses or payments been created yet</h2>
                            @endforelse





{{--                            @forelse ($expenses_history as $expense_history)--}}


{{--                                <x-expense-box id="{{ 'expense' . $expense_history->expense_id}}" group_show="false" :expense="$expense_history"--}}
{{--                                               @click="window.location.href='{{route('groups.expenses.show', ['group'=>$group ,'expense'=>$expense_history] ) }}'"></x-expense-box>--}}
{{--                            @empty--}}
{{--                                <h2 class="text-xl font-semibold"> No expenses have been created yet</h2>--}}
{{--                            @endforelse--}}


                        </div>
                    </div>


                </div>

                <x-floating-button>
                    <x-slot name="button" class="opacity-80 sm:opacity-100"></x-slot>
                    <x-slot name="link" class="font-bold" href="{{ route('groups.expenses.create', $group)}}"> Add
                        expense
                    </x-slot>


                </x-floating-button>

            </div>
        </div>
    </div>



</x-app-layout>
