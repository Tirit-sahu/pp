@extends('layouts.app')
@section('content')

<?php 
    $action=url('/master-unit-store');
    $button='SUBMIT';
    $isStockable='';
if (isset($master_unit)) {
    $action=url('/master-unit-update', array($master_unit->id));
    $button='UPDATE';
    $isStockable=$master_unit->isStockable;
}
?>

    <div class="container-fluid">
        
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Add New Unit    
                        </h3>
                        <a href="{{ url('/master-unit-datatable') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Unit Datatable" }}</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                            @csrf
                            <x-alert/>
                            
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Unit Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" value="{{ old('name', isset($master_unit)?$master_unit->name:'') }}" id="name" class="form-control">
                                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="nameHindi" class="control-label col-sm-2">Unit Name Hindi</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nameHindi"  value="{{ old('nameHindi', isset($master_unit)?$master_unit->nameHindi:'') }}" class="form-control">
                                            @error('nameHindi') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>        
                                          

                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="supplierRate" class="control-label col-sm-2">Supplier Rate</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="supplierRate"  value="{{ old('supplierRate', isset($master_unit)?$master_unit->supplierRate:'') }}" class="form-control">
                                            @error('supplierRate') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="customerRate" class="control-label col-sm-2">Customer Rate</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="customerRate"  value="{{ old('customerRate', isset($master_unit)?$master_unit->customerRate:'') }}" class="form-control">
                                            @error('customerRate') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="addressHindi" class="control-label col-sm-2">Is Stockable</label>
                                        <div class="col-sm-10">
                                            <?php 
                                            $isStockableArray = ['No', 'Yes'];
                                            ?>
                                            <select id="isStockable" name="isStockable" class="form-control">
                                                @foreach($isStockableArray as $isa)
                                                <option value="{{ $isa }}">{{ $isa }}</option>
                                                @endforeach
                                            </select>
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
