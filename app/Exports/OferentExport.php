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
use App\Models\Mercaditos;

class OferentExport implements FromView,WithHeadings,WithTitle
{
    public $folder  = "admin/reports.";
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $ord = Order::select('name','email','phone','address','d_charges','discount','total')->where('store_id',$_POST['store_id'])->get();
    }

    public function headings(): array
    {
        return [
            'pic_profile',
            'pic_ine_front',
            'pic_ine_back',
            'contribuyente',
            'giro',
            'colonia',
            'metros',
            'costo',
            'cuota',
            'extras'
        ];
    }
    
    public function title(): string
    {
        return 'Reporte de Oferentes';
    }

    public function view(): view
    {
        $res = new Mercaditos;
        
		return View($this->folder.'reports_oferente',[
            'data' => $res->ExportData()
		]);
    }
}
