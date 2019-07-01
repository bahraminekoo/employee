<?php

namespace Bahraminekoo\Employee\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ListEmployeesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * list employees test
     *
     * @test
     * @return void
     */
    public function HomePageTest()
    {
        $response = $this->get('/employees');

        $response->assertStatus(200);
    }
}
