<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmployeeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return EmployeeResource::collection(Employee::all());
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

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

}
