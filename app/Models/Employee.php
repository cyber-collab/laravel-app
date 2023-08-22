<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hire_date', 'phone_number', 'email', 'salary', 'photo', 'position_id', 'manager_level', 'manager_id', 'admin_created_id', 'admin_updated_id', 'manager_id'];

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($employee) {
            if ($employee->manager_id) {
                $newManager = Employee::where('manager_id', $employee->manager_id)
                    ->where('manager_level', $employee->manager_level)
                    ->where('id', '!=', $employee->id)
                    ->first();

                if (! $newManager) {
                    $higherManager = Employee::where('manager_id', $employee->manager_id)
                        ->where('manager_level', $employee->manager_level - 1)
                        ->first();

                    if ($higherManager) {
                        Employee::where('manager_id', $employee->id)
                            ->update(['manager_id' => $higherManager->id]);
                    }
                } else {
                    Employee::where('manager_id', $employee->id)
                        ->update(['manager_id' => $newManager->id]);
                }
            }
        });
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public static function getEmployeesData()
    {
        $data = Employee::with('position', 'manager')->select(['id', 'name', 'hire_date', 'phone_number', 'email', 'salary', 'photo', 'position_id', 'manager_id']);

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('manager_name', function ($data) {
                return $data->manager ? $data->manager->name : 'No Manager';
            })
            ->addColumn('action', function ($data) {
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm mr-1 mb-1"> <i class="bi bi-pencil-square"></i></button>';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm mb-1"> <i class="bi bi-backspace-reverse-fill"></i></button>';

                return $button;
            })
            ->make(true);
    }

    public static function getValidationRules()
    {
        return [
            'manager_id' => [
                'nullable',
                'exists:employees,id',
                function ($attribute, $value, $fail) {

                    $employee = Employee::find($value);

                    if (! $employee) {
                        return;
                    }

                    $currentEmployee = $this->instance;
                    if ($employee->manager_level >= $currentEmployee->manager_level) {
                        $fail('The manager should have a higher level than the employee.');
                    }
                },
            ],
            'name' => 'required|string|max:255',
            'position' => 'string|max:255',
            'hire_date' => 'nullable|date|required',
            'phone_number' => 'required|string|max:20|regex:/^\+380\d{9}$/u',
            'email' => 'required|string|email|max:255',
            'salary' => 'required|numeric|between:0,9999999.99',
            'photo' => 'nullable|image|mimes:jpeg,png|max:5000',
        ];
    }
}
