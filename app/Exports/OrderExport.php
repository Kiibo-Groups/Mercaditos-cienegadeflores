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
use App\Models\OrdersMarket;

class OrderExport implements FromView,WithHeadings,WithTitle
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
            'user',
            'colonia',
            'contribuyente',
            'giro',
            'metros',
            'costo',
            'cuota',
            'extras'
        ];
    }
    
    public function title(): string
    {
        return 'Reporte de ventas';
    }

    public function view(): view
    {
        $res = new OrdersMarket;
        
		return View($this->folder.'report',[
            'data' => $res->getAll()
		]);
    }
}
