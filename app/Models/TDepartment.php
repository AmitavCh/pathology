<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TDepartment extends Model{

    protected $table = 't_department';
    public static $rules = array(
        'department_name' => 'required',
    );
    public static $messages = array(
        'department_name.required' => 'Please Add Department Name',
    );

}
