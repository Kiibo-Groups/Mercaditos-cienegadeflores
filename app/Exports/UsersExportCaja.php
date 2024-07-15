<?php

namespace App\Exports;

use App\Order;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Auth;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View; 
use App\Models\AppUser;  

class UsersExportCaja implements FromView,WithHeadings,WithTitle
{
    public $folder  = "admin/reports.";
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    
    }

    public function headings(): array
    {
        return [
            'User',
            'Colonia',
            'Mercado',
            'Contribuyente',
            'Giro',
            'Metros',
            'Costo',
            'Cuota',
            'Extra'
        ];
    }
    
    public function title(): string
    {
        return 'Corte de caja';
    }

    public function view(): view
    {
        $res = new AppUser;
         
		return View($this->folder.'reportCaja',[
            'data' => $res->CorteCaja($_POST['user_id'])
		]);
    }
}
