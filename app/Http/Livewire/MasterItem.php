<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use Request;
use DB;


class MasterItem extends Component
{
    public $form;

    protected $rules = [
        'form.name' => 'required',
        'form.nameHindi' => 'required',
    ];

    public function clear() {
        $this->form = '';
    }

    public function store()
    {
        $this->validate();
        $userId = Auth::id();
        $clentIp = Request::ip();        

        //$this->logo->getClientOriginalName()
        $this->form['createdById'] = $userId;
        $this->form['ipAddress'] = $clentIp;
        $this->form['companyId'] = 1;

        DB::table('master_items')
        ->insert($this->form);
        session()->flash('success', "Item Created Successfully.");
        $this->clear();

    }


    public function render()
    {
        return view('livewire.master-item')
        ->extends('layouts.app');
    }




    




}
