<x-app-layout>
    <x-slot name="header">
        Paying for <a :href="route('groups.expenses.show',$group )"> {{ $expense->title }}</a>
    </x-slot>

    <div class="flex justify-center items-center w-full h-full">
        <div
            class="border border-gray-200  bg-white rounded-xl h-max	pt-6 pb-16 px-6  w-full  sm:w-8/12 md:w-5/12 min-w-[350px]">
            <div class="flex  mt-3 justify-center text-xl">

                <span> Payment to user</span>
                <x-image properties="md:w-10 md:h-10  h-6 w-6 box relative left-2 bottom-2 mr-3" src="{{ auth()->user()->avatar }}"/>
                <span><strong>{{ $expense->user->name }} </strong> for <strong> {{ $expense->title }}</strong></span>
            </div>
            <form method="post" action="{{ route('groups.expenses.pay.store',[$group, $expense ])}}">
                @csrf
                <div class="flex flex-col   ">
                    <div>
                    @if(!$expense->item)
                        <x-label for="amount" :value="__('Amount of money')"/>

                        <x-input id="amount" class="block mt-1 w-full"
                                 type="number"
                                 name="amount"
                                 step="0.01"
                                 min="0.01"
                                 max="{{auth()->user()->contributonInExpense($expense)}}"
                                 :value="old('amount')" autofocus required/>
                    </div>
                    <x-error name="amount" />
                    @else
                        <div class="mt-5 ">
                        <span > Do you want to give back <strong>{{ auth()->user()->owes($expense) }}</strong>?</span>
                        </div>
                    @endif
                    <div class="flex  items-center mt-8">
                        <x-button type="button" x-data='open' id='button_select_confirm' @click="show= ! show"
                        >Give back
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
