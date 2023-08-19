<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use Yajra\DataTables\DataTables;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="API Documentation",
 *         version="1.0.0"
 *     )
 * )
 */

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
           return Employee::getEmployeesData();
        }

        return view('employees.index');
    }

    public function store(Request $request)
    {
        $error = Validator::make($request->all(), Employee::getValidationRules());

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = [
            'name' => $request->name,
            'position' => $request->position,
            'hire_date' => $request->hire_date,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'salary' => $request->salary,
        ];

        Employee::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id): JsonResponse
    {
        if (request()->ajax()) {
            $employee = Employee::findOrFail($id);
        }
        return response()->json(['result' => $employee ?? '']);
    }

    public function show(int $id)
    {
        $employee = Employee::findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    public function update(Request $request): JsonResponse
    {
        $error = Validator::make($request->all(), Employee::getValidationRules());

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = [
            'name' => $request->name,
            'position' => $request->position,
            'hire_date' => $request->hire_date,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'salary' => $request->salary,
        ];

        Employee::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(['success' => 'Employee deleted successfully']);

    }
}
