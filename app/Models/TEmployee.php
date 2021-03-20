<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TEmployee extends Model{

    protected $table = 't_employee';
    public static $rules = array(
        'employee_name' => 'required',
        'mobile' => 'required|max:10|min:10',
        'email' => 'email',
        't_department_id' => 'required',
        't_designation_id' => 'required',
        'dob' => 'required',
        'joining_date' => 'required',
        'voter_card_number' => 'required',
        'adhar_card_number' => 'required',
        'present_address' => 'required',
    );
    public static $messages = array(
        'employee_name.required'    => 'Please Add Employee Name',
        'mobile.required'           => 'Please Add Mobile Number',
        'mobile.max'                => 'Please Add 10 Digit Mobile Number',
        'mobile.min'                => 'Please Add 10 Digit Mobile Number',
        't_department_id.required'  => 'Please Select Department Name',
        't_designation_id.required' => 'Please Select Designation Name',
        'voter_card_number.required'=> 'Please Add Voter Card Number',
        'adhar_card_number.required'=> 'Please Add Adhar Card Number',
        
        'present_address.required'  => 'Please Add Present Address',
        'dob.required'              => 'Please Select DOB',
        'joining_date.required'     => 'Please Select Joining Date',
        'email.email'               =>  'Enter valid email',
        //'email.unique'			    =>  'This email is already exist',
        //'mobile.unique'			    =>  'This Mobile Number already exist',
    );

}
