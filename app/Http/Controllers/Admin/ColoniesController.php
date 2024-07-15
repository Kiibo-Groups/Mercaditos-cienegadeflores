<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\Colonies;  
use App\Models\Admin;
use App\Models\Settings;

use DB;
use Validator;
use Redirect;
use IMS;
use Excel;
class ColoniesController extends Controller
{
    public $folder  = "admin/colonies.";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View($this->folder.'index',[
            'data' => Colonies::OrderBy('id','DESC')->with('Mercaditos')->get(),
			'link' => '/colonies/'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View($this->folder.'add',[
			'data' =>  new Colonies,
            'form_url' 	=> '/colonies',
            'ApiKey' => Settings::find(1)->ApiKey_google
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lim_user_data = new Colonies;
        $lim_user_data->create($request->all());
        
		return redirect('/colonies')->with('message','Nuevo elemento creado...');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return View($this->folder.'edit',[
			'data' 		=> Colonies::find($id),
			'form_url' 	=> '/colonies/'.$id,
            'ApiKey' => Settings::find(1)->ApiKey_google
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lim_user_data = Colonies::find($id);
        $lim_user_data->update($request->all());
        
		return redirect('/colonies')->with('message','Elemento actualizado con éxito...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
	{
		$res = Colonies::find($id);
		$res->delete();
		return redirect('/colonies')->with('message','Registro eliminado con éxito.');
	}

   /*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= Colonies::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect('/colonies')->with('message','Estado actualizado con éxito.');
	}

    /*
	|---------------------------------------------
	|@Import Colonies CSV
	|---------------------------------------------
	*/
	public function import()
	{
		return View($this->folder.'import',[ 
			'form_url' 	=> '/colonies/import',
		]);
	}

    public function _import(Request $request)
	{
        $data = $request->all();
       
        $array = Excel::toArray(new Colonies, $data['file']);
        $i = 0;
        $input = [];
        foreach($array[0] as $a)
        {
            $i++; 
            if($i > 1)
            {
                if ($a[1] != null) { 
                    $name                   = $a[2];
                    $lat                    = $a[0];
                    $lng                    = $a[1];
                    $lims_new_col           = new Colonies;
                    $input['name']          = $name;
                    $input['direccion']     = 'indefinido';
                    $input['lat']           = $lat;
                    $input['lng']           = $lng;
                    $input['status']        = 0;

                    // Validamos que esta colonia no exista ya
                    $chkName = Colonies::where('name',$name)->first();
                    if (!$chkName) { // Si no existe registramos

                        // Obtenemos la direccion en base a las coordenadas
                        /**
                         * https://maps.googleapis.com/maps/api/geocode/json?latlng=25.7145744342024,-100.383836006041&key=AIzaSyBt88s4PDl1avfe-K5SKaPSp7RedjibLUw
                         */
                        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&key=".Settings::find(1)->ApiKey_google;
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_URL,$url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $output = curl_exec ($ch);
                        $info = curl_getinfo($ch);
                        $http_result = $info ['http_code'];
                        curl_close ($ch);
                    
                        $req_google = json_decode($output, true);
                        if ($req_google['status'] == "OK") {
                            $input['direccion'] = $req_google['results'][0]['formatted_address'];
                        }
                        // Guardamos
                        $lims_new_col->create($input);
                    }  
                }
            }
        }

        // return response()->json([ 
        //     'status' => true,
        //     'data' => $input
        // ]);

		return Redirect::back()->with('message','Archivo subido con exito.');
	}

    public function getColonies()
    {
        try {
            $data = Colonies::get();
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'status' => false,
                'data' => [],
                'error' => $th->getMessage()
            ]);
        }
    }
}