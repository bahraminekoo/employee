<?php

namespace Bahraminekoo\Employee\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Bahraminekoo\Employee\Repositories\Interfaces\EmployeeRepositoryInterface;
use Bahraminekoo\Employee\Requests\FiltersRequest;
use Bahraminekoo\Employee\Requests\StoreEmployee;
use Bahraminekoo\Employee\Requests\UpdateEmployee;

class EmployeeController extends Controller
{

    /**
     * @var EmployeeRepositoryInterface
     */
    protected $repository;

    /**
     * EmployeeController constructor.
     * @param EmployeeRepositoryInterface $repository
     */
    public function __construct(EmployeeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * display a list of employees
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Log::info('showing employee list');
        $data = Session::get('data');
        if(!is_null($data)) {
            return view('paloit::index', $data);
        } else {
            $collection = $this->repository->paginate(config('employee.items_per_page'));
            return view('paloit::index', ['employees' => $collection, 'is_manager_employees' => false]);
        }
    }

    /**
     * show the form to create new employee
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $employees = $this->repository->getAllWithPluck('name', 'id');
        return view('paloit::create')->with('employees', $employees);
    }

    /**
     * store a newly created employee in storage
     *
     * @param StoreEmployee $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreEmployee $request)
    {
        $employee = $this->repository->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'doe' => date('Y-m-d', strtotime($request->input('doe'))),
        ]);
        if ($request->input('manager_id')) {
            $manager = $this->repository->findOrFail($request->input('manager_id'));
            $employee->manager()->associate($manager);
            $employee->save();
            Cache::flush();
        }
        if ($employee) {
            Log::info('new employee created , employee id : ' . $employee->getKey());
            return redirect('/employees')->with('success', 'Employee successfully added');
        } else {
            Log::error('Can not add new Employee');
            return redirect('/employees')->with('error', 'Can not add Employee');
        }
    }

    /**
     * show employee by id
     * at the moment the method is used for test puposes
     *
     * @param $id
     */
    public function show($id) {

    }

    /**
     * show the form for editin specified employee
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $employee = $this->repository->findOrFail($id);
        $employees = $this->repository->getAllWithPluck('name', 'id');
        return view('paloit::edit', ['employee' => $employee, 'employees' => $employees]);
    }

    /**
     * update specified employee with the posted data
     *
     * @param UpdateEmployee $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateEmployee $request, $id)
    {
        $employee = $this->repository->findOrFail($id);
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->doe = date('Y-m-d', strtotime($request->input('doe')));
        if ($employee->manager_id) {
            $manager = $this->repository->findOrFail($request->manager_id);
            $employee->manager()->associate($manager);
        }
        $employee->save();
        Cache::flush();
        if ($employee) {
            Log::info('Employee updated, employee id : ' . $employee->getKey());
            return redirect('/employees')->with('success', 'Employee successfully edited');
        } else {
            Log::error('Can not edit employee with id : ' . $employee->getKey());
            return redirect('/employees')->with('error', 'Can not edit Employee');
        }
    }

    /**
     * soft delete specified employee
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
         $result = $this->repository->softDelete($id);
        if ($result) {
            Log::info('Employee soft deleted, id : ' . $result->getKey());
            return redirect('/employees')->with('success', 'Employee successfully deleted');
        } else {
            Log::error('Can not delete Employee with id : ' . $result->getKey());
            return redirect('/employees')->with('error', 'Can not delete Employee');
        }
    }

    /**
     * @param  \Bahraminekoo\Employee\Requests\FiltersRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function search(FiltersRequest $request)
    {
        $endDate = $request->input('end_date');
        if (\DateTime::createFromFormat('Y-m-d', $endDate) !== FALSE) {
            if(strtotime($endDate) < strtotime($request->input('start_date'))) {
                Log::error(trans('paloit::messages.end_date_less_than_start_date'));
                return redirect('/employees')->with('error', trans('paloit::messages.end_date_less_than_start_date'));
             }
        } else {
            $endDate = date('Y-m-d');
        }
        $collection = $this->repository->filterDateRange($request->input('start_date'), $endDate);
        Log::info('search result created successfully !');
        return redirect('/employees')->with('data' , ['employees' => $collection, 'is_search_result' => true, 'message' =>
        trans('paloit::messages.search_result_for_date_range') . $request->input('start_date')
        . ' , ' . $endDate . " - " . $collection->count() . ' items' ]);
    }

    /**
     * get manager id and shows its managing employees
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employees($id) {
        $manager = $this->repository->findOrFail($id);
        $collection = $this->repository->getEmployees($manager);
        return view('paloit::index', ['employees' => $collection, 'is_manager_employees' => true, 'manager' => $manager]);
    }
}
