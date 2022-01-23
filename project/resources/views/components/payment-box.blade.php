@props(['payment' ,'group','group_show'])
@php
$payment_author= \App\Models\User::find($payment->user_1_id);
$payment_receiver=\App\Models\User::find($payment->user_2_id);
$amount=$payment->amount;
$item=$payment->item ?? null;



    $middle_text="";
$author_text=$payment_author->name;
$receiver_text=$payment_author->name;

    if(Auth::user()->name == $payment_author->name){

      $author_text="You";

    }elseif( Auth::user()->name == $payment_author->name)

    {

        $receiver_text="You";

    }



    if($item == null)
{
  $value_text= $amount;


}else{
        $value_text= $amount . " " . $item;
}








@endphp


<div class="flex justify-start flex-col  border-gray-200 py-2 px-4 rounded-xl">

        <div class=" mb-2"> <span class="font-semibold" >{{$author_text}} created  payment</span><a x-show="{{$groupShow}}"> in {{ $payment->group->name }}</a></div>



    <div {{ $attributes->merge(['class' => 'flex flex-row space-x-8 items-center bg-amount_color opacity-90 py-3 px-4 rounded-md text-white' ] ) }} >

        <div class="flex flex-col ">
            <h2>{{ getPaymentDay($payment)}}</h2>
            <h3>{{ getPaymentMonth($payment)}}</h3>
        </div>

        <x-image properties="w-16 h-16 box relative"  src="{{ auth()->user()->avatar }}" />
        @if( !empty($group))
            <div class="flex flex-col ">
                <h2 class="">In group</h2>
                <h3 class="font-bold">{{$group->name}}</h3>
            </div>
        @endif


        <div class="grow">
            <div class="flex justify-start space-x-6 ">

                <div class="flex flex-col w-64 ">
                    <h2 class="text-xl truncate">{{Str::limit ($author_text . " paid " .$receiver_text . " ".$value_text ,50 )}}</h2>
                </div>

            </div>
        </div>
    </div>
</div>
