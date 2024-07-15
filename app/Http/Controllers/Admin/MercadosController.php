<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Mercaditos;  
use App\Models\Colonies;  
use App\Models\Admin;

use DB;
use Validator;
use Redirect;
use IMS;
use Excel;

use QrCode;
class MercadosController extends Controller
{
    public $folder  = "admin/mercaditos.";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json([
        //     'data' => Mercaditos::OrderBy('id','DESC')->with('UsersBD')->paginate(10),
        // ]);
        
        return View($this->folder.'index',[
            'data' => Mercaditos::OrderBy('id','DESC')->with('UsersBD')->paginate(10),
            'req'  => new Mercaditos,
            'link' => '/mercaditos/'
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
			'data' =>  new Mercaditos,
            'colonias' => Colonies::get(),
            'form_url' 	=> '/mercaditos'
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
        $lim_user_data = new Mercaditos;
        $data = $request->all();
        
         // Guardamos las imagenes
         if(isset($data['pic_profile']))
         {
            $filename   = time().rand(111,699).'.' .$data['pic_profile']->getClientOriginalExtension(); 
            $data['pic_profile']->move("public/upload/users/profile/", $filename);   
            $data['pic_profile'] = $filename;   
         }
 
         // Guardamos las imagenes
         if(isset($data['pic_credential']))
         {
            $filename   = time().rand(111,699).'.' .$data['pic_credential']->getClientOriginalExtension(); 
            $data['pic_credential']->move("public/upload/users/credentials/", $filename);   
            $data['pic_credential'] = $filename;   
         }

         // Guardamos las imagenes
         if(isset($data['pic_credential_back']))
         {
            $filename   = time().rand(111,699).'.' .$data['pic_credential_back']->getClientOriginalExtension(); 
            $data['pic_credential_back']->move("public/upload/users/credentials/", $filename);   
            $data['pic_credential_back'] = $filename;   
         }
 
         $user = $lim_user_data->create($data);
          
         // Generamos el QR
         $link_qr        = substr(md5($user->id),0,15);
         $codeQR         = base64_encode(QrCode::format('png')->size(200)->generate($link_qr));
 
         $user->qr_identy   = $codeQR;
         $user->save();
  

		return redirect('/mercaditos')->with('message','Nuevo elemento creado...');
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
			'data' 		=> Mercaditos::find($id),
			'form_url' 	=> '/mercaditos/'.$id,
            'colonias'  => Colonies::get(),
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
        $lim_user_data = Mercaditos::find($id);
        $data = $request->all();
        
        // Guardamos las imagenes
        if(isset($data['pic_profile']))
        {
            // Eliminamos imagen anterior
            @unlink("public/upload/users/profile/".$lim_user_data->pic_profile);

            $filename   = time().rand(111,699).'.' .$data['pic_profile']->getClientOriginalExtension(); 
            $data['pic_profile']->move("public/upload/users/profile/", $filename);   
            $data['pic_profile'] = $filename;   
        }

        // Guardamos las imagenes
        if(isset($data['pic_credential']))
        {
            // Eliminamos imagen anterior
            @unlink("public/upload/users/credentials/".$lim_user_data->pic_credential);

            $filename   = time().rand(111,699).'.' .$data['pic_credential']->getClientOriginalExtension(); 
            $data['pic_credential']->move("public/upload/users/credentials/", $filename);   
            $data['pic_credential'] = $filename;   
        }

        // Guardamos las imagenes
        if(isset($data['pic_credential_back']))
        {
            // Eliminamos imagen anterior
            @unlink("public/upload/users/credentials/".$lim_user_data->pic_credential_back);

            $filename   = time().rand(111,699).'.' .$data['pic_credential_back']->getClientOriginalExtension(); 
            $data['pic_credential_back']->move("public/upload/users/credentials/", $filename);   
            $data['pic_credential_back'] = $filename;   
        }

        // Generamos el QR
        $link_qr        = substr(md5($id),0,15);
        $codeQR         = base64_encode(QrCode::format('png')->size(200)->generate($link_qr));
        $data['qr_identy']   = $codeQR; 
 
         
        $lim_user_data->update($data);

		return redirect('/mercaditos')->with('message','Elemento actualizado con éxito...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
	{
		$res = Mercaditos::find($id);
		$res->delete();

        @unlink("public/upload/users/profile/".$res->pic_profile);
        @unlink("public/upload/users/credentials/".$res->pic_credential);
		return redirect('/mercaditos')->with('message','Registro eliminado con éxito.');
	}

   /*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= Mercaditos::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect('/mercaditos')->with('message','Estado actualizado con éxito.');
	}

    /*
	|---------------------------------------------
	|@Import Colonies CSV
	|---------------------------------------------
	*/
	public function import()
	{
		return View($this->folder.'import',[ 
			'form_url' 	=> '/mercaditos/import',
		]);
	}

    public function _import(Request $request)
	{
        $data = $request->all();
       
        $array = Excel::toArray(new Mercaditos, $data['file']);
        $i = 0;
        $input = [];
        foreach($array[0] as $a)
        {
            $i++; 
            if($i > 1)
            {
                if ($a[1] != null) { 
                    $colonia                = $a[0];
                    $giro                   = $a[1];
                    $contribuyente          = $a[2];
                    $metros                 = $a[3];
                    $costo                  = $a[4];
                    $cuota                  = $a[5];
                    $horario                = $a[6];

                    $lims_new_mercados      = new Mercaditos;
                    $input['giro']          = ($giro) ? $giro : 'INDEFINIDO';
                    $input['contribuyente'] = ($contribuyente) ? $contribuyente : 'INDEFINIDO';
                    $input['metros']        = ($metros) ? $metros : 0;
                    $input['costo']         = ($costo) ? $costo : 0;
                    $input['cuota']         = ($cuota) ? $cuota : 0;
                    $input['horario']       = ($horario == 'mañana') ? 0 : 1;
                    $input['colonies_id']   = 0;
                    $input['status']        = 0;

                    // Validamos que no exista este contribuyente
                    $chkName = Mercaditos::where('contribuyente',$contribuyente)->first();
                    if (!$chkName) { // Si no existe registramos
                        // Validamos el ID de la colonia
                        $colonieId = Colonies::where('name',$colonia)->first();
                        // Si existe la colonia obtenemos el ID y Registramos el mercado
                        if ($colonieId) {
                            $input['colonies_id'] = $colonieId->id;
                            $lims_new_mercados->create($input);
                        }
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

    /*
	|---------------------------------------------
	| Vista de codigos QR
	|--------------------------------------------
	*/
	
	public function viewqr($id)
	{ 
		return View($this->folder.'viewqr',[
			'data' 		=> AppUser::find($id),
		]);
	}
}
