@props(['group'])
<div x-show="show" @click.away="show=false" class="right-8 px-2 py-4  absolute  bottom-10 mb-16 md:right-16   rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                  aria-orientation="vertical"  style="display:none">
    <div class="py-1" >

        <form method="POST" action="{{ route('groups.add-user.store', $group) }}">
             @csrf
            <div>
                <x-label for="username" :value="__('Insert username')" />
                <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" autofocus required/>
            </div>
                <x-error name="username"/>
            <div class="flex justify-center items-center mt-10">
                <x-button id="add" class="  font-medium font-bold" >
                Add
                </x-button>
            </div>
        </form>
</div>
</div>
