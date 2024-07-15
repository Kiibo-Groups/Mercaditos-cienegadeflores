<?php

namespace App\Models;

use App\Http\Controllers\Api\ApiController;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Mail;
use DB;

class Mercaditos extends Authenticatable
{
    protected $table = 'mercaditos';

    protected $fillable =[ 
        'qr_identy',
        'pic_profile',
        'pic_credential',
        'pic_credential_back',
        'giro',
        'contribuyente',
        'metros',
        'costo',
        'cuota',
        'horario',
        'colonies_id',
        'status'
    ];

    public function UsersBD()
    {
        return $this->hasMany('App\Models\BDAssign')->orderBy('created_at');
    }


    public function getColonie($id)
    {
        $name  = Colonies::where('id',$id)->first();

        if (isset($name)) {
            return $name->name;
        }else {
            return 'undefined';
        }
    }
}