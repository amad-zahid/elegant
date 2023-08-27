<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <button id="action-button" class="inline-block rounded rounded-md text-white bg-neutral-800 p-4 dark:bg-neutral-900 px-7 pb-2.5 pt-3 text-sm font-medium uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                        Apply Action
                    </button>
                    <a href="{{ route('contacts.create') }}" class="inline-block rounded rounded-md text-white bg-neutral-800 p-4 dark:bg-neutral-900 px-7 pb-2.5 pt-3 text-sm font-medium uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">Add New Contact</a>
                    <div class="overflow-hidden">
                        <table class="text-left text-sm font-light">
                            <thead class="border-b font-medium dark:border-neutral-500">
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th scope="col" class="px-6 py-4">Name</th>
                                    <th scope="col" class="px-6 py-4">Email</th>
                                    <th scope="col" class="px-6 py-4">Phone Number</th>
                                    <th scope="col" class="px-6 py-4">Desired Budget</th>
                                    <th scope="col" class="px-6 py-4">Message</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
                                    <th scope="col" class="px-6 py-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr class="border-b dark:border-neutral-500" id="contact-row-{{ $contact->id }}">
                                        <td data-contact-id="{{ $contact->id }}">
                                            @if(null === $contact->external_id)
                                                <input type="checkbox" class="select-row">
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $contact->name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $contact->email }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $contact->phone_number }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $contact->desired_budget }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $contact->message }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $contact->status_label }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-primary">Edit</a>
                                            @if(null === $contact->external_id)
                                                <span class="create-wordpress-action-{{ $contact->id }}">
                                                &nbsp; | &nbsp;
                                                <button class="create-wordpress-account" data-contact-id="{{ $contact->id }}">Create WordPress Account</button>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.create-wordpress-account').click(function() {
            var contactId = $(this).data('contact-id');
            createUser(contactId)
        });

        $('#select-all').change(function() {
            $('.select-row').prop('checked', $(this).prop('checked'));
        });

        $('.select-row').change(function() {
            var allChecked = $('.select-row:checked').length === $('.select-row').length;
            $('#select-all').prop('checked', allChecked);
        });

        $('#action-button').click(function() {
            var rowIds = [];
            var selectedRows = $('.select-row:checked').closest('tr');

            if (selectedRows.length == 0) {
                alert('Please select atleast on record');
            }

            // Perform your action with the selected rows
            selectedRows.each(function() {
                var contactId = $(this).find('td:eq(0)').data('contact-id'); // Assuming ID is in the second column
                // rowIds.push(rowId);
                // Perform your action with the row ID
                createUser(contactId);
            });
            
            $(this).prop('checked', false);

        });

        var createUser = function (contactId) {
            $.ajax({
                url: '{{ route('wp.create.user') }}', // Change to the actual route
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'contact_id': contactId
                },
                success: function(response) {
                    // console.log(response);
                    if (response.success) {
                        $('.create-wordpress-action-'+ contactId).remove();
                        let contactRow = $('#contact-row-'+ contactId);
                        contactRow.find('td:eq(0)').text('');
                        contactRow.find('td:eq(6)').text(response.status_label);
                        // alert(response.message);
                    } else {
                        // alert('Error while creating user');
                    }
                },
                error: function(xhr, status, error) {
                    // console.log(xhr.responseText);
                    // alert(error.message);
                }
            });
        }
    });


</script>
