@props(['user', 'id'=>0, 'type'=>'checkbox', 'name'=>"selected_users[]"])
    <x-label for="{{$user->name . $id}}" class="text-lg">{{$user->name}}</x-label>

    <x-input  {{ $attributes->merge(['class' => 'block ml-4']) }} id="{{$user->name . $id}}"
              type="{{ $type }}"
              value="{{$user->id}}"
              name="{{$name}}"
              checked />

