<x-app-layout >

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center items-center w-full h-full"> Your expenses with users in the group {{ $group->name }}</div>
        <div class="bg-white v  overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6  bg-white border-b border-gray-200">

                @if($expenses->isEmpty())
                    <p class="p-6">You don't have any expenses in this group.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Komu wisisz?
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount or item
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Details</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($expenses as $expense)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $expense->isbn }}</div>
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
