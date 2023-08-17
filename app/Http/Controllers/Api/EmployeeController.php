<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\Datatables;

class EmployeeController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getEmployeesData();
        }

        return view('employees.index');
    }

    private function getEmployeesData()
    {
        $data = Employee::select(['id', 'name', 'position', 'hire_date', 'phone_number', 'email', 'salary']);

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a>' .
                    '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $employee = Employee::create();

        return new EmployeeResource($employee);
    }

    public function show(Employee $employee)
    {
        // Відобразити інформацію про конкретного співробітника
    }

    public function edit(Employee $employee)
    {
        // Показати форму для редагування інформації про співробітника
    }

    public function update(Request $request, Employee $employee)
    {
        // Оновити інформацію про співробітника в базі даних
    }

    /**
     * @param Employee $employee
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
