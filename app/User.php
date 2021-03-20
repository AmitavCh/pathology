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
                't_branch_details_id'       => 'required',
                'mobile_number'             => 'required|max:10|min:10',
                'full_name'                 => 'required',
                'email_id'                  => 'required|email|unique:users',
                'ogr_password'              => 'required',
     ),
    'update' => array(

                'role_id'                   => 'required',
                't_organizations_id'        => 'required',
                't_branch_details_id'       => 'required',
                'mobile_number'             => 'required|max:10|min:10',
                'full_name'                 => 'required',
                'email_id'                  => 'required|email',
                'ogr_password'              => 'required',
     ),
    'changepassword' => array(
            'ogr_password' => 'required',
            'password' => 'required|same:re_password',
            're_password' => 'required',
     ),
 );

public static $messages = array(

                't_branch_details_id.required'    => 'Please Select Branch Name',
                't_organizations_id.required'    => 'Please Select Organization Name',
                'role_id.required'      => 'Please Select Role Name',
                'full_name.required'    => 'Enter Your Full Name',
                'email_id.required'     => 'Enter Your Email Id',
                'email_id.email'        => 'Enter valid email id',
                'ogr_password.required' => 'Enter Your Password',
                're_password.required'  => 'Enter Your Password',
                'mobile_number.required'=> 'Please Add Mobile Number',
                'mobile_number.max'     => 'Please Add 10 Digit Mobile Number',
                'mobile_number.min'     => 'Please Add 10 Digit Mobile Number',
                'password.confirmed'    => 'Password confirmation does not match.',
                're_password.same'      => 'Password Confirmation should match the Password',
);

}

