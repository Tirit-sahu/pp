<?php
use \App\Http\Controllers\OtherIncomeAndExpensesController;
use Illuminate\Http\Request;
?>

@extends('layouts.app')
@section('content')
<?php 

   $button='SAVE';
   $action=url('other-income-expenses-store');
  
   $name='';
   $nameHindi='';
   $type='';
   if(isset($editData)){
       $name=$editData->name;
       $nameHindi=$editData->nameHindi;
       $type=$editData->type;
      
     
       $button='UPDATE';
       $action=url('other-income-expenses-update/'.$editData->id);
   }
   ?>

<div class="box box-color box-bordered" style="padding-top:100px;">
   <div class="box-title">
      <h3>
      <i class="fa fa-user-circle-o" ></i>

         <b> Income/Expenses Head</b>
      </h3>
   </div>
</div>
</p>
<br><br>
<x-alert/>
<div class="container-fluid">
   <form action="{{ $action }}" method="post">
      @csrf
      <div class = "row">
         <div class="col-md-4"></div>
         <div class="col-md-4">
            Income/Exp. Head Name*
            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
            <input type="text" class="form-control" id="" name="name" value="{{ $name }}" required>
            <br>
            Income/Exp. Head Hindi*
            <input type="text" class="form-control" id="" name="nameHindi" value="{{ $nameHindi }}" required>
            <br>
            Type*
            <select class="form-control" name="type" id="" value= "" required>
               <option value="">{{ $type }}</option>
               <option value="income">income</option>
               <option value="Expenses">Expenses</option>
            </select>
            <hr>
            <button class = "btn btn-primary" type ="submit" >{{$button}}</button>
            <a href="{{ url('/other-income-expenses') }}" class = "btn btn-success">Reset</a>
          
         </div>
      </div>
   </form>
   <div class="box box-color box-bordered">
      <div class="box-title">
         <h3>
            <i class="fa fa-table"></i>
           table
         </h3>
      </div>
      <div class="box-content nopadding">
         <table class="table table-hover table-nomargin">
            <thead>
               <tr>
                  <th>S No.</th>
                  <th>Name</th>
                  <th class="hidden-350">Name Hindi</th>
                  <th class="hidden-350">Type</th>
                  
                  <th class="hidden-480">Option</th>
               </tr>
            </thead>
            <tbody>
            @foreach($data as $row)
               <tr>
            
                  <td>{{ $loop->index+1 }}</td>
                  <td> {{$row->name}} </td>

                  <td class="hidden-350">{{$row->nameHindi}}</td>
                  <td> {{$row->type}} </td>
                  <td class="hidden-1024">
                  <a href="{{ url('other-income-expenses-edit/'.$row->id) }}" class = "btn btn-success">Edit</a>
                  <!-- <button class = "btn btn-success" type ="">Edit</button> -->
                  <a href="{{ url('other-income-expenses-delete/'.$row->id) }}" class="btn btn-danger" onclick="return confirm('Are You Sure?');">Delete</a>
           
                  </td>
               
               </tr>
               @endforeach
            </tbody>
         </table>
         <div class="table-pagination">
            <a href="#" class="disabled">First</a>
            <a href="#" class="disabled">Previous</a>
            <span>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            </span>
            <a href="#">Next</a>
            <a href="#">Last</a>
         </div>
      </div>
   </div>
</div>
@endsection