<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TDesignation extends Model{

    protected $table = 't_designation';
    public static $rules = array(
        'designation_name' => 'required',
    );
    public static $messages = array(
        'designation_name.required' => 'Please Add Designation Name',
    );

}
