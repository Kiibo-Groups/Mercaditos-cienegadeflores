<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;

use App\Models\Admin;


use DB;
use Auth;
use Validator;
use Redirect;
class HomeController extends Controller
{
    public $folder = "admin.";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $admin = Admin::find(1);
        return view($this->folder.'home', [

        ]);
    }
}
