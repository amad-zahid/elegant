<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;

class ContactsController extends Controller
{
    // Display a list of contacts
    public function index()
    {
        $contacts = Contacts::all(); // Fetch all contacts
        return view('contacts.index', compact('contacts'));
    }

    // Show the form for creating a new contact
    public function create()
    {
        return view('contacts.create');
    }

    // Store a newly created contact in the database
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|unique:contacts|max:255',
            'desired_budget' => 'required|numeric',
            'message' => 'nullable|string',
        ]);

        Contacts::create($data);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    // Show the form for editing the specified contact
    public function show(Contacts $contact)
    {
        $wpUrl = env('WP_URL'); 
        return view('contacts.show', compact('contact', 'wpUrl'));
    }

    // Show the form for editing the specified contact
    public function edit(Contacts $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    // Update the specified contact in the database
    public function update(Request $request, Contacts $contact)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'desired_budget' => 'required|numeric',
            'message' => 'nullable|string',
        ]);

        $contact->update($data);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    // Remove the specified contact from the database
    public function destroy(Contacts $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
