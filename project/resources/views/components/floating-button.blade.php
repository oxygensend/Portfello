@props([
'link',
'button'
])
<div {{   $attributes->merge(['class'=> 'absolute right-8 md:right-16 bottom-10']) }} >

    <x-button :attributes="$button->attributes">
        <a {{ $link->attributes->merge(['class' => ' text-xl w-full h-full inline-block text-center    font-medium text-white ']) }} >
            {{$link}}</a>

    </x-button>

</div>






