<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;


class MasterGroupDatatable extends Component
{
    public $master_groups=[];

    public function render()
    {
        $this->master_groups = DB::table('master_groups')
        ->orderBy('id', 'DESC')
        ->get();

        return view('livewire.master-group-datatable')
        ->extends('layouts.app');
    }
}
