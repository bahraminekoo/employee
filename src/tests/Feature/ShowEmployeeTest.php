<?php

namespace Bahraminekoo\Employee\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Bahraminekoo\Employee\Models\Employee;
use Tests\TestCase;

class ShowEmployeeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * show employee test
     *
     * @test
     * @return void
     */
    public function showTest()
    {
        $employee = factory(Employee::class)->create();

        $response = $this->get('/employees/' . $employee->getKey());

        $response->assertStatus(200);
    }
}
