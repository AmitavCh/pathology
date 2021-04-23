<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TOrganizations extends Model{

    protected $table = 't_organizations';
    public static $rules = array(
        'organization_name'     => 'required',
        'pan_number'            => 'required|max:10|min:10',
        'gst_number'            => 'required|max:15|min:15',
        'mobile_number'         => 'required|max:10|min:10',
        'email_id'              => 'required|email',
        'address'               => 'required',
        'points_of_contact'     => 'required',
        'number_of_branch'      => 'required',
        'bank_name'             => 'required',
        'ifsc_code'             => 'required|max:11|min:11',
        'account_number'        => 'required',
    );
    public static $messages = array(
        'organization_name.required'           => 'Please Add Organization Name',
        'mobile_number.required'               => 'Please Add Mobile Number',
        'mobile_number.max'                    => 'Please Add 10 Digit Mobile Number',
        'mobile_number.min'                    => 'Please Add 10 Digit Mobile Number',
        'email_id.email'                       => 'Enter Valid Email',
        'email_id.required'                    => 'Enter Email Id',
        'address.required'                     => 'Enter Address Details',
        'pan_number.required'                  => 'Please Add PAN Number',
        'pan_number.max'                       => 'Please Add 10 Digit PAN Number',
        'pan_number.min'                       => 'Please Add 10 Digit PAN Number',
        'gst_number.required'                  => 'Please Add GST Number',
        'gst_number.max'                       => 'Please Add 15 Digit GST Number',
        'gst_number.min'                       => 'Please Add 15 Digit GST Number',
        'points_of_contact.required'           => 'Please Add Points Of Contacts Limit',
        'number_of_branch.required'            => 'Please Add Number Of Branch Limit',
        'bank_name.required'                   => 'Please Add Bank Name',
        'ifsc_code.required'                   => 'Please Add IFSC Code',
        'ifsc_code.max'                        => 'Please Add 11 Digit IFSC Code',
        'ifsc_code.min'                        => 'Please Add 11 Digit IFSC Code',
        'account_number.required'              => 'Please Add Bank Account Number',
    );

}
