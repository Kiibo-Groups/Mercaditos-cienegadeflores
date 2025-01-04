<?php

namespace App\Http\Controllers\Api;



use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BackServer; 

use Illuminate\Http\Request;
use Auth; 
use App\Models\Admin;
use App\Models\AppUser;
use App\Models\BDAssign; 
use App\Models\Colonies; 
use App\Models\Mercaditos;
use App\Models\OrdersMarket;
use App\Models\Perms;

use DB;
use Validator;
use Redirect;
use Excel;
use Stripe;

use QrCode;
use Uuid;

use DOMDocument;
use Carbon\Carbon;

class ApiController extends Controller
{

	public function welcome()
	{
		$res = new Slider;

		return response()->json(['data' => $res->getAppData()]);
	}

	public function getDataInit()
	{
		
		try {
			return response()->json([
				'admin'		=> Admin::find(1)
			]);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function homepage_init($user_id)
	{
		try {
			$assigns = BDAssign::where('app_user_id',$user_id)->get();
			$colonies = [];
			foreach ($assigns as $key) {
				$Cols = Colonies::find($key->colonies_id);
				  
				$colonies[] = [
					'id' 		=> $Cols->id,
					'name' 		=> $Cols->name,
					'direccion' => $Cols->direccion,
					'lat' 		=> $Cols->lat,
					'lng' 		=> $Cols->lng,
					'countMercs' => count(Mercaditos::where('colonies_id',$key->colonies_id)->get()),
					'mercados' 	=> Mercaditos::where('colonies_id',$key->colonies_id)->get()
				];
			}

			$data = [ 
				'assign'   => $assigns,
				'colonies' => $colonies
			];

			return response()->json(['data' => $data]);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}
 

	/**
     * Funciones de inicio de sesion y validacion de usuario
     */

	public function login(Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json($res->login($Request->all()));
		} catch (\Exception $th) {
			return response()->json(['msg' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function chkUser(Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json($res->chkUser($Request->all()));
		} catch (\Exception $th) {
			return response()->json(['msg' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function Newlogin(Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json($res->Newlogin($Request->all()));
		} catch (\Exception $th) {
			return response()->json(['msg' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function userinfo($id)
	{
		try { 
			$data	= AppUser::find($id);
			$exceptData = ['pswfacebook','created_at','updated_at','otp','refered'];
			// Cambiamos los datos de la imagen		
			$img_exp = $data->pic_profile;
			$dat     = collect($data)->except($exceptData)->except('pic_profile');
			$pic_profile = asset('upload/users/'.$img_exp);
			// Agregamos los nuevos datos
			$dat->put( 'pic_profile' , $pic_profile );
			
			return response()->json([
				'data' => $dat, 
			]);

			
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}
	
	public function updateInfo($id,Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json($res->updateInfo($Request->all(),$id));
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function updateLocation($lat, $lng, $user)
	{
		try {
			$info = AppUser::find($user);

			$info->lat = $lat;
			$info->lng = $lng;
			$info->save();

			return response()->json([
				'data' => $info,
				'status' => true 
			]);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function overview($user_id)
	{
		try {
			$req = new AppUser;
			return response()->json(['data' => $req->overview_app($user_id)]);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}	
	}

	/**
     * Funciones de registro
     */
	public function signup(Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json($res->addNew($Request->all()));
		} catch (\Exception $th) {
			return response()->json(['msg' => 'error', 'error' => $th->getMessage()]);
		}
	} 

	public function sendOTP(Request $Request)
	{
		$phone = $Request->phone;
		$hash  = $Request->hash;

		return response()->json(['otp' => app('App\Http\Controllers\Controller')->sendSms($phone, $hash)]);
	}

	public function SignPhone(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->SignPhone($Request->all()));
	}

	/**
	 * Funciones para conexiones de valor
	 */
	public function getUser($user)
	{
		try {
			$data = AppUser::where('id',$user)->withCount('userTo')->first();
			$exceptData = ['password','pswfacebook','created_at','updated_at','otp','refered'];
        
			$img_exp = $data->pic_profile;
            $dat     = collect($data)->except($exceptData)->except('pic_profile');
            $pic_profile = asset('upload/users/'.$img_exp);
            $newData = $dat->put( 'pic_profile' , $pic_profile );

			return response()->json([
				'data' => $newData
			]);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}
  
	public function search($query)
	{
		try {
			$req = new AppUser;
			return response()->json([
				'data' => $req->searchByUserName($query)
			]);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}
 
	/**
	 * Funciones para recepcion de datos del mercado
	 */
	public function addMarket(Request $Request)
	{
		try {
			$input = $Request->all();
			$lims_data_markets = new Mercaditos;

			$path = '/' . 'upload/users/';
			$path_file = "";

			if ($Request->has('pic_profile')) {
				$imagenBase64 = $Request->input('pic_profile');
				$path_file = 'profile/';
				
				$image = substr($imagenBase64, strpos($imagenBase64, ",")+1);
				$imagenDecodificada = base64_decode($image);	
				$imageName =  time() . '.png';
				file_put_contents(public_path($path . $path_file . $imageName), $imagenDecodificada);
			
				$input['pic_profile'] =  $imageName;
			}

			if ($Request->has('pic_credential_back')) {
				$pic_credential_back = $Request->input('pic_credential_back');
				$path_file = 'credentials/';
				
				$image_pic_credential_back = substr($pic_credential_back, strpos($pic_credential_back, ",")+1);
				$imagenDecodificada_pic_credential_back = base64_decode($image_pic_credential_back);	
				$imageName_pic_credential_back =  time() . '.png';
				file_put_contents(public_path($path . $path_file . $imageName_pic_credential_back), $imagenDecodificada_pic_credential_back);
			
				$input['pic_credential_back'] = $imageName_pic_credential_back;
			}

			if ($Request->has('pic_credential_front')) {
				$imagenBase64_pic_credential_front = $Request->input('pic_credential_front');
				$path_file = 'credentials/';
				
				$image_pic_credential_front = substr($imagenBase64_pic_credential_front, strpos($imagenBase64_pic_credential_front, ",")+1);
				$imagenDecodificada_pic_credential_front = base64_decode($image_pic_credential_front);	
				$imageName_pic_credential_front =  time() . '.png';
				file_put_contents(public_path($path . $path_file . $imageName_pic_credential_front), $imagenDecodificada_pic_credential_front);
			
				$input['pic_credential'] = $imageName_pic_credential_front;
			}


			$market = $lims_data_markets->create($input);

			// Generamos el QR
			$link_qr        = substr(md5($market->id),0,15);
			$codeQR         = base64_encode(QrCode::format('png')->size(200)->generate($link_qr));

			$market->qr_identy   = $codeQR;
			$market->save();

			return response()->json([
				'status' => true,
				'input' => $input,
				'data' => $market
			]);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function sendInfoMarket(Request $Request)
	{
		try {
			$input = $Request->all();
			$user_id = $input['app_user_id'];
			$market_id = $input['market_id'];

			$chk = OrdersMarket::where('app_user_id',$user_id)->where('market_id',$market_id)->OrderBy('created_at','DESC')->first();
			if ($chk) {
				// Calculamos los dias que han pasado
				$days = Carbon::parse($chk->created_at)->diff(Carbon::now())->format('%H');
 
				
				if ($days > 12) {
					$lims_data_orders = new OrdersMarket; 
					$ticket = $lims_data_orders->create($input);	
					return response()->json([
						'status' => true,
						'data' => $ticket
					]);
				}else {
					return response()->json([
						'status' => 'error',
						'data' => 'ticket_changed',
						'days' => $days
					]);
				}
			}else {
				$lims_data_orders = new OrdersMarket; 
				$ticket = $lims_data_orders->create($input);	
				return response()->json([
					'status' => true,
					'data' => $ticket
				]);
			}
		} catch (\Exception $th) {
			return response()->json(['status' => 'error', 'data' => $th->getMessage()]);
		}
	}

	public function sendInfoMarketPending(Request $Request)
	{
		try {
			$tickets = $Request->all();
			$data = [];
			foreach ($tickets as $input) {
				$user_id = $input['app_user_id'];
				$market_id = $input['market_id'];

				$chk = OrdersMarket::where('app_user_id',$user_id)->where('market_id',$market_id)->OrderBy('created_at','DESC')->first();
				if ($chk) {
					// Calculamos los dias que han pasado
					$days = Carbon::parse($chk->created_at)->diff(Carbon::now())->format('%d');
					if ($days > 1) {
						$lims_data_orders = new OrdersMarket; 
						$ticket = $lims_data_orders->create($input);	
						$data[] = $ticket; 
					}
				}else {
					$lims_data_orders = new OrdersMarket; 
					$ticket = $lims_data_orders->create($input);	
					$data[] = $ticket;
				}
			}

			return response()->json([
				'status' => true,
				'data' => 'tickets actualizados'
			]);
		} catch (\Exception $th) {
			return response()->json(['status' => 'error', 'data' => $th->getMessage()]);
		}
	}

	public function sendInfoOferentePending(Request $Request)
	{
		try {
			$oferentes = $Request->all();
			
			foreach ($oferentes as $input) { 
				$lims_data_markets = new Mercaditos; 
				$lims_data_markets->create($input);
			}

			return response()->json([
				'status' => true,
				'data' => 'Oferentes actualizados'
			]);
		} catch (\Exception $th) {
			return response()->json(['status' => 'error', 'data' => $th->getMessage()]);
		}
	}

	/**
	 * 
	 * Funciones para registro de permisos de alcohol
	 * 
	 */
	public function savePerms(Request $Request)
	{
		try {
			$input = $Request->all();
            $lims_data_perms = new Perms; 
            $perms = $lims_data_perms->create($input);

			return response()->json([
				'status' => true,
				'data' => $input
			]);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function chkMarketId($id)
	{
		try {
			$getMercs = Mercaditos::get();
			$merc = [];
			$flag = false;
			foreach ($getMercs as $key => $value) {
				
				if ($id == substr(md5($value->id),0,15)) {
					$merc = $value;
					$flag = true;
					break;
				}
			}

			if ($flag) {
				return response()->json([ 
					'status' => true,
					'data' => $merc
				]);
			}else {
				return response()->json([
					'status' => false,
					'data' => "Mercado no encontrado",
					'id'  => $id
				]);
			}

		} catch (\Exception $th) {
			return response()->json(['status' => false,'data' => 'error', 'error' => $th->getMessage()]);
		}
	}
}