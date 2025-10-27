<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact Messages') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($messages->count())
                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            Messages Received
                        </h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-200">Name</th>
                                        <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-200">Email</th>
                                        <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-200">Mobile</th>
                                        <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-200">Message</th>
                                        <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-200">Date</th>
                                        <th class="px-4 py-3 font-semibold text-gray-600 dark:text-gray-200">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $contact)
                                    <tr 
                                        class="{{ $contact->is_read ? 'bg-white dark:bg-gray-800' : 'bg-blue-50 dark:bg-blue-900/40' }}
                                            hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                                    >
                                        <td colspan="6" class="p-0">
                                            <a href="{{ route('contacts.show', $contact->id) }}" 
                                            class="block px-4 py-3 text-gray-800 dark:text-gray-200 no-underline">
                                                <div class="grid grid-cols-6 gap-2">
                                                    <span>{{ $contact->name }}</span>
                                                    <span>{{ $contact->email }}</span>
                                                    <span>{{ $contact->mobile }}</span>
                                                    <span 
                                                        title="{{ $contact->message }}" 
                                                        class="block text-gray-700 dark:text-gray-300 truncate max-w-[200px]"
                                                    >
                                                        {{ Str::limit($contact->message, 20) }}
                                                    </span>

                                                    <span>{{ $contact->created_at->format('Y-m-d') }}</span>
                                                    <span>
                                                        @if($contact->is_read)
                                                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">
                                                                Read
                                                            </span>
                                                        @else
                                                            <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded">
                                                                Unread
                                                            </span>
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

                        <div class="mt-6">
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
