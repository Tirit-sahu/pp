<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use Request;
use DB;


class MasterUnit extends Component
{

    public $form;

    protected $rules = [
        'form.name' => 'required',
        'form.nameHindi' => 'required',
        'form.supplierRate' => 'required',
        'form.customerRate' => 'required',
    ];


    public function render()
    {
        return view('livewire.master-unit')
        ->extends('layouts.app');
    }



    public function clear() {
        $this->form = '';
    }

    public function store()
    {
        $this->validate();
        $userId = Auth::id();
        $clentIp = Request::ip();        
        $this->form['createdById'] = $userId;
        $this->form['ipAddress'] = $clentIp;
        $this->form['companyId'] = 1;

        DB::table('master_units')
        ->insert($this->form);
        session()->flash('success', "Unit Created Successfully.");
        $this->clear();

    }


    // public function getChange()
    // {
    //     dd($this->form['isStockable']);
    // }



}
