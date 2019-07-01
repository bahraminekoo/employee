<?php

namespace Bahraminekoo\Employee\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Bahraminekoo\Employee\Models\Employee;
use Bahraminekoo\Employee\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{

    /**
     * get all employees ( except soft deleted ones )
     * if they already exist in the cache it gets them from the cache otherwise query the DB
     *
     * @return Collection
     */
    public function all(): Collection
    {
        $collection = Cache::remember('employees', 3600, function () {
            return Employee::with('employees')->orderBy('doe', 'desc')->get();
        });
        return $collection;
    }

    /**
     * get employees in pagination with the specified limit items per page
     * if they already exist in the cache it gets them from the cache otherwise query the DB
     *
     * @param $limit
     * @return LengthAwarePaginator
     */
    public function paginate($limit): LengthAwarePaginator {
        $page = isset($_GET['page']) ? $_GET['page'] : '1';
        $collection = Cache::remember('employees_' . $page, 3600, function () use($limit) {
            return Employee::with('employees')->orderBy('doe', 'desc')->paginate($limit);
        });
        return $collection;
    }

    /**
     * get all the values for specified employee's field
     *
     * @param $value
     * @param $key
     * @return mixed
     */
    public function getAllWithPluck($value, $key) {
        return Employee::pluck($value, $key);
    }

    /**
     * create new employee in DB
     *
     * @param array $data
     * @return Employee
     */
    public function create(array $data): Employee
    {
        Cache::flush();
        return Employee::create($data);
    }

    /**
     * get the employee with id
     * if it already exists in the cache it gets from the cache otherwise query the DB
     *
     * @param int $id
     * @return Employee
     */
    public function findOrFail(int $id): Employee
    {
        $employee = Cache::remember('emp_' . $id, 3600, function () use($id) {
            return Employee::findOrFail($id);
        });
        return $employee;
    }

    /**
     * soft delete employee with id and flush the cache
     *
     * @param int $id
     * @return Employee
     * @throws \Exception
     */
    public function softDelete(int $id): Employee
    {
        Cache::flush();
        $model = $this->findOrFail($id);
        $model->delete();
        return $model;
    }

    /**
     * get all the managing employees for the specified manager
     *
     * @param Employee $manager
     * @return Collection
     */
    public function getEmployees(Employee $manager): Collection
    {
        return $manager->employees()->get();
    }

    /**
     * get all the employees employed in the specified date range
     * if they already exist in the cache it gets them from the cache otherwise query the DB
     *
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function filterDateRange(string $startDate, string $endDate): Collection
    {
        $startDate = Employee::normalizeDate($startDate);
        $endDate = Employee::normalizeDate($endDate);

        $collection = Cache::remember('search_' . $startDate . '_to_' . $endDate, 3600, function () use($startDate, $endDate) {
            return Employee::with('employees')
                ->whereBetween('doe', [$startDate, $endDate])
                ->orderBy('employees.doe', 'desc')
                ->get();
        });
        return $collection;
    }
}