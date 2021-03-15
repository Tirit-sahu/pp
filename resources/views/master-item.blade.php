@extends('layouts.app')
@section('content')
<?php
$action=url('/master-item-store');
$button='SUBMIT';
if (isset($master_item)) {
    $action=url('/master-item-update', array($master_item->id));
    $button='UPDATE';
}
?>
    <div class="container-fluid">
         
        
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Add New Item    
                        </h3>
                        <a href="{{ url('/master-item-datatable') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Item Datatable" }}</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                            @csrf
                            <x-alert/>
                            
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Item Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" value="{{ old('name', isset($master_item)?$master_item->name:'') }}" class="form-control">
                                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>       
                                            
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="nameHindi" class="control-label col-sm-2">Item Name Hindi</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nameHindi" value="{{ old('name', isset($master_item)?$master_item->nameHindi:'') }}" class="form-control">
                                            @error('nameHindi') <span class="text-danger">{{ $message }}</span>@enderror
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