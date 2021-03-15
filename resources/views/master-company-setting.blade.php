@extends('layouts.app')
@section('content')

<?php 
$formTitle = "Company Setting";
$button = "SUBMIT";
$action = url('master-company-setting-store');
if (isset($master_company_settings)) {
    $formTitle = "Edit Company Setting";
    $button = "UPDATE";
    $action = url('master-company-setting-update/'.$master_company_settings->id);
}
?>

<div class="container-fluid">
    <div class="page-header">
        <div class="pull-left">
            <h1>{{ $formTitle }}</h1>
        </div>
        <div class="pull-right">
            <ul class="minitiles">
                <li class='grey'>
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                    </a>
                </li>
                <li class='lightgrey'>
                    <a href="#">
                        <i class="fa fa-globe"></i>
                    </a>
                </li>
            </ul>
            <ul class="stats">
                <li class='satgreen'>
                    <i class="fa fa-money"></i>
                    <div class="details">
                        <span class="big">$324,12</span>
                        <span>Balance</span>
                    </div>
                </li>
                <li class='lightred'>
                    <i class="fa fa-calendar"></i>
                    <div class="details">
                        <span class="big">February 22, 2013</span>
                        <span>Wednesday, 13:56</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
 
    
    
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color">
                <div class="box-title">
                    <h3>
                        <i class="fa fa-list-alt" aria-hidden="true"></i> {{ $formTitle }}
                    </h3>
                    <a href="{{ url('/master-company-setting-datatable') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Company Setting Datatable" }}</a>
                </div>
                <div class="box-content">
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                        @csrf
                        <x-alert/>
                        
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="name" class="control-label col-sm-2">Company Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" value="{{ old('name', isset($master_company_settings)?$master_company_settings->name:'') }}" id="name" class="form-control">
                                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="nameHindi" class="control-label col-sm-2">Company Name Hindi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nameHindi" value="{{ old('nameHindi', isset($master_company_settings)?$master_company_settings->nameHindi:'') }}" id="nameHindi" class="form-control">
                                        @error('nameHindi') <span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="logo" class="control-label col-sm-2">Logo </label>
                                    <div class="col-sm-10">
                                        <input type="file" name="logo">
                                        @error('logo') <span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="mobile" class="control-label col-sm-2">Mobile</label>
                                    <div class="col-sm-10">
                                        <input type="text" maxlength="10" name="mobile" value="{{ old('mobile', isset($master_company_settings)?$master_company_settings->mobile:'') }}" id="mobile" class="form-control">
                                        @error('mobile') <span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="mobile2" class="control-label col-sm-2">Alternate Mobile</label>
                                    <div class="col-sm-10">
                                        <input type="text" maxlength="10" name="mobile2" value="{{ old('mobile2', isset($master_company_settings)?$master_company_settings->mobile2:'') }}" id="mobile2" class="form-control">
                                        @error('mobile2') <span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="emailId" class="control-label col-sm-2">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="emailId" value="{{ old('emailId', isset($master_company_settings)?$master_company_settings->emailId:'') }}" id="emailId" class="form-control">
                                        @error('emailId') <span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="address" class="control-label col-sm-2">Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="address" value="{{ old('address', isset($master_company_settings)?$master_company_settings->address:'') }}" id="address" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="addressHindi" class="control-label col-sm-2">Address in Hindi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="addressHindi" value="{{ old('addressHindi', isset($master_company_settings)?$master_company_settings->addressHindi:'') }}" id="addressHindi" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="slog" class="control-label col-sm-2">Slog</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="slog" value="{{ old('slog', isset($master_company_settings)?$master_company_settings->slog:'') }}" id="slog" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="slogHindi" class="control-label col-sm-2">Slog in Hindi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="slogHindi" value="{{ old('slogHindi', isset($master_company_settings)?$master_company_settings->slogHindi:'') }}" id="slogHindi" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="termCondition" class="control-label col-sm-2">Term Condition</label>
                                    <div class="col-sm-10">
                                        <textarea name="termCondition" value="{{ old('termCondition', isset($master_company_settings)?$master_company_settings->termCondition:'') }}" id="termCondition" class="form-control"></textarea>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="tinNumber" class="control-label col-sm-2">TIN Number</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tinNumber" value="{{ old('tinNumber', isset($master_company_settings)?$master_company_settings->tinNumber:'') }}" id="tinNumber" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="gstNumber" class="control-label col-sm-2">GST Number</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="gstNumber" value="{{ old('gstNumber', isset($master_company_settings)?$master_company_settings->gstNumber:'') }}" id="gstNumber" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="bankName" class="control-label col-sm-2">Bank Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="bankName" value="{{ old('bankName', isset($master_company_settings)?$master_company_settings->bankName:'') }}" id="bankName" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="bankAccountNumber" class="control-label col-sm-2">Bank Account Number</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="bankAccountNumber" value="{{ old('bankAccountNumber', isset($master_company_settings)?$master_company_settings->bankAccountNumber:'') }}" id="bankAccountNumber" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="ifscCode" class="control-label col-sm-2">IFSC Code</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="ifscCode" value="{{ old('ifscCode', isset($master_company_settings)?$master_company_settings->ifscCode:'') }}" id="ifscCode" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="stateId" class="control-label col-sm-2">State</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="stateId" value="{{ old('stateId', isset($master_company_settings)?$master_company_settings->stateId:'') }}" id="stateId" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="openingBalance" class="control-label col-sm-2">Opening Balance</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="openingBalance" value="{{ old('openingBalance', isset($master_company_settings)?$master_company_settings->openingBalance:'') }}" id="openingBalance" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label for="openingBalanceDate" class="control-label col-sm-2">Opening Balance Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="openingBalanceDate" value="{{ old('openingBalanceDate', isset($master_company_settings)?$master_company_settings->openingBalanceDate:'') }}" id="openingBalanceDate" class="form-control">
                                    </div>
                                </div>

                            </div>
                        </div>

                 
                        
                        
                        <div class="form-actions pull-right">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-floppy-o" aria-hidden="true"></i>  {{ $button }} </button>
                            {{-- <button type="button" class="btn">Cancel</button> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
    
</div>

@endsection