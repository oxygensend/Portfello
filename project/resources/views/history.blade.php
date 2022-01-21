<x-app-layout>
    <x-slot name="header">
        Your history
    </x-slot>
    <div x-data>

        <div class="flex flex-col space-y-10 items-center h-full w-full ">

            <div class="w-full h-full ">
                <div class="items-center justify-center overflow-auto  h-full w-full flex">
                    <div class="flex flex-col space-y-8 columns-1">

                        @forelse ($expenses_history as $expense_history)


                           <div class="flex" >
                               <x-group-box class="flex-1 space-y-3 mt-4 object-left" imgsize='w-12 h-12 md:w-7 md:h-7'
                                            name="{{$expense_history->group->name}}"
                                            avatar="{{asset($expense_history->group->avatar)}}"
                                            href="{{route('groups.show', $expense_history->group)}}"
                                            vertical='space-y-4'
                                            :group=" $expense_history->group"
                                            :balance="false"
                               >
                               </x-group-box>
                            <x-expense-box  class="flex-1 w-7/8 object-right " :expense="$expense_history"
                                           @click="window.location.href='{{route('groups.expenses.show', ['group'=>$expense_history->group ,'expense'=>$expense_history] ) }}'"></x-expense-box>
                           </div>
                        @empty
                            <h2 class="text-xl font-semibold"> No expenses have been created yet</h2>
                        @endforelse


                    </div>
                </div>


            </div>
        </div>
    </div>

</x-app-layout>
