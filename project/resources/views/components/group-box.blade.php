
@props(['name', 'avatar', 'imgsize'=>'w-40 h-32' , 'vertical'])

<div class="flex justify-center items-center space-x-10 {{ isset($vertical) ? "flex-col $vertical":'' }}">
    <div class=" {{ $imgsize}} rounded-md overflow-hidden " >

        <img src="{{ $avatar ?? ''}}" class="w-full h-full object-center object-cover"  >
    </div>

    <div  class="columns-1">
        <a  class="text-xl font-bold " {{ $attributes }}>{{ $name ?? '' }}</a>
        {{-- <p class="text-amount_color font-semibold">Your are owed 400</p> --}}
        {{-- <p>Kuba owes you </p> --}}
    </div>
</div>
