<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use Request;
use DB;


class MasterAddtionalExpenses extends Component
{

    public $form;

    protected $rules = [
        'form.name' => 'required',
        'form.type' => 'required',
        'form.process' => 'required',
    ];


    public function clear() {
        $this->form = '';
    }

    public function store()
    {
        $this->validate();

        $count = DB::table('master_addtional_expenses')
        ->where('name', $this->form['name'])->count();

        if($count==0){

        $userId = Auth::id();
        $clentIp = Request::ip();        

        $this->form['createdById'] = $userId;
        $this->form['ipAddress'] = $clentIp;
        $this->form['companyId'] = 1;

        DB::table('master_addtional_expenses')
        ->insert($this->form);
        session()->flash('success', "Additional Expenses Created Successfully.");
        $this->clear();
        }else{
            session()->flash('error', "".$this->form['name']." is already in list");
        }

    }


    public function render()
    {
        return view('livewire.master-addtional-expenses')
        ->extends('layouts.app');
    }



}
