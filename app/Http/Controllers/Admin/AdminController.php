<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Admin; 
use App\Models\Settings;

use DB;
use Auth;
use Validator;
use Redirect;
class AdminController extends Controller
{
    
    public $folder = "admin.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View($this->folder.'index',[
			'form_url' => Asset(env('admin').'/login'),
		]);
    }

    /*
	|------------------------------------------------------------------
	|Login attempt,check username & password
	|------------------------------------------------------------------
	*/
	public function login(Request $request)
	{
		$username = $request->input('username');
        $password = $request->input('password');

        // return response()->json(['username' => $username, 'password' => $password]);

		if (Auth::attempt(['username' => $username, 'password' => $password]))
		{
			return Redirect::to(env('admin').'/dash')->with('message', 'Bienvenido(a) ! Estás conectado ahora.');
		}
		else
		{
			return Redirect::to(env('admin').'/login')->with('error', 'username')->withInput(["message", "Credenciales incorrectas."]);
		}
	}

    /**
     * View profile admin to update
     *
     * @return \Illuminate\Http\Response
     */
    public function perfil_s()
    {
        $data = Admin::find(Admin::find(Auth::user()->id))->first();  
        
        // return response()->json(['data' => Auth::user()]);

        return view($this->folder.'dashboard.profile', [ 
            'data' => $data,
            'ApiKey_google' => Settings::findOrFail(1)->ApiKey_google,
            'form_url'	=> Asset(env('admin').'/profile'),
        ]); 
    }  
 

    /*
	|------------------------------------------------------------------
	|Homepage, Dashboard
	|------------------------------------------------------------------
	*/
	public function home()
	{ 

		$admin = new Admin; 
        

        // return response()->json([
        //     'overview' => $admin->overview(),
        //     'chartUsersSign' => [
        //         'month' => $admin->getMonthName(0),
        //         'data' => $admin->chartUsersSign(1)['online']],
        //     'admin' => $admin
        // ]);

		return View($this->folder.'dashboard.home',[
            'overview' => $admin->overview(), 
            'admin' => $admin,
            'ApiKey' => Settings::findOrFail(1)->ApiKey_google,
        ]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    { 
        $data = Settings::find(1);  
        
        return view($this->folder.'dashboard.setting', [ 
            'data' => $data,
            'form_url' => Asset(env('admin').'/settings'),
            'admin' => Auth::user()
        ]); 
    }

    public function settings_update(Request $request)
    {
        try {
            $input = $request->all();
            $lims_settings_data = Settings::find(1)->first();
            $lims_settings_data->update($input);
            
            return redirect(env('admin').'/settings')->with('message', 'Configuración actualizada con éxito ...');
        } catch (\Exception $th) {
            return redirect(env('admin').'/settings')->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return response()->json(['data' => $request->all()]);
        
        $image = $request->logo;
        $input = $request->except('logo');
        $lims_profile_data = Admin::find(Auth::user()->id)->first();

        if ($image) {
            // Verificamos si ya tenia una imagen anterior
            // if ($lims_profile_data->logo != NULL) { 
            //     unlink('public/profile/img/logo/'.$lims_profile_data->logo);
            // }

            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = date("Ymdhis");
            $imageName = $imageName . '.' . $ext;
            $image->move('public/profile/img/logo', $imageName);

            $input['logo'] = $imageName;
        } 

        if (isset($input['page_settings']) && $input['page_settings'] == 1) {
            if (isset($input['newPassword']) && $input['newPassword'] != '') {
                $input['shw_password'] = $input['newPassword'];
                $input['password'] = bcrypt($input['newPassword']);
            }else {
                $input['shw_password'] = $input['password'];
                $input['password'] = bcrypt($input['password']);
            }
        }

        $lims_profile_data->update($input);
        
        return redirect(env('admin').'/profile')->with('message', 'Cuenta actualizada  actualizada con éxito...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*
	|------------------------------------------------------------------
	|Logout
	|------------------------------------------------------------------
	*/
	public function logout()
	{
		Auth::logout();

		return Redirect::to(env('admin').'/login')->with('message', 'Logout Successfully !');
	}
}
