<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use Auth;
use Request;


class MasterUnitEdit extends Component
{
    public $form;
    protected $master_unit;

    protected $rules = [
        'form.name' => 'required',
        'form.nameHindi' => 'required',
        'form.supplierRate' => 'required',
        'form.customerRate' => 'required',
    ];

    public function mount($id)
    {
        
        $this->master_unit = DB::table('master_units')
        ->where('id', $id)
        ->first();

        $this->form['id'] = $id;
        $this->form['name'] = $this->master_unit->name;
        $this->form['nameHindi'] = $this->master_unit->nameHindi;
        $this->form['namePrint'] = $this->master_unit->namePrint;
        $this->form['namePrintHindi'] = $this->master_unit->namePrintHindi;
        $this->form['supplierRate'] = $this->master_unit->supplierRate;
        $this->form['customerRate'] = $this->master_unit->customerRate;
        $this->form['isStockable'] = $this->master_unit->isStockable;

    }

    public function clear() {
        $this->form = '';
    }


    public function update()
    {
        $this->validate();
        $userId = Auth::id();
        $clentIp = Request::ip();        

        //$this->logo->getClientOriginalName()
        $this->form['createdById'] = $userId;
        $this->form['ipAddress'] = $clentIp;
        $this->form['companyId'] = 1;

        DB::table('master_units')
        ->where('id', $this->form['id'])
        ->update($this->form);
        $this->clear();
        session()->flash('success', "Unit Updated Successfully.");
        return redirect()->to('/master-unit-datatable');
        

    }


    public function render()
    {
        return view('livewire.master-unit-edit')
        ->extends('layouts.app');
    }
}
