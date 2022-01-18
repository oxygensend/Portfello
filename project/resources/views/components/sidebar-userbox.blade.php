
<div class=" flex  bg-gray-800 h-32 items-center ">
    <x-sidebar-padding-box>
        <div  class="flex items-center " >
            <div  class=" w-16 h-16 bg-white box rounded-lg relative">
                @if(auth()->user()->invites()->where('displayed',False)->count())
            <div class="absolute bg-red-500 w-5 h-5 rounded-2xl text-center  flex items-center justify-center top-0 right-0"
                 style="top: -5px; right: -5px">{{ auth()->user()->invites()->where('displayed',False)->count() }}</div>
                @endif
            </div>
            <div class="flex flex-col ml-4   ">
                <p class="text">Tomasz Kurcaba</p>
                <a   href="{{ url('edit-user') }}" class="text-xs	">View profile</a>
            </div>

        </div>

        </x-sidebar-padding-box>



</div>
