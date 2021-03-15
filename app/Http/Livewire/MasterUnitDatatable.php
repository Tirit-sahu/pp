<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;


class MasterUnitDatatable extends Component
{
    public $master_units=[];

    public function render()
    {
        $this->master_units = DB::table('master_units')
        ->orderBy('id', 'DESC')
        ->get();
        return view('livewire.master-unit-datatable')
        ->extends('layouts.app');
    }


    public function delete($id)
    {
        DB::table('master_units')->where('id', $id)->delete();
        session()->flash('success', "Unit Deleted Successfully.");
    }


}
