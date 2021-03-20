<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TCities extends Model{

    protected $table = 't_cities';
    public static $rules = array(
        't_states_id' => 'required',
        'city_name' => 'required',
    );
    public static $messages = array(
        't_states_id.required' => 'Please Select State Name',
        'city_name.required' => 'Please Add City Name',
    );

}
