<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *
 *     @OA\Info(
 *         title="API Documentation",
 *         version="1.0.0"
 *     )
 * )
 */
class EmployeeController extends Controller
{
    private array $formData;

    public function __construct(Request $request)
    {
        $this->formData = [
            'name' => $request->name,
            'position_id' => $request->position,
            'hire_date' => $request->hire_date,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'salary' => $request->salary,
            'admin_updated_id' => Auth::id(),
            'manager_level' => $request->manager_level,
        ];
    }

    /**
     * Get a list of employees.
     *
     * @return mixed
     *
     * @OA\Get(
     *     path="/employees",
     *     summary="Get a list of employees",
     *     tags={"Employees"},
     *
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="500", description="Server error"),
     * )
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Employee::getEmployeesData();
        }

        return view('employees.index');
    }

    public function edit($id): JsonResponse
    {
        if (request()->ajax()) {
            $employee = Employee::findOrFail($id);
            $positions = Position::all();
        }

        return response()->json([
            'result' => $employee ?? '',
            'positions' => $positions ?? '',
            'current_position' => $employee->position_id ?? null,
        ]
        );
    }

    /**
     * Show the specified employee.
     *
     * @OA\Get(
     *     path="/employees/show/{employee}",
     *     summary="Show the specified employee",
     *     tags={"Employees"},
     *
     *     @OA\Parameter(name="employee", in="path", required=true, @OA\Schema(type="integer")),
     *
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="404", description="Not found"),
     *     @OA\Response(response="500", description="Server error"),
     * )
     */
    public function show(int $id): Factory|View|Application
    {
        $employee = Employee::findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    /**
     * Update the specified employee.
     *
     * TODO need fix image
     *
     * @OA\Put(
     *     path="/employees/{employee}",
     *     tags={"Employees"},
     *     summary="Update the specified employee",
     *
     *     @OA\Parameter(name="employee", in="path", required=true, @OA\Schema(type="integer")),
     *
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     @OA\Response(response="404", description="Not found"),
     *     @OA\Response(response="500", description="Server error"),
     * )
     */
    public function update(Request $request): JsonResponse
    {
        $error = Validator::make($request->all(), Employee::getValidationRules());

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $employee = Employee::find($request->employee_id);

        if (! $employee) {
            return response()->json(['error' => 'Employee not found']);
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('storage/images', $fileName);
            if ($employee->photo) {
                Storage::delete(public_path('images').$employee->photo);
            }
        } else {
            $fileName = $request->employee_photo;
        }

        $employeeData = array_merge(
            $this->formData,
            ['photo' => $fileName]
        );

        $employee->update($employeeData);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    /**
     * Create a new employee.
     *
     * TODO need fix image
     *
     * @OA\Post(
     *     path="/employees",
     *     tags={"Employees"},
     *     summary="Create a new employee",
     *
     *     @OA\Response(response="201", description="Employee created successfully"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     @OA\Response(response="500", description="Server error"),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $error = Validator::make($request->all(), Employee::getValidationRules());

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
//        $file = $request->file('photo');
//        $fileName = time() . '.' . $file->getClientOriginalExtension();
//        $file->storeAs(public_path('images'), $fileName);

        Employee::create($this->formData);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Delete the specified employee.
     *
     * @OA\Delete(
     *     path="employees/{employee}",
     *     tags={"Employees"},
     *     summary="Delete the specified employee",
     *
     *     @OA\Parameter(name="employee", in="path", required=true, @OA\Schema(type="integer")),
     *
     *     @OA\Response(response="204", description="No Content"),
     *     @OA\Response(response="404", description="Not found"),
     *     @OA\Response(response="500", description="Server error"),
     * )
     */
    public function destroy($id): JsonResponse
    {
        $employee = Employee::findOrFail($id);

        $newManagerId = $employee->manager_id;

        Employee::where('manager_id', $employee->id)->update(['manager_id' => $newManagerId]);

        $employee->delete();

        return response()->json(['success' => 'Employee deleted successfully']);
    }
}
