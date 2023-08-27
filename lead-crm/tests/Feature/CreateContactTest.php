<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateContactTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_contact_can_register()
    {
        $email = fake()->unique()->safeEmail();
        $response = $this->post('/contact', [
            "name" => fake()->name(),
            "email" => $email,
            "phone_number" => fake()->phoneNumber(),
            "desired_budget" => fake()->numberBetween(100, 10000),
            "message" => "Interested in your services."
        ]);

        $this->assertDatabaseHas('contacts', [
            'email' => $email,
        ]);
    }
}
