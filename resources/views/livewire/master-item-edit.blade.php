
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
                    <a href="index-2.html">Item Master</a>                    
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
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Item Edit    
                        </h3>
                        <a href="{{ url('/master-item-datatable') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Item Datatable" }}</a>
                    </div>
                    <div class="box-content">
                        <form wire:submit.prevent="update" method="POST" enctype="multipart/form-data" class='form-horizontal form-column form-bordered'>
                            
                            <x-alert/>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="hidden" wire:model="form.id">
                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Item Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.name" id="name" class="form-control">
                                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>     
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="nameHindi" class="control-label col-sm-2">Item Name Hindi</label>
                                        <div class="col-sm-10">
                                            <input type="text" wire:model="form.nameHindi" id="nameHindi" class="form-control">
                                            @error('nameHindi') <span class="text-danger">{{ $message }}</span>@enderror
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
