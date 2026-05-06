<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@mis-mdo.sch.id'
        ]);
        Carbon::setTestNow(now());
    }

    private function getAuthHeaders()
    {
        $token = $this->user->createToken('test-analytics')->plainTextToken;
        return [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];
    }

    public function test_analytics_api_is_accessible()
    {
        $response = $this->getJson('/api/analytics', $this->getAuthHeaders());
        
        $response->assertStatus(200)
                ->assertJson(['success' => true]);
    }

}