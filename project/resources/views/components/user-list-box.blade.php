@props(['user','expense'])
<div class="flex w-max items-end items-center space-x-10">
{{-- <x-image></x-image> {{$user->name}}  pays {{$user->getUserContribution($expense)}}--}}
    <x-image properties='w-12 rounded-lg overflow-hidden' src="{{ auth()->user()->avatar }}" ></x-image>
    <div> {{$user->name}}  owes 10</div>
</div>
