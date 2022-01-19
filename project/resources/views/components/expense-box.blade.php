@props(['expense' , 'href'=>''])

<div  {{ $attributes->merge(['class' => 'flex flex-row space-x-8 items-center bg-sidebar_main_color opacity-90 py-3 px-4 rounded-md text-white' ] ) }} >

    <div class="flex flex-col ">
        <h2>{{$expense->getMonth()}}</h2>
        <h3>{{$expense->getDay()}}</h3>
    </div>

    <div class="w-16 h-16 bg-white rounded-lg">        <img class="rounded-lg" src="{{url('/images/wallet2.png') }}"></div>

{{--    <div class="flex flex-col ">--}}
{{--        <h2 class="">In group</h2>--}}
{{--        <h3 class="font-bold">Nazwa grupy</h3>--}}
{{--    </div>--}}

@php
  #if($expense->creator() == Auth::user() )
if($expense->user ==Auth::user()){
        $right_uppertext="You paid ";
        $right_lowertext=$expense->amount;
        $centertext="You paid ";

        if(!is_null($expense->item )){
      $right_uppertext="You lent ";
       $right_lowertext=$expense->amount ." ". $expense->item ;
      $centertext="You bought ";
        }

    }else{
        if(Auth::user()->isIncluded($expense)  ){

            $right_uppertext="You borrowed ";
            $centertext= $expense->user->name;


            if( is_null($expense->item )){
                $right_lowertext=$expense->amount; #TODO - jak rozdzielac na osoby - expense->getUserPart()
                         $centertext.=" paid " . $expense->amount;
            }
            else
                {
                    $right_lowertext= $expense->amount ." ". $expense->item ;
                        $centertext.=" bought " . $expense->amount ." ". $expense->item ;
                }
            }
        else{
        $centertext= "You are not included";
        $right_uppertext="You are not included";

        }
        }



@endphp

    <div class="flex flex-col ">
        <h2 class="text-xl">{{Str::limit ($expense->description,40 )}}</h2>
        <h3 class="text-lg ">{{ Str::limit($centertext,40)  }}</h3>
    </div>

    <div class="flex flex-col ">
        <h3> {{$right_uppertext}}</h3>
        @if( isset($right_lowertext) )
            <h3 class=" font-bold">{{Str::limit($right_lowertext,40)  }}</h3>
            @endif
    </div>
</div>
