@props(['user','expense'])
<div class="flex w-full justify-start items-center space-x-10">
{{-- <x-image></x-image> {{$user->name}}  pays {{$user->getUserContribution($expense)}}--}}
    <x-image properties='w-12 h-12 rounded-lg overflow-hidden' src="{{ $user->avatar }}" ></x-image>
    <div> {{$user->name}}  owes {{round($user->user_contribution,2)}} </div>
</div>
