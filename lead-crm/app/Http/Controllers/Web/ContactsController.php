<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacts;

class ContactsController extends Controller
{
    // Show the form for creating a new contact
    public function create()
    {
        return view('web.create_contact');
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

        return redirect()->route('web.contact')
            ->with('success', 'Contact created successfully.');
    }

}
