
<div id="main">
    <div class="container-fluid">
        <div class="page-header">
            <div class="pull-left">
                <h1>Dashboard </h1>
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
                    <a href="index-2.html">Unit Master</a>                    
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
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Unit Edit   
                        </h3>
                        <a href="{{ url('/master-company-setting-datatable') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Unit Master Datatable" }}</a>
                    </div>
                    <div class="box-content">
                        <form wire:submit.prevent="update" method="POST" enctype="multipart/form-data" class='form-horizontal form-column form-bordered'>
                            
                            <x-alert/>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="hidden" wire:model="form.id">
                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Unit Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.name" id="name" class="form-control">
                                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="nameHindi" class="control-label col-sm-2">Unit Name Hindi</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.nameHindi" id="nameHindi" class="form-control">
                                            @error('nameHindi') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
        
                                    <div class="form-group">
                                        <label for="namePrint" class="control-label col-sm-2">Unit Name Print</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.namePrint" id="namePrint" class="form-control">
                                            @error('namePrint') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="mobile2" class="control-label col-sm-2">Unit Name Print Hindi</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.namePrintHindi" id="namePrintHindi" class="form-control">
                                            @error('namePrintHindi') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>        
                                          

                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="supplierRate" class="control-label col-sm-2">Supplier Rate</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.supplierRate" id="supplierRate" class="form-control">
                                            @error('supplierRate') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="customerRate" class="control-label col-sm-2">Customer Rate</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.customerRate" id="customerRate" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="addressHindi" class="control-label col-sm-2">Is Stockable</label>
                                        <div class="col-sm-10">
                                            <select id="isStockable" wire:model="form.isStockable" class="form-control">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select>
                                        </div>
                                    </div>  

                                </div>
                            </div>
                     
                            
                            
                            <div class="form-actions pull-right">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-floppy-o" aria-hidden="true"></i>  UPDATE </button>
                                {{-- <button type="button" class="btn">Cancel</button> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>
</div>
