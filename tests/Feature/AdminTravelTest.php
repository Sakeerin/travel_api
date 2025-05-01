<?php

namespace Tests\Feature;

use App\Models\Role;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTravelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_public_user_cannot_access_adding_travel(): void
    {
        $response = $this->postJson('/api/v1/admin/travel');

        $response->assertStatus(401);
    }

    public function test_non_admin_user_cannot_access_adding_travel(): void
    {
        $this->seed(RoleSeeder::class);
        $user = \App\Models\User::factory()->create();
        $user->roles()->attach(Role::where('name','editor')->value('id')); // Assuming 2 is the ID for a non-admin role
        $response = $this->actingAs($user)->postJson('/api/v1/admin/travel');
        $response->assertStatus(403);
    }

    public function test_saves_travel_successfully_with_valid_data(): void
    {
        $this->seed(RoleSeeder::class);
        $user = \App\Models\User::factory()->create();
        $user->roles()->attach(Role::where('name','admin')->value('id')); // Assuming 1 is the ID for admin role
        $response = $this->actingAs($user)->postJson('/api/v1/admin/travel',[
            'name' => 'Travel name',
        ]);
        $response->assertStatus(422);

        $responss = $this->actingAs($user)->postJson('/api/v1/admin/travel',[
            'name' => 'Travel name',
            'destination' => 'Travel destination',
            'number_of_days' => 5,
            'is_public' => 1,
        ]);
        $responss->assertStatus(201);

        $responss->assertStatus(201);
        $response->assertJsonFragment(['name' => 'Travel name']);
    }
}
