
<div class=" flex  bg-gray-800 h-32 items-center ">
    <x-sidebar-padding-box>
        <div  class="flex items-center " >
            <x-image properties="w-16 h-16 box relative"  src="{{ auth()->user()->avatar }}" >
                    <div id="lovejs" class="absolute  bg-red-500 w-5 h-5 rounded-xl text-center  flex items-center justify-center top-0 right-0"
                                     style="top: -5px; right: -5px;">
                        <p>{{ auth()->user()->invites()->where('displayed',False)->count() }}</p>
                    </div>
{{--                @endif--}}
            </x-image>

            <div class="flex flex-col ml-4   ">
                <p class="text">{{ auth()->user()->name }}</p>
                <a   href="{{ url('edit-user') }}" class="text-xs	">View profile</a>
            </div>

        </div>

        </x-sidebar-padding-box>



    <script>
        @if(!auth()->user()->invites()->where('displayed',False)->count())
        $('#lovejs').hide();
        @endif
        var channel = pusher.subscribe('invites-sent');
        channel.bind('invites-status', function(data) {
            var invites_n = data['invites_n'];
            var user = data['user_id'];
            if(invites_n && user === {{auth()->user()->id}}){

                $('#lovejs').show();
                $('#lovejs').text(invites_n);

            }
        });
    </script>

</div>
