<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\DataTables;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hire_date', 'phone_number', 'email', 'salary', 'photo', 'position_id'];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public static function getEmployeesData()
    {
        $data = Employee::with('position')->select(['id', 'name', 'hire_date', 'phone_number', 'email', 'salary', 'photo', 'position_id']);

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
            'photo' => 'nullable|image|mimes:jpeg,png|max:5000',
        ];
    }
}
