<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Contact') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="text-left text-sm font-light">
                        <tr class="border-b dark:border-neutral-500">
                            <th>Name:</th>
                            <td>{{ $contact->name }}</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                            <th>Email:</th>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $contact->email }}</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                            <th>Phone Number:</th>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $contact->phone_number }}</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                            <th>Desired Budget:</th>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $contact->desired_budget }}</td>
                        </tr>
                        <tr class="border-b dark:border-neutral-500">
                            <th>Message:</th>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $contact->message }}</td>
                        </tr>
                        
                        @if($contact->external_nicename)
                        <tr class="border-b dark:border-neutral-500">
                            <th>External Profile:</th>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                <a href="{{ $wpUrl }}/author/{{ $contact->external_nicename }}" target="_blank">{{ $contact->external_nicename }}</a>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
