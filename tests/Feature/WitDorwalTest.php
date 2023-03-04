<?php

namespace Tests\Feature;

use App\Mail\withDrowalFromTuresy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;

class WitDorwalTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_send_with_drowal_test()
    {
        Mail::to('jksaa@altigani.com')->send(new withDrowalFromTuresy(213, 'debit'));
        $this->assertTrue(true);
    }
}