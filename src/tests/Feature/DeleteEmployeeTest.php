<?php

namespace Bahraminekoo\Employee\Tests\Feature;

use Bahraminekoo\Employee\Models\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteEmployeeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * delete employee test
     *
     * @test
     * @return void
     */
    public function deleteTest()
    {
        $employee = factory(Employee::class)->create();

        $response = $this->delete('/employees/' . $employee->getKey());

        $response->assertStatus(302);
    }
}
