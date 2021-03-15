<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use Auth;
use Request;


class MasterItemEdit extends Component
{

    public $form;
    protected $master_items;

    protected $rules = [
        'form.name' => 'required',
        'form.nameHindi' => 'required',
    ];

    public function mount($id)
    {        
        $this->master_items = DB::table('master_items')
        ->where('id', $id)
        ->first();
        
        $this->form['id'] = $id;
        $this->form['name'] = $this->master_items->name;
        $this->form['nameHindi'] = $this->master_items->nameHindi;

    }

    public function clear() {
        $this->form = '';
    }


    public function update()
    {
        $this->validate();
        $userId = Auth::id();
        $clentIp = Request::ip();        

        $this->form['createdById'] = $userId;
        $this->form['ipAddress'] = $clentIp;
        $this->form['companyId'] = 1;
        
        DB::table('master_items')
        ->where('id', $this->form['id'])
        ->update($this->form);
        $this->clear();
        session()->flash('success', "Item Updated Successfully.");
        return redirect()->to('/master-item-datatable');
        

    }


    public function render()
    {
        return view('livewire.master-item-edit')
        ->extends('layouts.app');
    }


}
