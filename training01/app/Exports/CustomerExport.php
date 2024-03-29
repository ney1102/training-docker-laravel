<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerExport implements FromView
{    
    protected $customers;

    public function __construct($customers)
    {
        $this->customers = $customers;
    }


    public function view(): View
    {
        return view('export.customerTable',['customers'=>$this->customers]);        
    }
}
