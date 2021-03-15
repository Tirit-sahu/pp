<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;


class MasterItemDatatable extends Component
{

    public $master_items;

    public function render()
    {
        $this->master_items = DB::table('master_items')
        ->orderBy('id', 'DESC')
        ->get();
        return view('livewire.master-item-datatable')
        ->extends('layouts.app');
    }

}
