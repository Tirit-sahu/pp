<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;



class MasterCustomerSupplier extends Component
{
    public $master_groups, $form, $type=[];

    protected $rules = [
        'form.name' => 'required',
    ];

    public function clear() {
        $this->form = '';
    }

    public function mount()
    {
        $this->master_groups = DB::table('master_groups')->orderBy('id', 'DESC')->get();
    }


    public function render()
    {
        $this->master_groups = DB::table('master_groups')->orderBy('id', 'DESC')->get();
        return view('livewire.master-customer-supplier')
        ->extends('layouts.app');
    }

    public function store()
    {
        $this->validate();
        dd($this->type);
        DB::table('master_customer_suppliers')->insert($this->form);
        $this->clear();
        session()->flash('success', "Customer / Supplier Created Successfully.");
    }




}
