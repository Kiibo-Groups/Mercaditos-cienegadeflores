<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Twilio\Rest\Client;

class BackServer extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 
     * Creaciones de valor para nuevas conexiones
     * 
    */

    function CreateConn($data)
    {
        return $this->CurlGet($data,"https://us-central1-venture-cafe-5f68f.cloudfunctions.net/app/api/CreateConn/");
    }

      
     
    /**
     * Realizamos la peticion
     */
    function CurlGet($fields,$url)
    {
        $fields = json_encode($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        $req = json_decode($response,true);

        return $req;
    }
}
