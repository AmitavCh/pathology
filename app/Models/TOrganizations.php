<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TOrganizations extends Model{

    protected $table = 't_organizations';
    public static $rules = array(
        'organization_name'     => 'required',
        'mobile_number'         => 'required|max:10|min:10',
        'email_id'              => 'required|email',
        'address'               => 'required',
    );
    public static $messages = array(
        'organization_name.required'           => 'Please Add Organization Name',
        'mobile_number.required'               => 'Please Add Mobile Number',
        'mobile_number.max'                    => 'Please Add 10 Digit Mobile Number',
        'mobile_number.min'                    => 'Please Add 10 Digit Mobile Number',
        'email_id.email'                       => 'Enter Valid Email',
        'email_id.required'                    => 'Enter Email Id',
        'address.required'                     => 'Enter Address Details',
    );

}
