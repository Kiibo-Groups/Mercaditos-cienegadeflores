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
        'type',
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

    public function ExportData()
    {
        $orders = Mercaditos::OrderBy('id','asc')->skip(300)->limit(88)->get();
        $data   = [];

        foreach ($orders as $key) {
            
            $data[] = [
                'pic_profile' => public_path('upload/users/profile/'.$key->pic_profile),
                'pic_ine_front' => public_path('upload/users/credentials/'.$key->pic_credential),
                'pic_ine_back'  => public_path('upload/users/credentials/'.$key->pic_credential_back),
                'qr'    => $key->qr,
                'contribuyente' => $key->contribuyente,
                'giro' => $key->giro,
                'colonia' => (Colonies::find($key->colonies_id)) ? Colonies::find($key->colonies_id)->name : 'undefined', 
                'metros' => $key->metros,
                'costo' => $key->costo,
                'cuota' => $key->cuota,
                'extras' => $key->extras
            ];
        }

        return $data;
    }
}