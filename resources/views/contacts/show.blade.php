<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Message Details') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-full sm:max-w-2xl lg:max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6">

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-2 sm:gap-0">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-200">
                        From: {{ $contact->name }}
                    </h3>
                    <span class="text-sm {{ $contact->is_read ? 'text-green-600' : 'text-red-600 font-semibold' }}">
                        {{ $contact->is_read ? 'Read' : 'Unread' }}
                    </span>
                </div>

                {{-- Contact Info --}}
                <div class="space-y-3 text-gray-800 dark:text-gray-200">
                    <p class="truncate"><strong>Email:</strong> {{ $contact->email }}</p>
                    <p class="truncate"><strong>Mobile:</strong> {{ $contact->mobile }}</p>
                    @if($contact->house)
                        <p><strong>House Inquired:</strong> 
                            <a href="{{ route('visitor.house_features', $contact->house->id) }}" 
                               class="text-blue-600 hover:underline break-words">
                                {{ $contact->house->title }}
                            </a>
                        </p>
                    @endif
                </div>

                <hr class="my-4 border-gray-300 dark:border-gray-700">

                {{-- Message --}}
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Message:</h4>
                    <p class="text-gray-800 dark:text-gray-200 whitespace-pre-line leading-relaxed break-words">
                        {{ $contact->message }}
                    </p>
                </div>

                {{-- Actions --}}
                <div class="mt-6 flex flex-col sm:flex-row sm:justify-between gap-3 sm:gap-0">
                    <a href="{{ route('contacts.index') }}" 
                       class="w-full sm:w-auto text-center bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                        ← Back to Messages
                    </a>

                    @if(!$contact->is_read)
                        <form action="{{ route('contacts.markRead', $contact->id) }}" method="POST" class="w-full sm:w-auto">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full sm:w-auto bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                                Mark as Read
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
