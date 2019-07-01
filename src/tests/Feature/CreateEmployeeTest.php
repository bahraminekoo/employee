<?php

namespace Bahraminekoo\Employee\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Bahraminekoo\Employee\Models\Employee;
use Tests\TestCase;

class CreateEmployeeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * create employee test.
     *
     * @test
     * @return void
     */
    public function createEmployeeTest()
    {
        $manager = factory(Employee::class)->create();

        $response = $this->post(url('/employees'), [
            'name' => 'test employee',
            'email' => 'test@test.com',
            'doe' => '2019-05-06',
            'manager_id' => $manager->getKey(),
        ]);

        $response->assertStatus(302);
    }
}
