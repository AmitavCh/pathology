<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TState extends Model{

    protected $table = 't_states';
    public static $rules = array(
        'state_name' => 'required',
    );
    public static $messages = array(
        'state_name.required' => 'Please Add State Name',
    );

}
