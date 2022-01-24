
@props(['group', 'avatar', 'imgsize'=>'w-40 h-40' , 'vertical' ,'balance'=>true])
@php
$user_balance=  Auth::user()->getGroupBalance( $group);
@endphp
<div class="flex justify-center items-center  {{ isset($vertical) ? "flex-col $vertical items-center justify-center ":'space-x-10' }}">
    <x-image src="{{ $avatar ?? '' }}" properties="{{$imgsize}} rounded-xl overflow-hidden" />

    <div  class="columns-1 flex flex-col space-y-4 {{ isset($vertical) ? " items-center":'' }} ">
        <a  class="text-2xl font-bold " {{ $attributes }}>{{ $group->name ?? '' }}</a>

        <p x-show={{$balance}} class="text-xl">Your balance:  {{$user_balance . ' $'}} </p>

        @if($balance && $user_balance!=0 && isset($vertical) )
        <x-button class="text-center">
            <a href={{  route('groups.pay.create', ['group'=>$group]) }}>Settle up</a>
        </x-button>
@endif
    </div>
</div>
