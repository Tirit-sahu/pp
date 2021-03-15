@extends('layouts.app')
@section('content')

<?php 
    $action=url('/master-bijak-print-name-store');
    $button='SUBMIT';
    $formTitle = 'Bijak Print Name ';
if (isset($master_bijak_print_names)) {
    $action=url('/master-bijak-print-name-update', array($master_bijak_print_names->id));
    $button='UPDATE';
    $formTitle = 'Edit Bijak Print Name';
}
?>

    <div class="container-fluid">
           
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> {{ $formTitle }} 
                        </h3>
                        <a href="{{ url('/master-bijak-print-name-show') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i>Report Datatables</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class='form-inline'>
                            @csrf
                            <x-alert/>
                                <br><br>
                            <center>
                                    <div class="form-group mx-sm-3 mb-2">
                                    <label for="inputPassword2" class="sr-only">Pirnt Name EN</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', isset($master_bijak_print_names)?$master_bijak_print_names->name:'') }}" placeholder="Pirnt Name EN">
                                    </div>
        
                                    <div class="form-group mx-sm-3 mb-2">
                                    <label for="inputPassword2" class="sr-only">Pirnt Name HI</label>
                                    <input type="text" class="form-control" name="nameHindi" value="{{ old('nameHindi', isset($master_bijak_print_names)?$master_bijak_print_names->nameHindi:'') }}" placeholder="Pirnt Name HI">
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2">{{ $button }}</button>        
                            </center>                        
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>


@endsection
