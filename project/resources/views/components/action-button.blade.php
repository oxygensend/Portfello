@props(['action', 'name','method'])
<form method="POST" id="form-post" action={{$action}}>
    @csrf
    @method($method ?? '')
    <x-button  {{$attributes}}>{{$name}}</x-button>
</form>


