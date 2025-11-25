<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact Messages') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            @if($messages->count())
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">

                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            Messages Received
                        </h3>

                        {{-- Responsive Table Wrapper --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300 border-collapse border">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr class="hidden sm:table-row">
                                        <th class="px-4 py-2 font-semibold text-gray-600 dark:text-gray-200">Name</th>
                                        <th class="px-4 py-2 font-semibold text-gray-600 dark:text-gray-200">Email</th>
                                        <th class="px-4 py-2 font-semibold text-gray-600 dark:text-gray-200">Mobile</th>
                                        <th class="px-4 py-2 font-semibold text-gray-600 dark:text-gray-200">Message</th>
                                        <th class="px-4 py-2 font-semibold text-gray-600 dark:text-gray-200">Date</th>
                                        <th class="px-4 py-2 font-semibold text-gray-600 dark:text-gray-200">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="space-y-2 sm:space-y-0">
                                    @foreach($messages as $contact)
                                        {{-- Card for mobile --}}
                                        <tr class="block sm:table-row {{ $contact->is_read ? 'bg-white dark:bg-gray-800' : 'bg-blue-50 dark:bg-blue-900/40' }} hover:bg-gray-100 dark:hover:bg-gray-700 transition mb-2 sm:mb-0 rounded sm:rounded-none">
                                            <td colspan="6" class="block sm:table-cell p-0">
                                                <a href="{{ route('contacts.show', $contact->id) }}" class="block px-4 py-3 text-gray-800 dark:text-gray-200 no-underline">
                                                    <div class="grid grid-cols-1 sm:grid-cols-6 gap-2 sm:gap-4 items-center">
                                                        <span class="font-medium">{{ $contact->name }}</span>
                                                        <span class="truncate">{{ $contact->email }}</span>
                                                        <span class="truncate">{{ $contact->mobile }}</span>
                                                        <span title="{{ $contact->message }}" class="block text-gray-700 dark:text-gray-300 truncate sm:max-w-[200px]">
                                                            {{ Str::limit($contact->message, 30) }}
                                                        </span>
                                                        <span>{{ $contact->created_at->format('Y-m-d') }}</span>
                                                        <span>
                                                            @if($contact->is_read)
                                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">Read</span>
                                                            @else
                                                                <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded">Unread</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4 sm:mt-6">
                            {{ $messages->links() }}
                        </div>

                    </div>
                </div>

            @else
                <div class="text-center bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-600 dark:text-gray-300 text-lg">No contact messages found.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
