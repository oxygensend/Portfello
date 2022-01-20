@props(['user', 'id'=>0])
    <x-label for="{{$user->name . $id}}" class="text-lg">{{$user->name}}</x-label>

    <x-input  {{ $attributes->merge(['class' => 'block ml-4']) }} id="{{$user->name . $id}}"
              type="checkbox"
              value="{{$user->id}}"
              name="selected_users[]"
              checked />

