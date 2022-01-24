<x-app-layout>
    <x-slot name="header">
        Create group
    </x-slot>
<div class="flex justify-center items-center w-full h-full">
<div class="border border-gray-200  rounded-xl h-max	pt-6 pb-16 px-6  w-full  sm:w-8/12 md:w-5/12 min-w-[350px]">
    <form method="POST" action="{{ route('groups.store') }}" enctype="multipart/form-data" class="w-full h-full flex flex-col justify-between">
        @csrf

        <div>
            <x-label for="name" :value="__('Name')" />

            <x-input id="name" class="block mt-1 w-full"
                            type="text"
                            name="name"
                            :value="old('name')" required autofocus />
        </div>

        <x-error name="name"/>


            <x-label  class="mt-4" for="avatar" :value="__('Avatar')" />
            <div class="mt-4 flex items-center ">
            <x-image id="preview_avatar" src="/images/default_group.png" properties="w-32 h-32 box relative" />
            <x-input id="avatar" class="ml-4 p-2 h-10  border border-gray-400 rounded  bg-white"
                            type="file"
                            name="avatar"
                            />
            </div>

        <x-error name="avatar"/>




        <div class="mt-4 ">
           <x-button class="mt-4 h-full text-center">
                Create
           </x-button>
        </div>
    </form>

</div>
</div>
     <script type="text/javascript">
    $('#avatar').change(function(){

    let reader = new FileReader();
    reader.onload = (e) => {
      $('#preview_avatar').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);

   });
  </script>
</x-app-layout>
