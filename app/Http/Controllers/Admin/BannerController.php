<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Banner;  
use App\Models\Admin;

use DB;
use Validator;
use Redirect;
use IMS;
class BannerController extends Controller {

	public $folder  = "admin/banner.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{			
		return View($this->folder.'index',[
			'data' 	=> Banner::get(),
			'ban'	=> new Banner,
			'link' 	=> '/banner/'
		]);
	}	
	
	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{	
		return View($this->folder.'add',[
			'data' 		=> new Banner,
			'form_url' 	=> '/banner'
		]);
	}
	
	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{			
		$data = new Banner;	
		
		$data->addNew($Request->all(),"add");
		
		return redirect('/banner')->with('message','New Record Added Successfully.');
	}
	
	/*
	|---------------------------------------
	|@Edit Page 
	|---------------------------------------
	*/
	public function edit($id)
	{				
		return View($this->folder.'edit',[
			'data' 		=> Banner::find($id),
			'form_url' 	=> '/banner/'.$id
		]);
	}
	
	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{	
		$data = new Banner;
		$data->addNew($Request->all(),$id);	
		return redirect('/banner')->with('message','Registro actualizado con éxito.');
	}
	
	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		$res = Banner::find($id);
		unlink("upload/banner/".$res->img);
		$res->delete();
		return redirect('/banner')->with('message','Registro eliminado con éxito.');
	}

	/*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= Banner::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect('/banner')->with('message','Estado actualizado con éxito.');
	}
}