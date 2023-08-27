<?php

namespace Tests\Feature;

use App\Models\Contacts;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExportContactTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_contact_can_export()
    {
        $user = User::factory()->create();

        $contact = Contacts::orderBy('created_at', 'desc')->first();

        $response = $this
            ->actingAs($user)
            ->post('/wp/create-user', [
                "contact_id" => $contact->id,
            ]);

        $response->assertJson(['success' => true]);
    }
}
