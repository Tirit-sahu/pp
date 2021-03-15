<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use DB;
use Auth;
use Request;


class MasterCompanySetting extends Component
{
    use WithFileUploads;

    public $form;
    public $logo;

    protected $rules = [
        'form.name' => 'required',
        'form.mobile' => 'required',
        'form.emailId' => 'required|email',
    ];

    
    public function render()
    {
        return view('livewire.master-company-setting')
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
        $imageName = $this->logo->store('logo');
        $this->form['createdById'] = $userId;
        $this->form['ipAddress'] = $clentIp;
        $this->form['logo'] = $imageName;

        DB::table('master_company_settings')
        ->insert($this->form);
        session()->flash('success', "Company Created Successfully.");
        $this->clear();

    }



}
