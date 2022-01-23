<x-app-layout>
    <x-slot name="header">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
        </script>

        Payments in <a :href="route('groups.show',$group )"> {{ $group->name }}</a>
    </x-slot>

    <div class="flex justify-center items-center w-full h-full">
        <div
            class="border border-gray-200  bg-white rounded-xl h-max	pt-6 pb-16 px-6  w-full  sm:w-8/12 md:w-5/12 min-w-[350px]">
            <div class="flex  mt-3 justify-center text-xl">

                <span>Payments</span>
            </div>
            <div x-data="{show:false}">
                <form method="post" action="{{ route('groups.pay.store',$group )}}">
                    @csrf
                    <div x-data="{show_item:false}" class="flex flex-col   ">


                        @php
                            $users= auth()->user()->whomOwe($group);


                        @endphp


                        @if(sizeof($users) !=0)

                            <div>
                                <x-label for="user" :value="__('With')"/>

                                <select id="user_select" name="user_select" required>
                                    @foreach($users as $user)

                                        <option name="{{$user->name}}" value="{{$user->id}}">{{$user->name}}</option>


                                    @endforeach


                                        @endif
                                </select>
                            </div>


                            <div id="how_select_box">
                                <x-label for="option" :value="__('How')"/>
                                <select id="how" name="how"
                                        @change='event.target.value == "item" ? show_item = true : show_item = false'>
                                    <option name="money" value="money">Money</option>
                                    <option name="item" value="item">Item</option>
                                </select>

                            </div>


                            <div id="item_select_box" class="hidden">
                                <x-label for="option" :value="__('Item')"/>
                                <select id="item_select" name="item_select" id="item_select"
                                        @change='event.target.value == "item" ? show_item = true : show_item = false'>

                                </select>

                            </div>
                            <div>
                                <x-label for="how_much" :value="__('How much')" />

                                <x-input id="how_much" class="block mt-1 w-full"
                                         type="number"
                                         name="how_much"
                                         :value=" empty($expense) ? old('how_much') : $expense->amount  " min="0"
                                         autofocus />
                            </div>
                            <x-error name="how_much"/>




                            <div class="flex  items-center mt-8">
                                <x-button type="button"
                                >Settle up
                                </x-button>
                            </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

        item_select = document.getElementById("item_select");

function reload_amount(){
    if (document.getElementById("item_select_box").style.display==="block") {
        var regex = /[+-]?\d+(\.\d+)?/g;
        value=parseFloat(item_select.options[item_select.selectedIndex].text.split(':')[1].match(regex));
        document.getElementById("how_much").value=value;

    }else{
        document.getElementById("how_much").value=0;


    }
}
// async function awaitItems(){
//     await getItemsList();
//     reload_amount()
//
// }

item_select.addEventListener('change',function(event){

    reload_amount();

});
        var current_checked;
        items = [];

        console.log(document.getElementById("item_select_box"));
        document.getElementById("item_select_box").style.display = 'none';
        var how_select = document.getElementById('how');

        user_select = document.getElementById("user_select");



        user_select.addEventListener('change', function (event) {

            selected_user_id = user_select.value;
            console.log(user_select.value);
            if (how_select.value == "item") {
                getItemsList(user_select.value);

            }else{
                document.getElementById("how_select_box").removeChild(info);

            }
            reload_amount();

        })

        how_select.addEventListener('change', function (event) {
            console.log(how_select.value);
            if (how_select.value == "item") {

                getItemsList(user_select.value);


            } else {
                document.getElementById("how_select_box").removeChild(info);

            }
            reload_amount();

        })


        item_select_innerhtml = "";
        var info=document.createElement('p');
        info.style.color='red';
        info.textContent=
            "You owe no items";

        function getItemsList(selected_user_id) {

            console.log("FUNKCJA");
            $.ajax({
                url: '/payment/' + {!! json_encode($group->id)!!} + '/' + selected_user_id,
                type: 'GET',
                dataType: "JSON",
                data: {},
                success: function (response) { // What to do if we succeed
                    console.log(response);


                    items = [];
                    item_select_innerhtml = "";
                    console.log(response);
                    if(Object.keys(response).length >0) {
                        for (var item in response) {
                            items.push({item: response[item]});

                            item_select_innerhtml += `<option name=${item} value=${item}>` + item + " : " + response[item] + "</option>";
                        }

                        console.log(item_select_innerhtml);
                        document.getElementById("item_select").innerHTML = item_select_innerhtml;
                        document.getElementById("item_select_box").style.display="block";

                        document.getElementById("how_select_box").removeChild(info);


                    }else{
                        document.getElementById("item_select_box").style.display="none";
                        document.getElementById("how_select_box").appendChild(info);

                    }


                },
                error: function (response) {

                }
            });
        }


    </script>
</x-app-layout>
