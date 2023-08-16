<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use function Psy\debug;

class EmployeeController extends Controller
{
    public function index( Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $employees = EmployeeResource::collection(Employee::all());

        return view('employees.index', compact('employees'));
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

    public function destroy(Employee $employee)
    {
        // Видалити співробітника з бази даних
    }

    public function getDatatables()
    {
        $employees = Employee::select(['id', 'first_name', 'last_name', 'position', 'hire_date', 'phone_number', 'email', 'salary'])
            ->get()
            ->map(function ($employee) {
                $employee->full_name = $employee->first_name . ' ' . $employee->last_name;
                return $employee;
            });

        return datatables()->of($employees)->toJson();
    }
}
