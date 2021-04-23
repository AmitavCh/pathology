<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
use Notifiable;

protected $fillable = [
'name', 'email', 'password',
];
protected $hidden = [
'password', 'remember_token',
];

protected $casts = [
'email_verified_at' => 'datetime',
];
public static $rules = array(
    'master' => array(

                'role_id'                   => 'required',
                't_organizations_id'        => 'required',
                'mobile_number'             => 'required|max:10|min:10',
                'full_name'                 => 'required',
                'email_id'                  => 'required|email|unique:users',
                'ogr_password'              => 'required',
                'alter_mobile_number'       => 'max:10|min:10',
                'adhar_number'              => 'required|max:16|min:16',
     ),
    'masterupdate' => array(

                'role_id'                   => 'required',
                't_organizations_id'        => 'required',
                'mobile_number'             => 'required|max:10|min:10',
                'full_name'                 => 'required',
                'email_id'                  => 'required|email',
                'ogr_password'              => 'required',
                'alter_mobile_number'       => 'max:10|min:10',
                'adhar_number'              => 'required|max:16|min:16',
     ),
    'branch' => array(

                'role_id'                   => 'required',
                't_branch_details_id'        => 'required',
                'mobile_number'             => 'required|max:10|min:10',
                'full_name'                 => 'required',
                'email_id'                  => 'required|email|unique:users',
                'ogr_password'              => 'required',
                'alter_mobile_number'       => 'max:10|min:10',
                'adhar_number'              => 'required|max:16|min:16',
     ),
    'branchupdate' => array(

                'role_id'                   => 'required',
                't_branch_details_id'        => 'required',
                'mobile_number'             => 'required|max:10|min:10',
                'full_name'                 => 'required',
                'email_id'                  => 'required|email',
                'ogr_password'              => 'required',
                'alter_mobile_number'       => 'max:10|min:10',
                'adhar_number'              => 'required|max:16|min:16',
     ),
    'lab' => array(

                'role_id'                   => 'required',
                't_business_logistic_dtl_id'=> 'required',
                'mobile_number'             => 'required|max:10|min:10',
                'full_name'                 => 'required',
                'email_id'                  => 'required|email|unique:users',
                'ogr_password'              => 'required',
                'alter_mobile_number'       => 'max:10|min:10',
                'adhar_number'              => 'required|max:16|min:16',
     ),
    'labupdate' => array(

                'role_id'                   => 'required',
                't_business_logistic_dtl_id'=> 'required',
                'mobile_number'             => 'required|max:10|min:10',
                'full_name'                 => 'required',
                'email_id'                  => 'required|email',
                'ogr_password'              => 'required',
                'alter_mobile_number'       => 'max:10|min:10',
                'adhar_number'              => 'required|max:16|min:16',
     ),
    'changepassword' => array(
            'ogr_password' => 'required',
            'password' => 'required|same:re_password',
            're_password' => 'required',
     ),
 );

public static $messages = array(

                't_branch_details_id.required'                                  => 'Please Select Branch Name',
                't_business_logistic_dtl_id.required'                           => 'Please Select Lab/Collection Center Name',
                't_organizations_id.required'                                   => 'Please Select Organization Name',
                'role_id.required'                                              => 'Please Select Role Name',
                'full_name.required'                                            => 'Enter Your Full Name',
                'email_id.required'                                             => 'Enter Your Email Id',
                'email_id.email'                                                => 'Enter valid email id',
                'ogr_password.required'                                         => 'Enter Your Password',
                're_password.required'                                          => 'Enter Your Password',
                'mobile_number.required'                                        => 'Please Add Mobile Number',
                'mobile_number.max'                                             => 'Please Add 10 Digit Mobile Number',
                'mobile_number.min'                                             => 'Please Add 10 Digit Mobile Number',
                'password.confirmed'                                            => 'Password confirmation does not match.',
                're_password.same'                                              => 'Password Confirmation should match the Password',
                'alter_mobile_number.max'                                       => 'Please Add 10 Digit Mobile Number',
                'alter_mobile_number.min'                                       => 'Please Add 10 Digit Mobile Number',
                'adhar_number.required'                                         => 'Please Add Adhar Card Number',
                'adhar_number.max'                                              => 'Please Add 16 Digit Adhar Card Number',
                'adhar_number.min'                                              => 'Please Add 16 Digit Adhar Card Number',
);

}

