<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use DB;
use Auth;
use Request;


class MasterCompanySettingEdit extends Component
{

    use WithFileUploads;
    protected $master_company_setting;
    public $form, $logo;
    
    protected $rules = [
        'form.name' => 'required',
        'form.mobile' => 'required',
        'form.emailId' => 'required|email',
    ];
    

    public function mount($id)
    {

        $this->master_company_setting = DB::table('master_company_settings')
        ->where('id', $id)
        ->first();
        $this->form['id'] = $this->master_company_setting->id;
        $this->form['name'] = $this->master_company_setting->name;
        $this->form['nameHindi'] = $this->master_company_setting->nameHindi;
        $this->logo = $this->master_company_setting->logo;    
        $this->form['mobile'] = $this->master_company_setting->mobile;
        $this->form['mobile2'] = $this->master_company_setting->mobile2;
        $this->form['address'] = $this->master_company_setting->address;
        $this->form['addressHindi'] = $this->master_company_setting->addressHindi;
        $this->form['slog'] = $this->master_company_setting->slog;
        $this->form['slogHindi'] = $this->master_company_setting->slogHindi;
        $this->form['emailId'] = $this->master_company_setting->emailId;
        $this->form['termCondition'] = $this->master_company_setting->termCondition;
        $this->form['tinNumber'] = $this->master_company_setting->tinNumber;
        $this->form['gstNumber'] = $this->master_company_setting->gstNumber;
        $this->form['bankName'] = $this->master_company_setting->bankName;
        $this->form['bankAccountNumber'] = $this->master_company_setting->bankAccountNumber;
        $this->form['ifscCode'] = $this->master_company_setting->ifscCode;
        $this->form['stateId'] = $this->master_company_setting->stateId;
        $this->form['openingBalance'] = $this->master_company_setting->openingBalance;
        $this->form['openingBalanceDate'] = $this->master_company_setting->openingBalanceDate;

    }

    public function render()
    {
        return view('livewire.master-company-setting-edit')
        ->extends('layouts.app');
    }

    public function clear() {
        $this->form = '';
    }


    public function update()
    {
        $this->validate();
        $userId = Auth::id();
        $clentIp = Request::ip();   
        // dd($this->logo);

            // $imageName = $this->logo->store('logo');
            // $this->form['logo'] = $imageName;
        
        //$this->logo->getClientOriginalName()
        $this->form['createdById'] = $userId;
        $this->form['ipAddress'] = $clentIp;
        

        DB::table('master_company_settings')
        ->where('id', $this->form['id'])
        ->update($this->form);
        $this->clear();
        session()->flash('success', "Company Updated Successfully.");
        return redirect()->to('/master-company-setting-datatable');       

    }





}
