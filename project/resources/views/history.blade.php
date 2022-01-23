<x-app-layout>
    <x-slot name="header">
        Your history
    </x-slot>
    <div x-data>

        <div class="flex flex-col space-y-10 items-center h-full w-full ">

            <div class="w-full h-full ">
                <div class="items-center justify-center overflow-auto  h-full w-full flex">
                    <div class="flex flex-col space-y-8 columns-1 ">


                        @forelse ($expenses_payments as $merged_object)


                            @if($merged_object instanceof \App\Models\Payment)

                                <x-payment-box :payment="$merged_object" group_show='true'></x-payment-box>

                            @else

                                <x-expense-box  class="flex-1 w-7/8 object-right text-2x" group_show='true' :expense="$merged_object"
                                                @click="window.location.href='{{route('groups.expenses.show', ['group'=>$merged_object->group ,'expense'=>$merged_object] ) }}'"></x-expense-box>
                            @endif

                        @empty
                            <h2 class="text-xl font-semibold"> No expenses or payments been created yet</h2>
                        @endforelse


                    </div>
                </div>


            </div>
        </div>
    </div>

</x-app-layout>
