@props(['user', 'type'=>'checkbox', 'name'=>"selected_users[]"])
    <x-label for="{{$user->name .$user->id}}" class="text-lg">{{$user->name}}</x-label>

    <x-input  {{ $attributes->merge(['class' => 'block ml-4']) }} id="{{'user' . $user->id}}"
              type="checkbox"
              value="{{$user->id}}"
              name="{{$name}}"
              checked />

