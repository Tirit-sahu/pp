<?php 
$lastSegments = last(request()->segments()); 
$formTitle='';
if(is_numeric($lastSegments)){
    $segment = Request::url();
    $segmentArr = explode("/", $segment);
    $indexArr = count($segmentArr)-2;
    $lastSegmentWithSpce = str_replace("-"," ",ucfirst($segmentArr[$indexArr]));
    $formTitle = $lastSegmentWithSpce;
}else{
    $lastSegmentWithSpce = str_replace("-"," ",$lastSegments);
    $formTitle = ucfirst($lastSegmentWithSpce);
}

?>



<div id="main">
    <div class="container-fluid">
        <div class="page-header">
            <div class="pull-left">
                <h1>Dashboard</h1>
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
        <div class="breadcrumbs">
            <ul>
                <li>
                    <a href="more-login.html">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="index-2.html">{{ $formTitle }}</a>                    
                </li>
            </ul>
            <div class="close-bread">
                <a href="#">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> {{ $formTitle }}    
                        </h3>
                        <a href="{{ url('/master-company-setting-datatable') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ $formTitle." Datatable" }}</a>
                    </div>
                    <div class="box-content">
                        <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data" class='form-horizontal form-column form-bordered'>
                            
                            <x-alert/>
                            
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Company Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.name" id="name" class="form-control">
                                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="nameHindi" class="control-label col-sm-2">Company Name Hindi</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.nameHindi" id="nameHindi" class="form-control">
                                            @error('nameHindi') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="logo" class="control-label col-sm-2">Logo {{ $logo }}</label>
                                        <div class="col-sm-10">
                                            <input type="file" wire:model="logo">
                                            {{-- <input type="file" wire:model="logo" id="logo" class="form-control"> --}}
                                            @error('logo') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="mobile" class="control-label col-sm-2">Mobile</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.mobile" id="mobile" class="form-control">
                                            @error('mobile') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="mobile2" class="control-label col-sm-2">Alternate Mobile</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.mobile2" id="mobile2" class="form-control">
                                            @error('mobile2') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="emailId" class="control-label col-sm-2">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.emailId" id="emailId" class="form-control">
                                            @error('emailId') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="address" class="control-label col-sm-2">Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.address" id="address" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="addressHindi" class="control-label col-sm-2">Address in Hindi</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.addressHindi" id="addressHindi" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="slog" class="control-label col-sm-2">Slog</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.slog" id="slog" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="slogHindi" class="control-label col-sm-2">Slog in Hindi</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.slogHindi" id="slogHindi" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="termCondition" class="control-label col-sm-2">Term Condition</label>
                                        <div class="col-sm-10">
                                            <textarea wire:model="form.termCondition" id="termCondition" class="form-control"></textarea>
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="tinNumber" class="control-label col-sm-2">TIN Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.tinNumber" id="tinNumber" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="gstNumber" class="control-label col-sm-2">GST Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.gstNumber" id="gstNumber" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="bankName" class="control-label col-sm-2">Bank Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.bankName" id="bankName" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="bankAccountNumber" class="control-label col-sm-2">Bank Account Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.bankAccountNumber" id="bankAccountNumber" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="ifscCode" class="control-label col-sm-2">IFSC Code</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.ifscCode" id="ifscCode" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="stateId" class="control-label col-sm-2">State</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.stateId" id="stateId" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="openingBalance" class="control-label col-sm-2">Opening Balance</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.openingBalance" id="openingBalance" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="openingBalanceDate" class="control-label col-sm-2">Opening Balance Date</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.openingBalanceDate" id="openingBalanceDate" class="form-control">
                                        </div>
                                    </div>

                                </div>
                            </div>

                     
                            
                            
                            <div class="form-actions pull-right">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-floppy-o" aria-hidden="true"></i>  SUBMIT </button>
                                {{-- <button type="button" class="btn">Cancel</button> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>
</div>
