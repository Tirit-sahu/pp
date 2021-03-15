<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;

class MasterAddtionalExpensesDatatable extends Component
{
    public $master_addtional_expenses=[];

    public function render()
    {
        $this->master_addtional_expenses = DB::table('master_addtional_expenses')
        ->orderBy('id', 'DESC')
        ->get();
        return view('livewire.master-addtional-expenses-datatable')
        ->extends('layouts.app');
    }
}
