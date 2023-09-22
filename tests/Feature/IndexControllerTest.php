<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetTheMainPage()
    {
        // sample data
        $schools = School::factory()->count(3)->create();
        $countries = $schools->pluck('country')->unique()->toArray();

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertViewIs('index')
            ->assertViewHas('schools', $schools)
            ->assertViewHas('countries', $countries);
    }

    public function testSearchSchoolsByNameAndCountry()
    {

        $school1 = School::factory()->create(['name' => 'School A', 'country' => 'GB']);
        $school2 = School::factory()->create(['name' => 'School B', 'country' => 'US']);
        $school3 = School::factory()->create(['name' => 'School C', 'country' => 'GB']);

        $response = $this->get('/search?school=' . $school1->id . '&country=GB');

        // Expect 2 schools matching the search
        $response->assertJsonCount(1, 'schools')
            ->assertJsonFragment(['name' => 'School A']);

        $response = $this->get('/search?school=&country=GB');

        $response->assertJsonCount(2, 'schools')
            ->assertJsonFragment(['name' => 'School A'])
            ->assertJsonFragment(['name' => 'School C']);
    }

    public function testSchoolMembersChartData()
    {
        $school1 = School::factory()->create();
        $school2 = School::factory()->create();
        $school3 = School::factory()->create();

        $school1->members()->attach(Member::factory(3)->create()->pluck('id'));
        $school2->members()->attach(Member::factory(2)->create()->pluck('id'));
        $school3->members()->attach(Member::factory(4)->create()->pluck('id'));

        $response = $this->get('/chart');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'schools')
            ->assertJsonFragment(['name' => $school1->name, 'memberCount' => 3])
            ->assertJsonFragment(['name' => $school2->name, 'memberCount' => 2])
            ->assertJsonFragment(['name' => $school3->name, 'memberCount' => 4]);
    }
}
