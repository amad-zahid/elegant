<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class WPController extends Controller
{
    public function createUser(Request $request)
    {
        $data = $request->validate([
            'contact_id' => 'required',
        ]);

        $record = Contacts::find($request->input('contact_id'));
        if (null === $record) {
            return response()->json(['error' => 'Contact not found'], 400);    
        }

        // Validate request data here if needed
        $baseUrl = env('WP_URL');
        $token = env('WP_TOKEN');
        $wordpressApiUrl = $baseUrl.'/wp-json/custom-subscriber/v1/add-subscriber';

        $signedUrl = URL::signedRoute('external.contacts.show', ['contact' => $record->id]);

        $data = [
            'external_id' => $record->id,
            'name' => $record->name,
            'email' => $record->email,
            'external_url' => $signedUrl,
        ];

        $response = Http::withToken($token)->post($wordpressApiUrl, $data);

        if ($response->successful()) {
            $response = $response->json();
            $record->external_id = $response['user_id'];
            $record->external_nicename = $response['nicename'];
            $record->status = $response['new_user'] ? 2 : 3;
            $record->save();
            return response()->json([
                'success' => true,
                'message' => 'User created successfully!',
                'status_label' => $record->status_label,
            ]);
        } else {
            $response = $response->json();
            return response()->json(['error' => true, 'message' => $response['error'] ?? 'Error from WP side'], 400);
        }
    }
}
