<?php

namespace App\Models;

use App\Http\Controllers\Api\ApiController;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Mail;
use DB;

class AppUser extends Authenticatable
{
    protected $table = 'app_user';

    protected $fillable =[
        'status',
        'name',
        'email',
        'last_name',
        'password',
        'pswfacebook',
        'phone',
        'otp',
        'lat',
        'lng'
    ];
 
    public function assigns()
    {
        return $this->hasMany('App\Models\BDAssign')->orderBy('created_at');
    }

    public function cobros()
    {
        return $this->hasMany('App\Models\OrdersMarket')->orderBy('created_at');
    }
  
    public function addNew($data)
    {
        $count = AppUser::where('email', $data['email'])->count();

        if ($count == 0) {
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

                $count_email = AppUser::where('email', $data['email'])->count();

                if ($count_email == 0) {
                    $add                = new AppUser;
                    $add->name          = ucwords($data['name']);
                    $add->last_name     = isset($data['last_name']) ? ucwords($data['last_name']) : 'null';
                    $add->email         = $data['email'];
                    $add->phone         = isset($data['phone']) ? $data['phone'] : 'null';
                    $add->password      = $data['password'];
                    $add->pswfacebook   = isset($data['pswfb']) ? $data['pswfb'] : 0;
                   
                    $add->save();

                    return ['msg' => 'done', 'user_id' => $add->id];
                } else {
                    return ['msg' => 'Opps! Este User Name  ya existe.'];
                }
            } else {
                return ['msg' => 'Opps! El Formato del Email es invalido'];
            }
        } else {
            return ['msg' => 'Opps! Este correo electrónico ya existe.'];
        }
    }
 
    public function chkUser($data)
    {

        if (isset($data['user_id']) && $data['user_id'] != 'null') {
            // Intentamos con el id
            $res = AppUser::find($data['user_id']);

            if (isset($res->id)) {
                return ['msg' => 'user_exist', 'id' => $res->id, 'data' => $res,'role' => 'user'];
            } else {
                return ['msg' => 'not_exist'];
            }
        }
    }

    public function SignPhone($data)
    {
        $res = AppUser::where('id', $data['user_id'])->first();

        if ($res->id) {
            $res->phone = $data['phone'];
            $res->save();

            $return = ['msg' => 'done', 'user_id' => $res->id];
        } else {
            $return = ['msg' => 'error', 'error' => '¡Lo siento! Algo salió mal.'];
        }

        return $return;
    }

    public function login($data)
    {
        $chk = AppUser::where('email', $data['email'])->first();

        $msg = "Detalles de acceso incorrectos";
        $user = 0;
        if (isset($chk->id)) // Validamos si existe el email
        {
            if ($chk->password == $data['password']) { // Validamos la contraseña
                $msg = 'done';
                $user = $chk->id;
            }
        }


        return ['msg' => $msg, 'user_id' => $user];
    }

    public function Newlogin($data)
    {
        $chk = AppUser::where('phone', $data['phone'])->first();

        if (isset($chk->id)) {
            return ['msg' => 'done', 'user_id' => $chk->id];
        } else {
            return ['msg' => 'error', 'error' => 'not_exist'];
        }
    }

    public function loginfb($data)
    {
        $chk = AppUser::where('email', $data['email'])->first();

        if (isset($chk->id)) {
            if ($chk->password == $data['password']) {
                // Esta logeado con facebook
                return ['msg' => 'done', 'user_id' => $chk->id];
            } else {
                // Esta logeado normal pero si existe se registra el FB - ID
                $chk->pswfacebook = $data['password'];
                $chk->save();
                // Registramos
                return ['msg' => 'done', 'user_id' => $chk->id];
            }
        } else {
            return ['msg' => 'Opps! Detalles de acceso incorrectos'];
        }
    }
 
    public function updateInfo($data, $id)
    {
        $count = AppUser::where('id',$id)->count();

        if ($count >= 1) {
            $add                = AppUser::find($id);
            $add->name          = $data['name'];
            $add->last_name     = $data['last_name'];
            $add->email         = $data['email']; 
            $add->phone         = $data['phone'];

            if (isset($data['password'])) {
                $add->password    = $data['password'];
            }

        
            $add->save();

            return ['msg' => 'done', 'user_id' => $add->id, 'data' => $add];
        } else {
            return ['msg' => 'Opps! Este correo electrónico ya existe.'];
        }
    }

    public function forgot($data)
    {
        $res = AppUser::where('email', $data['email'])->first();

        if (isset($res->id)) {
            $otp = rand(1111, 9999);

            $res->otp = $otp;
            $res->save();

            $para       =   $data['email'];
            $asunto     =   'Codigo de acceso - A100TO';
            $mensaje    =   "Hola " . $res->name . " Un gusto saludarte, se ha pedido un codigo de recuperacion para acceder a tu cuenta en A100TO";
            $mensaje    .=  ' ' . '<br>';
            $mensaje    .=  "Tu codigo es: <br />";
            $mensaje    .=  '# ' . $otp;
            $mensaje    .=  "<br /><hr />Recuerda, si no lo has solicitado tu has caso omiso a este mensaje y te recomendamos hacer un cambio en tu contrasena.";
            $mensaje    .=  "<br/ ><br /><br /> Te saluda el equipo de A100TO";

            $cabeceras = 'From: A100TO' . "\r\n";

            $cabeceras .= 'MIME-Version: 1.0' . "\r\n";

            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            mail($para, $asunto, utf8_encode($mensaje), $cabeceras);

            $return = ['msg' => 'done', 'user_id' => $res->id];
        } else {
            $return = ['msg' => 'error', 'error' => '¡Lo siento! Este correo electrónico no está registrado con nosotros.'];
        }

        return $return;
    }

    public function verify($data)
    {
        $res = AppUser::where('id', $data['user_id'])->where('otp', $data['otp'])->first();

        if (isset($res->id)) {
            $return = ['msg' => 'done', 'user_id' => $res->id];
        } else {
            $return = ['msg' => 'error', 'error' => '¡Lo siento! OTP no coincide.'];
        }

        return $return;
    }

    public function updatePassword($data)
    {
        $res = AppUser::where('id', $data['user_id'])->first();

        if (isset($res->id)) {
            $res->password = $data['password'];
            $res->save();

            $return = ['msg' => 'done', 'user_id' => $res->id];
        } else {
            $return = ['msg' => 'error', 'error' => '¡Lo siento! Algo salió mal.'];
        }

        return $return;
    }
 

    /*
    |--------------------------------------
    |Get all data from db
    |--------------------------------------
    */
    public function getAll($store = 0)
    {
        return AppUser::get();
    }

    public function CorteCaja($id)
    {
        // $orders = OrdersMarket::where('app_user_id',$id)->get(); ->whereDate('created_at','LIKE','%'.date('m-d').'%')
        $orders = OrdersMarket::where('app_user_id',$id)->select('colonie_id')->distinct('colonie_id')->orderBy('created_at', 'desc')->get();
        $data   = [];
        $user_info = AppUser::find($id)->name.' '.AppUser::find($id)->last_name;
        $total = 0;
        
        $subData = [];

        foreach ($orders as $value) {

            $getCols = OrdersMarket::where('app_user_id',$id)->where('colonie_id',$value->colonie_id)->get();

            foreach ($getCols as $key) {
                $total += ($key->costo + $key->extras);

                $subData[] = [
                    'colonie' => Colonies::find($key->colonie_id)->name, 
                    'contribuyenye' => $key->contribuyente,
                    'giro' => $key->giro,
                    'metros' => $key->metros,
                    'costo'  => $key->costo,
                    'cuota'  => $key->cuota,
                    'extras' => $key->extras,
                    'identifier' => $key->identifier,
                    'fecha'  => $key->created_at->format('d/m/y')
                ];
            }

            $data[] = [
                'colonies' => $subData,
                'total'    => $total
            ];

            unset($subData);
            $total = 0;

        }

      
        return [
            'user_info' => $user_info,
            'data'      => $data,
            'total'     => $total
        ];
    }

    /*
    |--------------------------------------
    |Get all Colonies assigned
    |--------------------------------------
    */
    public function getColonies($assign = [])
    {
        $colonies = [];

        foreach ($assign as $key) {
            $col = Colonies::find($key->colonies_id);
            $colonies[] = $col->name;
        }

        if (count($colonies) > 0) {
            return json_encode($colonies);
        }else {
            return 'Sin asignación';
        }
    }

    public function getColoniesId($assign = [])
    {
        $colonies = [];

        foreach ($assign as $key) {
            $colonies[] = $key->colonies_id;
        }


        foreach ($colonies as $key => $value) {
            echo $value;
        }

    }

    /*
    |--------------------------------------
    |Get OverView App 
    |--------------------------------------
    */
    public function overview_app($user_id)
    {
        $admin = new Admin;

        return [
            'total'     => OrdersMarket::where('app_user_id',$user_id)->count(),
            'x_day'     => [
                'tot_orders' => OrdersMarket::where('app_user_id',$user_id)->whereDate('created_at','LIKE','%'.date('m-d').'%')->count(),
                'amount'    => $this->chartxday($user_id,0,1)['amount']
            ],
            'day_data'     => [
                'day_1'    => [
                'data'  => $this->chartxday($user_id,2,1),
                'day'   => $this->getDayName(2)
                ],
                'day_2'    => [
                'data'  => $this->chartxday($user_id,1,1),
                'day'   => $this->getDayName(1)
                ],
                'day_3'    => [
                'data'  => $this->chartxday($user_id,0,1),
                'day'   => $this->getDayName(0)
                ]
            ],
            'week_data' => [
                'total' => $this->chartxWeek($user_id)['total']
            ],
            'month'     => [
                'month_1'     => $this->getMonthName(2),
                'month_2'     => $this->getMonthName(1),
                'month_3'     => $this->getMonthName(0),
            ],
            'complet'   => [
                'complet_1'    => $this->chart($user_id,2,1)['order'],
                'complet_2'    => $this->chart($user_id,1,1)['order'],
                'complet_3'    => $this->chart($user_id,0,1)['order'],
            ],
        ];
    }

    /*
    |--------------------------------------
    |Get Chart Data
    |--------------------------------------
    */
    public function chart($id,$type,$sid = 0)
    {
        $month      = date('Y-m',strtotime(date('Y-m').' - '.$type.' month'));
        // Ordenes  Completas
        $order   = OrdersMarket::where(function($query) use($sid,$id){

            if($sid > 0)
            {
                $query->where('app_user_id',$id);
            }

        })->whereDate('created_at','LIKE',$month.'%')->count();
        
        
        return [
            'order' => $order
        ];
    }

    public function chartxday($id,$type,$sid = 0)
    {
        $date_past = strtotime('-'.$type.' day', strtotime(date('Y-m-d')));
        $day = date('m-d', $date_past);
       
        $ventas = 0;

        $order   = OrdersMarket::where(function($query) use($sid,$id){
                if($sid > 0)
                {
                    $query->where('app_user_id',$id);
                }
        })->whereDate('created_at','LIKE','%'.$day.'%')->sum('costo');

        
        return [
            'order' => $order, 
            'amount' => $order];
    }

    public function chartxWeek($id)
    {
            $date = strtotime(date("Y-m-d"));

            $init_week = strtotime('last Sunday');
            $end_week  = strtotime('next Saturday');

            $total   = OrdersMarket::where(function($query) use($id){

                $query->where('app_user_id',$id);

            })->where('created_at','>=',date('Y-m-d', $init_week))
                ->where('created_at','<=',date('Y-m-d', $end_week))->count();

            $sum   = OrdersMarket::where(function($query) use($id){

                $query->where('app_user_id',$id);

            })->where('created_at','>=',date('Y-m-d', $init_week))
                ->where('created_at','<=',date('Y-m-d', $end_week))->sum('costo');

            return [
                'total'   => $total,
                'lastday' => date('Y-m-d', $init_week),
                'nextday' => date('Y-m-d', $end_week)
            ];
    }

    public function getMonthName($type)
	{
		 $month = date('m') - $type; 
		 return $type == 0 ? date('F') : date('F',strtotime(date('Y').'-'.$month));
	}

	public function getDayName($type)
	{
		$day = date('d') - $type;
		 
		return $type == 0 ? date('l') : date('l',strtotime(date('Y').'- '.$type.' day'));
	}
}
