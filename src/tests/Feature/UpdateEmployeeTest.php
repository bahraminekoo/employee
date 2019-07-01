<?php

namespace Bahraminekoo\Employee\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Bahraminekoo\Employee\Models\Employee;
use Tests\TestCase;

class UpdateEmployeeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * update employee test
     *
     * @test
     * @return void
     */
    public function updateTest()
    {
        $employee = factory(Employee::class)->create();

        $response = $this->put('/employees/' . $employee->getKey(), [
            'name' => 'updated name for testing',
        ]);

        $response->assertStatus(302);
    }
}
