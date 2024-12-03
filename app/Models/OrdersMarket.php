<?php

namespace App\Models;

use App\Http\Controllers\Api\ApiController;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Mail;
use DB;

class OrdersMarket extends Authenticatable
{
    protected $table = 'order_market';

    protected $fillable =[ 
        'app_user_id',
        'colonie_id',
        'market_id',
        'contribuyente',
        'giro',
        'metros',
        'costo',
        'cuota',
        'extras',
        'identifier'
    ];
    
    public function getAll()
    {
        $orders = OrdersMarket::OrderBy('created_at','DESC')->get();
        $data   = [];

        foreach ($orders as $key) {
            
            $data[] = [
                'id' => $key->id,
                'user' => (AppUser::find($key->app_user_id)) ? AppUser::find($key->app_user_id)->name.' '.AppUser::find($key->app_user_id)->last_name : 'N/A',
                'colonie' => Colonies::find($key->colonie_id)->name, 
                'contribuyente' => $key->contribuyente,
                'giro' => $key->giro,
                'metros' => $key->metros,
                'costo' => $key->costo,
                'cuota' => $key->cuota,
                'extras' => $key->extras,
                'date'   => $key->created_at->format('Y-m-d'),
            ];
        }

        return $data;
    }

}