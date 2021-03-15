
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
                    <a href="index-2.html">Customer/Supplier Master</a>                    
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
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Add New Customer/Supplier    
                        </h3>
                        <a href="{{ url('/master-unit-datatable') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Customer/Supplier Datatable" }}</a>
                    </div>
                    <div class="box-content">
                        <form wire:submit.prevent="store" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                            
                            <x-alert/>
                            
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Customer/Supplier Name <span style="color: red;">*</span> </label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.name" id="name" class="form-control">
                                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="nameHindi" class="control-label col-sm-2">Customer/Supplier Name (Hindi) <span style="color: red;">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.nameHindi" id="nameHindi" class="form-control">
                                            @error('nameHindi') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
        
                                    <div class="form-group">
                                        <label for="mobile" class="control-label col-sm-2">Mobile Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.mobile" id="mobile" class="form-control">
                                            @error('mobile') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="address" class="control-label col-sm-2">Address
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.address" id="address" class="form-control">
                                            @error('address') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>  
                                    
                                    
                                    <div class="form-group">
                                        <label for="openingBalance" class="control-label col-sm-2">Opening Balance</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.openingBalance" id="openingBalance" class="form-control">
                                            @error('openingBalance') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="creditLimitAmount" class="control-label col-sm-2">Credit Limit Amt
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.creditLimitAmount" id="creditLimitAmount" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="creditLimitTransaction" class="control-label col-sm-2">Credit Limit Tans.</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.creditLimitTransaction" id="creditLimitTransaction" class="form-control">
                                        </div>
                                    </div> 

                                          

                                </div>
                                <div class="col-sm-6">

                                    

                                    <div class="form-group">
                                        <label for="type" class="control-label col-sm-2">Type</label>
                                        <div class="col-sm-10">
                                            <div class="check-demo-col">
                                            <div class="check-line">
                                                <input type="checkbox" wire:model="type[]" id="Customer" class='icheck-me' data-skin="square" data-color="blue">
                                                <label class='inline' for="Customer">Customer</label>
                                            </div>
                                            </div>
                                            <div class="check-demo-col">
                                            <div class="check-line">
                                                <input type="checkbox" wire:model="type[]" id="Supplier" class='icheck-me' data-skin="square" data-color="blue">
                                                <label class='inline' for="Supplier">Supplier</label>
                                            </div>
                                            </div>
                                            <div class="check-demo-col">
                                            <div class="check-line">
                                                <input type="checkbox" wire:model="type[]" id="Loader" class='icheck-me' data-skin="square" data-color="blue">
                                                <label class='inline' for="Loader">Loader</label>
                                            </div>
                                            </div>                                            
                                           
                                        </div>
                                    </div> 


                                    <div class="form-group">
                                        <label for="addressHindi" class="control-label col-sm-2">Group Name</label>
                                        <div class="col-sm-10">
                                            <select id="groupName" wire:model="form.groupName" class="form-control">
                                                <option value=""></option>
                                                @foreach($master_groups as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="openingSPN" class="control-label col-sm-2">Opening SPN</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.openingSPN" id="openingSPN" class="form-control">
                                            @error('openingSPN') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="openingTMN" class="control-label col-sm-2">Opening TMN</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.openingTMN" id="openingTMN" class="form-control">
                                            @error('openingTMN') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="openingTVS" class="control-label col-sm-2">Opening TVS</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.openingTVS" id="openingTVS" class="form-control">
                                            @error('openingTVS') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="status" class="control-label col-sm-2">Status</label>
                                        <div class="col-sm-10">
                                            <select id="status" wire:model="form.status" class="form-control">
                                                <option value="Active">Active</option>
                                                <option value="InActive">InActive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="photo" class="control-label col-sm-2">Photo</label>
                                        <div class="col-sm-10">
                                            <input type="file" wire:model="form.photo" id="">
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
