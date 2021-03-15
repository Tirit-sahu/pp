<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use Auth;
use Request;

class MasterGroupEdit extends Component
{

    public $form;
    protected $master_group;

    protected $rules = [
        'form.name' => 'required'
    ];

    public function mount($id)
    {        
        $this->master_group = DB::table('master_groups')
        ->where('id', $id)
        ->first();

        $this->form['id'] = $id;
        $this->form['name'] = $this->master_group->name;
    }

    public function clear() {   
        $this->form = '';
    }

    public function update()
    {
        $this->validate();

        $count = DB::table('master_groups')
        ->where('name', $this->form['name'])->count();
        
        if($count==0){

            $userId = Auth::id();
            $clentIp = Request::ip();        

            $this->form['createdById'] = $userId;
            $this->form['ipAddress'] = $clentIp;
            $this->form['companyId'] = 1;

            DB::table('master_groups')
            ->where('id', $this->form['id'])
            ->update($this->form);
            $this->clear();
            session()->flash('success', "Group Updated Successfully.");
            return redirect()->to('/master-group-datatable');

        }else{
            session()->flash('error', "".$this->form['name']." is already in list");
        }        

    }


    public function render()
    {
        return view('livewire.master-group-edit')
        ->extends('layouts.app');
    }
    
}
