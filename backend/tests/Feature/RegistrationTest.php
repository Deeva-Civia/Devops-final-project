<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\SchoolYear;
use App\Models\Semester;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_start_registration_draft()
    {
        $user = User::factory()->create();
        $schoolYear = SchoolYear::create(['year' => '2025/2026']);
        $semester = Semester::create([
            'number' => 1, 
            'name' => 'One', 
            'school_year_id' => $schoolYear->id
        ]);

        $this->actingAs($user);

        // 3. Eksekusi Start Registration
        $response = $this->postJson('/api/registration/start', [
            'school_year_id' => $schoolYear->school_year_id,
            'semester_id' => $semester->semester_id,
        ]);

        // 4. Verifikasi
        $response->assertStatus(200)
                ->assertJson(['success' => true])
                ->assertJsonStructure(['data' => ['draft_id']]);
        
        $this->assertDatabaseHas('drafts', [
            'user_id' => $user->id,
            'school_year_id' => $schoolYear->school_year_id
        ]);
    }
}