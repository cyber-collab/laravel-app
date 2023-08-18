<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    /**
     * Get a list of employees.
     *
     * @param Request $request
     * @return mixed
     *
     * @OA\Get(
     *     path="/employees",
     *     summary="Get a list of employees",
     *     tags={"Employees"},
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

    /**
     * Create a new employee.
     *
     * @param EmployeeStoreRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/employees",
     *     tags={"Employees"},
     *     summary="Create a new employee",
     *     @OA\Response(response="201", description="Employee created successfully"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     @OA\Response(response="500", description="Server error"),
     * )
     */
    public function store(EmployeeStoreRequest $request): JsonResponse
    {
        $employee = Employee::create($request->validated());

        return response()->json([
            'message' => 'Employee created successfully',
            'employee' => new EmployeeResource($employee),
        ], 201);
    }

    /**
     * Show the specified employee.
     *
     * @param Employee $employee
     * @return Application|Factory|View
     *
     * @OA\Get(
     *     path="/api/employees/{employee}",
     *     summary="Show the specified employee",
     *     tags={"Employees"},
     *     @OA\Parameter(name="employee", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="404", description="Not found"),
     *     @OA\Response(response="500", description="Server error"),
     * )
     */
    public function show(Employee $employee)
    {
        $employee = new EmployeeResource($employee);

        return view('employees.show', compact('employee'));
    }

    /**
     * Update the specified employee.
     *
     * @param EmployeeStoreRequest $request
     * @param Employee $employee
     * @return EmployeeResource
     *
     * @OA\Put(
     *     path="/api/employees/{employee}",
     *     tags={"Employees"},
     *     summary="Update the specified employee",
     *     @OA\Parameter(name="employee", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="422", description="Unprocessable Entity"),
     *     @OA\Response(response="404", description="Not found"),
     *     @OA\Response(response="500", description="Server error"),
     * )
     */
    public function update(EmployeeStoreRequest $request, Employee $employee): EmployeeResource
    {
        $employee->update($request->validated());

        return new EmployeeResource($employee);
    }

    /**
     * Delete the specified employee.
     *
     * @param Employee $employee
     * @return JsonResponse
     *
     * @OA\Delete(
     *     path="/api/employees/{employee}",
     *     tags={"Employees"},
     *     summary="Delete the specified employee",
     *     @OA\Parameter(name="employee", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="204", description="No Content"),
     *     @OA\Response(response="404", description="Not found"),
     *     @OA\Response(response="500", description="Server error"),
     * )
     */
    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

}
