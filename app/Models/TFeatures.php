<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TFeatures extends Model{

    protected $table = 't_features';
    public static $rules = array(
        'feature_name'     => 'required',
    );
    public static $messages = array(
        'feature_name.required'           => 'Please Add Feature Name',
    );

}
