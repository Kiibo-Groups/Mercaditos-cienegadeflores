<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $table = 'settings'; 

    protected $fillable =[
        'ApiKey_google',  
        'stripe_api_id',
        'stripe_client_id',
        'comm_stripe',
        'id_openpay',
        'private_key_openpay',
        'public_key_openpay',
        'paypal_client_id',
        'paypal_secret'
    ];
}
