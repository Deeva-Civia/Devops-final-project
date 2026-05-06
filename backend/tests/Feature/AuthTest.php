<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database sqlite setiap kali test dijalankan

    public function test_user_can_login_with_valid_email_domain()
    {
        $user = User::factory()->create([
            'email' => 'deeva@mis-mdo.sch.id',
            'username' => 'deeva',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'identifier' => 'deeva@mis-mdo.sch.id',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['success', 'token', 'user'])
                ->assertJson(['success' => true]);
    }

    public function test_login_fails_with_invalid_email_domain()
    {
        $response = $this->postJson('/api/login', [
            'identifier' => 'user@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401)
                ->assertJson(['message' => 'Email/Username or Password is incorrect']);
    }
}