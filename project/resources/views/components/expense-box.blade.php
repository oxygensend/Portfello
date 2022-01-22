@props(['expense' , 'href'=>'','group'])


<div class="flex justify-start flex-col  border-gray-200 py-2 px-4 rounded-xl">
    @if(Auth::user()->name ==$expense->user->name)
        <div class=" mb-2"> <span class="font-semibold" >You </span>{{$expense->getStringAction()  }} expense  <a x-show="{{$group_show}}"> in {{ $expense->group->name }}</a> </div>
    @else
        <div class=" mb-2"> <span class="font-semibold" >{{$expense->user->name}}</span> {{$expense->getStringAction()  }} expense <a x-show="{{$group_show}}"> in {{ $expense->group->name }}</a></div>
    @endif
<div {{ $attributes->merge(['class' => 'flex flex-row space-x-8 items-center bg-sidebar_main_color opacity-90 py-3 px-4 rounded-md text-white' ] ) }} >

    <div class="flex flex-col ">
        <h2>{{$expense->getMonth()}}</h2>
        <h3>{{$expense->getDay()}}</h3>
    </div>

    <x-image properties="w-16 h-16 box relative"  src="{{ auth()->user()->avatar }}" />
        @if( !empty($group))
        <div class="flex flex-col ">
            <h2 class="">In group</h2>
            <h3 class="font-bold">{{$group->name}}</h3>
        </div>
    @endif

    @php

        $isCreator= $expense->user ==Auth::user();


        if($isCreator)
            {$creator="You";

                $right_uppertext="You get back ";
                $right_lowertext= $expense->user->getBack($expense);


        }else{
         $creator=$expense->user->name;
            if( $expense->user ->isIncluded($expense)){
               $right_uppertext="You owe ";
               $right_lowertext= $expense->user->owes($expense);
        }
            else{
                $right_uppertext=null;
                   $right_lowertext= "Not included";

            }
        }

                 if(!is_null($expense->item )){
                   $centertext= " bought " .$expense->amount." ". $expense->item ;
                }else{

                           $centertext= " paid " .$expense->amount;
                }


           $centertext= $creator . $centertext;







    @endphp
    <div class="grow">
        <div class="flex justify-start space-x-6 ">

            <div class="flex flex-col w-64 ">
                <h2 class="text-xl truncate">{{Str::limit ($expense->title ,40 )}}</h2>
                <h3 class="text-lg ">{{ Str::limit($centertext,40)  }}</h3>
            </div>

            <div class="flex grow flex-col items-center justify-center ">
                @if(!empty($right_uppertext))
                <h3> {{$right_uppertext}}</h3>
                @endif
                @if( isset($right_lowertext) )
                    <h3 class=" font-bold">{{Str::limit($right_lowertext,40)  }}</h3>
                @endif

            </div>
        </div>
    </div>
</div>
</div>
