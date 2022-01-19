<x-app-layout >

        <style>
            .td-text-red {color: red;}
        </style>

        <style>
            .td-text-blue {color: blue;}
        </style>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="flex justify-center items-center w-full h-full text-2xl font-mono"> Your expenses with users in the group {{ $group->name }}</div>
       <br>
        <div class="bg-white v  overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6  bg-white border-b border-gray-200">

                @if($result ->isEmpty())
                    <p class="p-6">You don't have any expenses in this group.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Who?
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount/Item
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Details
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                        @foreach($result as $p)
                            <tr class="
                            @if($p->amount < 0)
                            {{ 'text-red-600' }}
                            {{ $temp=-1 }}
                            @else
                            {{ 'text-blue-600' }}
                            {{ $temp=1 }}
                            @endif
                                ">
                                <td class="px-6 py-4 whitespace-nowrap ">
                                    <div >{{ $p->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        @if(!empty($p->item))
                                       <div class="text-pink" >{{$p->item.':'. $temp*$p->amount}}</div>
                                        @else
                                            <div >{{ $p->amount}} $</div>
                                        @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <div >{{ $p->description }}</div>
                                </td>
                             </tr>
                        @endforeach

                        </tbody>
                    </table>

                @endif
            </div>
        </div>
        <div class=" pb-2 flex justify-end mt-4">
            <form method="get" action="{{ route('groups.expenses.create', $group) }}">
                <x-button class="ml-4">
                    {{ __('Add a new expense') }}
                </x-button>
            </form>
        </div>
    </div>
</x-app-layout>
