
@extends('layouts.app')
@section('content')
<?php
$action=url('/master-group-store');
if (isset($master_group)) {
    $action=url('/master-group-update', array($master_group->id));
}
?>
    <div class="container-fluid">
        
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Add New Group    
                        </h3>
                        <a href="{{ url('/master-group-datatable') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Group Datatable" }}</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class='form-horizontal form-column form-bordered'>
                            @csrf
                            <x-alert/>
                            
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Group Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" value="{{ old('name', isset($master_group)?$master_group->name:'') }}" class="form-control">
                                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>        
                                </div>  
                                <div class="col-sm-4">                                    
                                        <br>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary pull-right"> <i class="fa fa-floppy-o" aria-hidden="true"></i>  SUBMIT </button>
                                    </div>        
                                </div>                                  
                            </div>                           
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>

@endsection