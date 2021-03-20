<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBranchDetails extends Model{

    protected $table = 't_branch_details';
    public static $rules = array(
        'branch_name'           => 'required',
        'mobile_number'         => 'required|max:10|min:10',
        'email_id'              => 'required|email',
        'address'               => 'required',
        't_states_id'            => 'required',
        't_cities_id'           => 'required',
        'pin_code'              => 'required|max:6|min:6',
    );
    public static $messages = array(
        'branch_name.required'                 => 'Please Add Branch Name',
        'mobile_number.required'               => 'Please Add Mobile Number',
        'mobile_number.max'                    => 'Please Add 10 Digit Mobile Number',
        'mobile_number.min'                    => 'Please Add 10 Digit Mobile Number',
        'email_id.email'                       => 'Enter Valid Email',
        'email_id.required'                    => 'Enter Email Id',
        't_states_id.required'                  => 'Please Select State Name',
        't_cities_id.required'                 => 'Please Select City Name',
        'address.required'                     => 'Enter Address Details',
        'pin_code.required'                    => 'Please Add Pin Code',
        'pin_code.max'                         => 'Please Add 6 Digit Pin Code',
        'pin_code.min'                         => 'Please Add 6 Digit Pin Code',
    );

}
