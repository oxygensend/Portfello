<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('groups.show', $group) }}">{{$group->name}}</a>
    </x-slot>
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
                >
                </x-group-box>


                <div class="grow  w-full">
                    <div class="items-center justify-center overflow-auto  h-full w-full flex ">
                        <div class="flex flex-col space-y-6">


                            @forelse ($expenses_history as $expense_history)
                                @php
                                  # ddd($expense_history);
                                @endphp
                                <x-expense-box :expense="$expense_history"
                                               @click="window.location.href='{{route('groups.expenses.show', ['group'=>$group ,'expense'=>$expense_history] ) }}'"></x-expense-box>
                            @empty
                                <h2 class="text-xl font-semibold"> No expenses have been created yet</h2>
                            @endforelse


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
</x-app-layout>
