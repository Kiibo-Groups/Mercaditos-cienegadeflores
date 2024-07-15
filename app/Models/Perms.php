<?php

namespace App\Models;

use App\Http\Controllers\Api\ApiController;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Mail;
use DB;

class Perms extends Authenticatable
{
    protected $table = 'perms_alcohol';

    protected $fillable =[
        'user_id',
        'colonie',
        'perm1',
        'perm2',
        'perm3',
        'perm4',
        'perm5',
        'perm6',
        'perm7',
        'perm8',
        'perm9',
        'perm10',
    ];
    
    public function getAll()
    {
        $orders = Perms::OrderBy('id','desc')->get();
        $data   = [];

        foreach ($orders as $key) {
            
            $data[] = [
                'id' => $key->id,
                'user' => (isset(AppUser::find($key->user_id)->id)) ? AppUser::find($key->user_id)->name.' '.AppUser::find($key->user_id)->last_name : "Undefined",
                'colonie' => Colonies::find($key->colonie)->name, 
                'perm1'   => ($key->perm1) ? "SI" : "NO", 
                'perm2'   => ($key->perm2) ? "SI" : "NO", 
                'perm3'   => ($key->perm3) ? "SI" : "NO", 
                'perm4'   => ($key->perm4) ? "SI" : "NO", 
                'perm5'   => ($key->perm5) ? "SI" : "NO", 
                'perm6'   => ($key->perm6) ? "SI" : "NO", 
                'perm7'   => ($key->perm7) ? "SI" : "NO", 
                'perm8'   => ($key->perm8) ? "SI" : "NO", 
                'perm9'   => ($key->perm9) ? "SI" : "NO", 
                'perm10'   => ($key->perm10) ? "SI" : "NO",
            ];
        }

        return $data;
    }
}