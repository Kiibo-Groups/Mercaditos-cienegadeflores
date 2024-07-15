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
use App\Models\Perms;

class OrderExportPerms implements FromView,WithHeadings,WithTitle
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
            'user',
            'colonia',
            'perm1',
            'perm2',
            'perm3',
            'perm4',
            'perm5',
            'perm6',
            'perm7',
            'perm8',
            'perm9',
            'perm10',
        ];
    }
    
    public function title(): string
    {
        return 'Permisos de alcohol';
    }

    public function view(): view
    {
        $res = new Perms;
        
		return View($this->folder.'reportPerms',[
            'data' => $res->getAll()
		]);
    }
}
