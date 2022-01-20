@props(['name'])
@error($name)
    <p class="text-red-500 text-xs mt-1 mr-2 ml-2"> {{ $message }}</p>
@enderror
