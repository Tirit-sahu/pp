<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;

class MasterCompanySettingDatatable extends Component
{
    public $master_company_settings=[];
   

    public function render()
    {

        $this->master_company_settings = DB::table('master_company_settings')
        ->orderBy('id', 'DESC')
        ->get();
        return view('livewire.master-company-setting-datatable')
        ->extends('layouts.app');
    }

   
}
