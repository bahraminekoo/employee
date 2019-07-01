<?php

namespace Bahraminekoo\Employee\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Bahraminekoo\Employee\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;

interface EmployeeRepositoryInterface
{
    /**
     * get all employees ( except soft deleted ones )
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * get employees in pagination with the specified limit items per page
     *
     * @param $limit
     * @return LengthAwarePaginator
     */
    public function paginate($limit): LengthAwarePaginator;

    /**
     * get all values for the specified field in employee's table
     *
     * @param $value
     * @param $key
     * @return mixed
     */
    public function getAllWithPluck($value, $key);

    /**
     * create new employee in database
     *
     * @param array $data
     * @return Employee
     */
    public function create(array $data): Employee;

    /**
     * find employee with the id or throw a not found error
     *
     * @param int $id
     * @return Employee
     */
    public function findOrFail(int $id): Employee;

    /**
     * soft delete employee with the id
     *
     * @param int $id
     * @return Employee
     */
    public function softDelete(int $id): Employee;

    /**
     * get all the managing employees for the specified manager
     *
     * @param Employee $manager
     * @return Collection
     */
    public function getEmployees(Employee $manager): Collection;

    /**
     * filter employee's collection based on the specified employment date range
     *
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function filterDateRange(string $startDate,string $endDate): Collection;
}