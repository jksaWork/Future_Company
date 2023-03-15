<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AllPageWorkTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_school_dashboad_work()
    {

        $user = Admin::first();
        $response = $this->actingAs($user, 'web')->get(route('school.dashboard'));
        $response->assertStatus(200);
    }
}