@props(['action', 'name','method'])
<form method="POST" action={{$action}}>
    @csrf
    @method($method ?? '')
    <x-button {{$attributes}}>{{$name}}</x-button>
</form>

