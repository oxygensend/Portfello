@props(['properties'])
<div class="{{$properties ?? 'w-44 h-64 rounded-lg overflow-hidden'}}">
    <img alt="" class="w-full h-full object-center object-cover rounded-lg" {{$attributes }}>

    {{ $slot }}

</div>
