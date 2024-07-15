<?php

namespace App\Models;

use App\Http\Controllers\Api\ApiController;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Mail;
use DB;

class BDAssign extends Authenticatable
{
    protected $table = 'bd_asign';

    protected $fillable =[
        'colonies_id',
        'mercaditos_id',
        'app_user_id'
    ];

    public function UsersBD()
    {
        return $this->hasMany('App\Models\AppUser')->orderBy('created_at');
    }

}