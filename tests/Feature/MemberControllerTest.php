<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetMemberCreationForm()
    {
        $response = $this->get('/members/create');

        $response->assertStatus(200)
            ->assertViewIs('pages.members.create')
            ->assertViewHas('schools');
    }

    public function testStoreNewMember()
    {
        $school = School::factory()->create();

        $memberData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'school_id' => $school->id,
        ];

        $this->post('/members', $memberData)->assertRedirect('/');

        $this->assertDatabaseHas('members', ['name' => 'John Doe', 'email' => 'johndoe@example.com']);
        $this->assertDatabaseHas('member_school', [
            'member_id' => Member::where('name', 'John Doe')->first()->id,
            'school_id' => $school->id,
        ]);
    }
}
