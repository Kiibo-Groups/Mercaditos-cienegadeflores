<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\UsersExportCaja;
use Illuminate\Http\Request;
use Auth;
use App\Models\AppUser;  
use App\Models\Colonies; 
use App\Models\OrdersMarket;
use App\Models\Mercaditos;
use App\Models\BDAssign;
use App\Models\Admin;

use DB;
use Validator;
use Redirect;
use IMS;
use Excel;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
class AppUserController extends Controller
{
    public $folder  = "admin/users.";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View($this->folder.'index',[
            'data' => AppUser::OrderBy('id','DESC')->with('assigns')->withCount('cobros')->get(),
            'req' => new AppUser,
            'link' => '/users/'
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
			'data' =>  new AppUser,
            'coloniesAssign' => [],
            'colonias' => Colonies::get(),
            'req' => new AppUser,
            'form_url' 	=> '/users'
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

        // Creamos el usuario
        $lim_user_data = new AppUser;
        $data = $request->all();
        $user = $lim_user_data->create($data);
        
        // Asignamos las colonias.
        $lims_assign_data = new BDAssign;
        foreach ($request->get('colonies_id') as $key) {
            $input = [
                'colonies_id' => $key,
                'app_user_id' => $user->id
            ];

            $lims_assign_data->create($input);
        }


        // Respondemos
		return redirect('/users')->with('message','Nuevo elemento creado...');
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
        $cols = new Colonies;
        return View($this->folder.'edit',[
			'data' 		=> AppUser::find($id),
            'colonias' => Colonies::get(),
            'coloniesAssign' => $cols->getAssignCols($id),
            'req' => new AppUser,
			'form_url' 	=> '/users/'.$id
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
        $lim_user_data = AppUser::find($id); 
        $lim_user_data->update($request->all()); 

        // Asignamos las colonias.
        $chkbdAssign = BDAssign::where('app_user_id',$id);

        if ($chkbdAssign) {
            $chkbdAssign->delete();   
        }
 
        $lims_assign_data = new BDAssign;
        foreach ($request->get('colonies_id') as $key) {
            $input = [
                'colonies_id' => $key,
                'app_user_id' => $id
            ];

            $lims_assign_data->create($input);
        }
            
		return redirect('/users')->with('message','Elemento actualizado con éxito...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
	{
		$res = AppUser::find($id);
		$res->delete(); 
		return redirect('/users')->with('message','Registro eliminado con éxito.');
	}

   /*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= AppUser::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect('/users')->with('message','Estado actualizado con éxito.');
	}


   /*
	|---------------------------------------------
	|@Reports User
	|---------------------------------------------
	*/
    public function reports(Request $request)
    {
        // return Excel::download(new UsersExportCaja, 'corte_caja.pdf');

        $res = new AppUser;
        $data = $res->CorteCaja($request->get('user_id'));

        // return response()->json(['data' => $data ,'req' => $request->get('user_id')]);

        $pdf = PDF::loadView('admin.reports.reportCaja', $data);
		$pdf->render();
		return response($pdf->output(), 200, [
			'Content-Type' => 'application/pdf'
		]);
    }

    
}