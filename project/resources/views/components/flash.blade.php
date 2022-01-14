@if (session()->has('success'))
        <div class="fixed bg-gray-800 text-white py-2 px-4 rounded-xl bottom-10 right-8"
             x-data="{show: true}"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show">
            <p>{{session('success')}}</p>
        </div>
@elseif (session() -> has('fail'))
    <div class="fixed bg-red-500 text-white py-2 px-4 rounded-xl bottom-10 right-8"
         x-data="{show: true}"
         x-init="setTimeout(() => show = false, 4000)"
         x-show="show">
        <p>{{session('fail')}}</p>
    </div>
@endif
