
<div class=" flex  bg-gray-800 h-32 items-center ">
    <x-sidebar-padding-box>
        <div  class="flex items-center " >
            <div  class=" w-16 h-16 bg-white box rounded-lg relative">
                @if(auth()->user()->invites()->where('displayed',False)->count())
            <div id="lovejs" class="absolute  bg-red-500 w-5 h-5 rounded-2xl text-center  flex items-center justify-center top-0 right-0"
                 style="top: -5px; right: -5px"><p>{{ auth()->user()->invites()->where('displayed',False)->count() }}</p></div>
                @endif

            </div>
            <div class="flex flex-col ml-4   ">
                <p class="text">Tomasz Kurcaba</p>
                <a   href="{{ url('edit-user') }}" class="text-xs	">View profile</a>
            </div>

        </div>

        </x-sidebar-padding-box>

    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

    <script>
        var channel = pusher.subscribe('invites-sent');
        channel.bind('invites-status', function(data) {

            var invites_n = data['invites_n'];
            if(invites_n){

                $('#lovejs').text(invites_n);

            }
        });
    </script>

</div>
