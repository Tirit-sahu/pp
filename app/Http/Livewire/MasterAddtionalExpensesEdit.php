<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use Auth;
use Request;


class MasterAddtionalExpensesEdit extends Component
{
    public $form;
    protected $master_addtional_expenses;
    protected $rules = [
        'form.name' => 'required',
        'form.type' => 'required',
        'form.process' => 'required',
    ];

    public function mount($id)
    {
        $this->master_addtional_expenses = DB::table('master_addtional_expenses')
        ->where('id', $id)
        ->first();
        
        $this->form['id'] = '1';
        $this->form['name'] = $this->master_addtional_expenses->name;
        $this->form['nameHindi'] = $this->master_addtional_expenses->nameHindi;
        $this->form['type'] = $this->master_addtional_expenses->type;
        $this->form['process'] = $this->master_addtional_expenses->process;

    }



    public function clear() {
        $this->form = '';
    }

    public function update()
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
        ->where('id', $this->form['id'])
        ->update($this->form);
        $this->clear();
        session()->flash('success', "Additional Expenses Created Successfully.");        
        return redirect()->to('/master-addtional-expenses-datatable');
        }else{
            session()->flash('error', "".$this->form['name']." is already in list");
        }

    }





    public function render()
    {
        return view('livewire.master-addtional-expenses-edit')
        ->extends('layouts.app');
    }
}
