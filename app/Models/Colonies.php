<?php

namespace App\Models;

use App\Http\Controllers\Api\ApiController;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Mail;
use DB;
use Excel;

class Colonies extends Authenticatable
{
    protected $table = 'colonies';

    protected $fillable =[
        'name',
        'direccion',
        'lat',
        'lng',
        'status'
    ];
 
    public function Mercaditos()
    {
        return $this->hasMany('App\Models\Mercaditos')->orderBy('created_at');
    }
 

    public function getAssignCols($id)
    {
        return BDAssign::where('app_user_id',$id)->pluck('colonies_id')->toArray();
    }
}