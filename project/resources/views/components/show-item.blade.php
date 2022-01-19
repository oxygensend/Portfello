@props(['group'])

    <div class="py-1" >

            <div x-show="show_item">
                <x-label for="item" :value="__('What kind of item ')" />

                <x-input id="item" class="block mt-1 w-full"
                         type="text"
                         name="item"
                         :value="old('item')" autofocus />
            </div>
            <x-error name="item"/>
            <div>
                <x-label for="how_much" :value="__('How much')" />

                <x-input id="how_much" class="block mt-1 w-full"
                         type="number"
                         name="how_much"
                         :value="old('how_much')" autofocus />
            </div>
            <x-error name="how_much"/>



</div>
