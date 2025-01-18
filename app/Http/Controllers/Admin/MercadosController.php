<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Exports\OferentExport;

use App\Models\Mercaditos;  
use App\Models\Colonies;  
use App\Models\Admin;

use DB;
use Validator;
use Redirect;
use IMS;
use Excel;

use QrCode;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class MercadosController extends Controller
{
    public $folder  = "admin/mercaditos.";
    public $subFolder = "admin/comercios.";
    /**
     * Display a listing of the resource.
     * 
     */
    public function index()
    {
        // return response()->json([
        //     'data' => Mercaditos::OrderBy('id','DESC')->with('UsersBD')->paginate(10),
        // ]);
        
        return View($this->folder.'index',[
            'data' => Mercaditos::OrderBy('id','DESC')->whereType(0)->with('UsersBD')->paginate(10),
            'req'  => new Mercaditos,
            'link' => '/mercaditos/'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 
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
        
        $reader = new Xlsx();
        $spreadsheet = $reader->load($data['file']);
        $sheet = $spreadsheet->getActiveSheet();

        $drawings = $sheet->getDrawingCollection();
       
        $pic_profile = "upload/users/profile/";
        $pic_front   = "upload/users/credentials/";
        $pic_back    = "upload/users/credentials/";
        
        $row_A = [];
        $row_B = [];
        $row_C = [];

        foreach ($drawings as $drawing) {
            $splitCoords = str_split($drawing->getCoordinates());
            $drawin_path = $drawing->getPath();
            $extension    = pathinfo($drawing->getPath(), PATHINFO_EXTENSION);
            switch ($splitCoords[0]) {
                case 'A':
                    $row_A[] = $drawing->getHashCode().'.png';
                    $img_url = $pic_profile.$drawing->getHashCode().".{$extension}";
                    break;
                case 'B':
                    $row_B[] = $drawing->getHashCode().'.png';
                    $img_url = $pic_front.$drawing->getHashCode().".{$extension}";
                    break;
                case 'C':
                    $row_C[] = $drawing->getHashCode().'.png';
                    $img_url = $pic_back.$drawing->getHashCode().".{$extension}";
                    break;
            }

            $img_path = public_path($img_url);
            $contents = file_get_contents($drawin_path);
            file_put_contents($img_path, $contents);

            $coordinates = [ 
                'row_A' => $row_A,
                'row_B' => $row_B,
                'row_C' => $row_C,
            ];
        } 

        $array = Excel::toArray(new Mercaditos, $data['file']);
        $i = 0;
        $input = []; 

        foreach($array[0] as $a)
        {
            $i++; 
            if($i > 1)
            {
                 
                     
                    $contribuyente          = $a[3];
                    $giro                   = $a[4];
                    $colonia                = $a[5];
                    $metros                 = $a[6];
                    $costo                  = $a[7];
                    $cuota                  = $a[8];
                    $horario                = $a[9];

                    $lims_new_mercados              = new Mercaditos;
                    $input['pic_profile']           = $row_A[$i-2];
                    $input['pic_credential']        = $row_B[$i-2];
                    $input['pic_credential_back']   = $row_C[$i-2];
                    $input['giro']          = ($giro) ? $giro : 'INDEFINIDO';
                    $input['contribuyente'] = ($contribuyente) ? $contribuyente : 'INDEFINIDO';
                    $input['metros']        = ($metros) ? $metros : 0;
                    $input['costo']         = ($costo) ? $costo : 0;
                    $input['cuota']         = ($cuota) ? $cuota : 0;
                    $input['horario']       = ($horario == 'mañana') ? 0 : 1;
                    $input['colonies_id']   = 0;
                    $input['status']        = 0;

                    
                    // Validamos el ID de la colonia
                    $colonieId = Colonies::where('name',$colonia)->first();
                    // Si existe la colonia obtenemos el ID y Registramos el mercado
                    if ($colonieId) {
                        // Validamos que no exista este contribuyente en la misma colonia
                        $chkName = Mercaditos::where('contribuyente',$contribuyente)->where('colonies_id', $colonieId->id)->first();
                        if (!$chkName) { // Si no existe registramos
                            $input['colonies_id'] = $colonieId->id;
                            $user = $lims_new_mercados->create($input);
                            // Generamos el QR
                            $link_qr        = substr(md5($user->id),0,15);
                            $codeQR         = base64_encode(QrCode::format('png')->size(200)->generate($link_qr));
                            $user->qr_identy   = $codeQR;
                            $user->save();
                        }
                    }
            }
        }
 
		return redirect('/mercaditos')->with('message','Archivo subido con exito.');
	}

    public function export()
    {
        return Excel::download(new OferentExport, 'report.xlsx');
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

    /*
	|---------------------------------------------
	| Funciones de Mercados
	|--------------------------------------------
	*/
    public function index_comercios()
    {
        return View($this->subFolder.'index',[
            'data' => Mercaditos::OrderBy('id','DESC')->whereType(1)->with('UsersBD')->paginate(10),
            'req'  => new Mercaditos,
            'link' => '/comercios/'
        ]);
    }

    public function create_commerce()
    {
        return View($this->subFolder.'add',[
			'data' =>  new Mercaditos,
            'colonias' => Colonies::get(),
            'form_url' 	=> '/comercios'
		]);
    }

    public function create_comercios(Request $request)
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
  

		return redirect('/comercios')->with('message','Nuevo elemento creado...');
    }

    public function edit_commerce($id)
    {
        return View($this->subFolder.'edit',[
			'data' 		=> Mercaditos::find($id),
			'form_url' 	=> '/comercios/'.$id,
            'colonias'  => Colonies::get(),
		]);
    }

    public function _edit_commerce(Request $request, $id)
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

		return redirect('/comercios')->with('message','Elemento actualizado con éxito...');
    }

    public function delete_comercios($id)
	{
		$res = Mercaditos::find($id);
		$res->delete();

        @unlink("public/upload/users/profile/".$res->pic_profile);
        @unlink("public/upload/users/credentials/".$res->pic_credential);
		return redirect('/comercios')->with('message','Registro eliminado con éxito.');
	}
    
    public function status_comercios($id)
	{
		$res 			= Mercaditos::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect('/comercios')->with('message','Estado actualizado con éxito.');
	}
    public function import_commerce()
	{
		return View($this->folder.'import',[ 
			'form_url' 	=> '/comercios/import',
		]);
	}

    public function _import_commerce(Request $request)
	{
        $data = $request->all();
        
        $reader = new Xlsx();
        $spreadsheet = $reader->load($data['file']);
        $sheet = $spreadsheet->getActiveSheet();

        $drawings = $sheet->getDrawingCollection();
       
        $pic_profile = "upload/users/profile/";
        $pic_front   = "upload/users/credentials/";
        $pic_back    = "upload/users/credentials/";
        
        $row_A = [];
        $row_B = [];
        $row_C = [];

        foreach ($drawings as $drawing) {
            $splitCoords = str_split($drawing->getCoordinates());
            $drawin_path = $drawing->getPath();
            $extension    = pathinfo($drawing->getPath(), PATHINFO_EXTENSION);
            switch ($splitCoords[0]) {
                case 'A':
                    $row_A[] = $drawing->getHashCode().'.png';
                    $img_url = $pic_profile.$drawing->getHashCode().".{$extension}";
                    break;
                case 'B':
                    $row_B[] = $drawing->getHashCode().'.png';
                    $img_url = $pic_front.$drawing->getHashCode().".{$extension}";
                    break;
                case 'C':
                    $row_C[] = $drawing->getHashCode().'.png';
                    $img_url = $pic_back.$drawing->getHashCode().".{$extension}";
                    break;
            }

            $img_path = public_path($img_url);
            $contents = file_get_contents($drawin_path);
            file_put_contents($img_path, $contents);

            $coordinates = [ 
                'row_A' => $row_A,
                'row_B' => $row_B,
                'row_C' => $row_C,
            ];
        } 

        $array = Excel::toArray(new Mercaditos, $data['file']);
        $i = 0;
        $input = []; 

        foreach($array[0] as $a)
        {
            $i++; 
            if($i > 1)
            {
                 
                     
                    $contribuyente          = $a[3];
                    $giro                   = $a[4];
                    $colonia                = $a[5];
                    $metros                 = $a[6];
                    $costo                  = $a[7];
                    $cuota                  = $a[8];
                    $horario                = $a[9];

                    $lims_new_mercados              = new Mercaditos;
                    $input['pic_profile']           = $row_A[$i-2];
                    $input['pic_credential']        = $row_B[$i-2];
                    $input['pic_credential_back']   = $row_C[$i-2];
                    $input['giro']          = ($giro) ? $giro : 'INDEFINIDO';
                    $input['contribuyente'] = ($contribuyente) ? $contribuyente : 'INDEFINIDO';
                    $input['metros']        = 0;
                    $input['costo']         = ($costo) ? $costo : 0;
                    $input['cuota']         = ($cuota) ? $cuota : 0;
                    $input['horario']       = ($horario == 'mañana') ? 0 : 1;
                    $input['colonies_id']   = 0;
                    $input['type']        = 1;
                    $input['status']        = 0;

                    
                    // Validamos el ID de la colonia
                    $colonieId = Colonies::where('name',$colonia)->first();
                    // Si existe la colonia obtenemos el ID y Registramos el mercado
                    if ($colonieId) {
                        // Validamos que no exista este contribuyente en la misma colonia
                        $chkName = Mercaditos::where('contribuyente',$contribuyente)->whereType(1)->where('colonies_id', $colonieId->id)->first();
                        if (!$chkName) { // Si no existe registramos
                            $input['colonies_id'] = $colonieId->id;
                            $user = $lims_new_mercados->create($input);
                            // Generamos el QR
                            $link_qr        = substr(md5($user->id),0,15);
                            $codeQR         = base64_encode(QrCode::format('png')->size(200)->generate($link_qr));
                            $user->qr_identy   = $codeQR;
                            $user->save();
                        }
                    }
            }
        }
 
		return redirect('/comercios')->with('message','Archivo subido con exito.');
	}
}
