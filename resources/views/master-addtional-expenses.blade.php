@extends('layouts.app')
@section('content')
<?php
$action=url('/master-addtional-expenses-store');
$button='SUBMIT';
$type='';
$process='';
if (isset($master_addtional_expens)) {
    $action=url('/master-addtional-expenses-update', array($master_addtional_expens->id));
    $button='UPDATE';
    $type=$master_addtional_expens->type;
    $process=$master_addtional_expens->process;
}
?>
    <div class="container-fluid">
               
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Additional Expenses Master    
                        </h3>
                        <a href="{{ url('/master-addtional-expenses-datatable') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Additional Expenses Master Datatable" }}</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                            @csrf
                            <x-alert/>
                            
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Additional Exp. Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" value="{{ old('name', isset($master_addtional_expens)?$master_addtional_expens->name:'') }}" id="name" class="form-control">
                                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="nameHindi" class="control-label col-sm-2">Add. Exp. Name (Hindi)</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nameHindi" value="{{ old('name', isset($master_addtional_expens)?$master_addtional_expens->nameHindi:'') }}" id="nameHindi" class="form-control">
                                            @error('nameHindi') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="supplierRate" class="control-label col-sm-2">Type</label>
                                        <div class="col-sm-10"> 
                                            <?php $typeArray = array("Percentage", "Rupees"); ?>                                           
                                            <select name="type" class="form-control">
                                                <option value=""></option>
                                                @foreach($typeArray as $row)
                                                <option @if($type==$row) selected @endif value="{{ $row }}">{{ $row }}</option>
                                                @endforeach
                                            </select>
                                            @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="customerRate" class="control-label col-sm-2">Type Of Expense</label>
                                        <div class="col-sm-10">
                                            <?php $processArray = array("Add", "Subtract"); ?>
                                            <select name="process" class="form-control">
                                                <option value=""></option>
                                                @foreach($processArray as $row)
                                                <option @if($process==$row) selected @endif value="{{ $row }}">{{ $row }}</option>
                                                @endforeach
                                            </select>
                                            @error('process') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>       

                                </div>
                            </div>

                     
                            
                            
                            <div class="form-actions pull-right">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-floppy-o" aria-hidden="true"></i>  {{ $button }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>

@endsection