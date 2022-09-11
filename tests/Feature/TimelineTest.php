<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\TimelineController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TimelineTest extends TestCase
{

    public function setUp() :void
    {
        $this->timecontroller = new TimelineController;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertEquals(2,$this->timecontroller->addnumber(1,1));
    }


}
