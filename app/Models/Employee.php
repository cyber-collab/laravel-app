<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'position', 'hire_date', 'phone_number', 'email', 'salary', 'photo'];

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public static function getEmployeesData()
    {
        $data = Employee::select(['id', 'name', 'position', 'hire_date', 'phone_number', 'email', 'salary', 'photo']);

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
            })
            ->make(true);
    }

    public static function getValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'string|max:255',
            'hire_date' => 'nullable|date',
            'phone_number' => ['required', 'string', 'max:20', 'regex:/^\+380\d{9}$/u'],
            'email' => 'required|string|email|max:255',
            'salary' => ['required', 'numeric', 'between:0,9999999.99'],
            'photo' => 'nullable|image|max:2048',
        ];
    }
}
