<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Exports\OrderExport;
use App\Exports\OrderExportPerms;

use App\Models\OrdersMarket;
use App\Models\Mercaditos;  
use App\Models\Colonies;  
use App\Models\Admin;
use App\Models\Perms;

use DB;
use Validator;
use Redirect;
use IMS;
use Excel;
class ReportsController extends Controller
{
    public $folder  = "admin/reports.";
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $req = new OrdersMarket;
        return View($this->folder.'index',[
            'data' => $req->getAll(),
            'req'  => $req,
            'link' => env('admin').'/exportData'
        ]);
    }

    public function print($id)
    {
        return response()->json(['data' => $id]);
    }

    public function exportData(Request $Request)
	{
		return Excel::download(new OrderExport, 'report.xlsx');
    }

    /**
     * Permisos de Alcohol
     */
    public function report_perms()
    {
        $req = new Perms;
        return View($this->folder.'perms',[
            'data' => $req->getAll(),
            'req'  => $req,
            'link' => env('admin').'/exportDataPerms'
        ]);
    }

    
    public function exportDataPerms(Request $Request)
	{
		return Excel::download(new OrderExportPerms, 'permisos_alcohol.xlsx');
    }
}
