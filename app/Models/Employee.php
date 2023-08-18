<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\Datatables;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'surname', 'position', 'hire_date', 'phone_number', 'email', 'salary', 'photo',];

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
        $data = self::select(['id', 'name', 'position', 'hire_date', 'phone_number', 'email', 'salary']);

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm" data-id="' . $row->id . '">Edit</a>' .
                    '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
