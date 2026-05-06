<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    // 1. Uji apakah API Dashboard bisa diakses tanpa error 500
    public function test_dashboard_api_is_accessible()
    {
        // Buat user admin
        $user = User::factory()->create(['role' => 'admin']); 

        // Akses endpoint dashboard
        $response = $this->actingAs($user)->getJson('/api/dashboard');
        
        // Pastikan tidak ada error server
        $response->assertStatus(200);
    }

    // 2. Uji Middleware Autentikasi
    public function test_dashboard_page_is_accessible_to_authenticated_users()
    {
        $user = User::factory()->create(['role' => 'admin']);

        // Mencoba akses tanpa login (harus gagal / 401)
        $this->getJson('/api/me')->assertStatus(401);

        // Akses setelah login (harus sukses / 200)
        $response = $this->actingAs($user)->getJson('/api/me');
        $response->assertStatus(200);
    }
}