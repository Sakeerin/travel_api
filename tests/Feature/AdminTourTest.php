<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTourTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_public_user_cannot_access_adding_tour(): void
    {
        $travel = Travel::factory()->create();
        $response = $this->postJson('/api/v1/admin/travels/'.$travel->id.'/tours');

        $response->assertStatus(401);
    }

    public function test_non_admin_user_cannot_access_adding_tour(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->value('id')); // Assuming 2 is the ID for a non-admin role
        $travel = Travel::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/v1/admin/travels/'.$travel->id.'/tours');

        $response->assertStatus(403);
    }

    public function test_saves_tour_successfully_with_valid_data(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'admin')->value('id')); // Assuming 1 is the ID for admin role
        $travel = Travel::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/admin/travels'.$travel->id.'/tours', [
            'name' => 'Travel name',
        ]);
        $response->assertStatus(422);

        $responss = $this->actingAs($user)->postJson('/api/v1/admin/travels'.$travel->id.'/tours', [
            'name' => 'Travel name',
            'destination' => 'Travel destination',
            'number_of_days' => 5,
            'is_public' => 1,
        ]);
        $responss->assertStatus(201);

        $responss = $this->get('/api/v1/admin/travels/'.$travel->slug.'/tours');
        $response->assertJsonFragment(['name' => 'Travel name']);
    }
}
