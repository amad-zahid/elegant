<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contacts;
use Illuminate\Http\Request;

class ExternalContactController extends Controller
{
    public function show(Contacts $contact)
    {
        $wpUrl = env('WP_URL'); 
        return view('contacts.show', compact('contact', 'wpUrl'));
    }
}
