
@props(['name', 'avatar', 'imgsize'=>'w-40 h-40' , 'vertical'])

<div class="flex justify-center items-center space-x-10 {{ isset($vertical) ? "flex-col $vertical":'' }}">
    <x-image src="{{ $avatar ?? '' }}" properties="{{$imgsize}} rounded-xl overflow-hidden" />
    <div  class="columns-1">
        <a  class="text-xl font-bold " {{ $attributes }}>{{ $name ?? '' }}</a>
        {{-- <p class="text-amount_color font-semibold">Your are owed 400</p> --}}
        {{-- <p>Kuba owes you </p> --}}
    </div>
</div>
