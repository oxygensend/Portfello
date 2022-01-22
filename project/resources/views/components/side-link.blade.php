@props(['active'])

@php
$classes='block py-2.5 px-4 rounded transition duration-200 hover:text-white  hover:bg-amount_color ';
!($active ?? false) ?:$classes .='bg-sidebar_link_active_color';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

