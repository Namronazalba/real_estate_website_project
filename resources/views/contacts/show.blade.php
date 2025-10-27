<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Message Details') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        From: {{ $contact->name }}
                    </h3>
                    <span class="text-sm {{ $contact->is_read ? 'text-green-600' : 'text-red-600 font-semibold' }}">
                        {{ $contact->is_read ? 'Read' : 'Unread' }}
                    </span>
                </div>

                <div class="space-y-4">
                    <p><strong>Email:</strong> {{ $contact->email }}</p>
                    <p><strong>Mobile:</strong> {{ $contact->mobile }}</p>
                    @if($contact->house)
                        <p><strong>House Inquired:</strong> 
                            <a href="{{ route('visitor.house_features', $contact->house->id) }}" 
                               class="text-blue-600 hover:underline">
                                {{ $contact->house->title }}
                            </a>
                        </p>
                    @endif
                    <hr class="my-4 border-gray-300 dark:border-gray-700">

                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Message:</h4>
                        <p class="text-gray-800 dark:text-gray-200 whitespace-pre-line leading-relaxed">
                            {{ $contact->message }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 flex justify-between items-center">
                    <a href="{{ route('contacts.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                        ← Back to Messages
                    </a>

                    @if(!$contact->is_read)
                        <form action="{{ route('contacts.markRead', $contact->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                                Mark as Read
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
