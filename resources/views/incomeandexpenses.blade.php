<?php
use \App\Http\Controllers\OtherIncomeAndExpensesController;
use \App\Http\Controllers\commonController;
use Illuminate\Http\Request;
?>

@extends('layouts.app')
@section('content')

<?php 

   $button='SAVE';
   $action=url('income-and-expenses-store');
  
   $name='';
   $date='';
   $Type='';
   $Amount='';
   $Remark='';
   if(isset($editData)){
       $name=$editData->name;
       $date=$editData->date;
       $Type=$editData->Type;
       $Amount=$editData->Amount;
       $Remark=$editData->Remark;
      
     
       $button='UPDATE';
       $action=url('income-and-expenses-update/'.$editData->id);
   }
   ?>

<div class="row">
<div class="col-sm-12">
<div class="box box-color">
<div class="box-title">
   <h3>
      <i class="fa fa-list-alt" aria-hidden="true"></i> <span id="formTitle">Income And Expenses</span>   
   </h3>
   <!-- <a href="{{ url('/loadingEntriesReport') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> Today Bill</a> -->
</div>
<div class="box-content">
<form action="{{ $action }}" method="POST"  class='orm-vertical' id="">
@csrf
<x-alert/>

<div class="panel panel-default">
   <div class="panel-body">
      <table class="table">
         <thead>
            <tr>
               <th>Date</th>
               <th>HeadName</th>
               <th>Type</th>
               <th>Amount</th>
               <th>Remark</th>
               <th></th>
               <th></th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td>
                  <input type="date" name="date" value="{{ $date }}" id="" placeholder="" class="form-control w-200">
               </td>
               <td>
                  <select name="name" class="js-select2 w-300" id="">
                     <option value="{{ $name }}">{{$name}}</option>
                     @foreach($rdata as $row)
                     <option value="{{ $row->id }}">{{ $row->name }}</option>
                     @endforeach                                          
                  </select>
               </td>
               <td>
                  <select name="Type" class="js-select2 w-300" id="">
                     <option value="{{ $Type }}">{{$Type}} </option>
                     <option value="Income">Income</option>
                     <option value="Expenses">Expenses</option>
                  </select>
               </td>
               <td>
                  <input type="text" name="Amount" value="{{ $Amount }}" placeholder="" class="form-control w-200">
               </td>
               <td>
                  <input type="text" name="Remark" value="{{ $Remark }}" placeholder="" class="form-control w-200">
               </td>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td colspan="12">
               <button class = "btn btn-primary" type ="submit" >{{$button}}</button>
                  <a href="{{url('/incomeandexpenses')}}" class="btn btn-success">Reset</a>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<div class="panel panel-default">
   <div class="panel-body">
      <table class="table table-bordered">
         <thead>
            <tr>
               <th>SNO.</th>
               <th>HeadName</th>
               <th>Type</th>
               <th>Amount</th>
               <th>Remark</th>
               <th>Option</th>
            </tr>
            <tr>
            @foreach($data as $row)
               <td>{{ $loop->index+1 }}</td>
               <td>{{ commonController::getValueStatic('other_income_and_expenses','name','id',$row->name) }}</td>
               <td>{{ $row->Type }}</td>
               <td>{{ $row->Amount }}</td>
               <td>{{ $row->Remark }}</td>
               <td>
               <a href="{{ url('income-and-expenses-edit/'.$row->id) }}" class = "btn btn-success">Edit</a>
                  <!-- <button class = "btn btn-success" type ="">Edit</button> -->
                  <a href="{{ url('income-and-expenses-delete/'.$row->id) }}" class="btn btn-danger" onclick="return confirm('Are You Sure?');">Delete</a>
           
               </td>
               @endforeach
            </tr>
         </thead>
         <tbody id="">                               
         </tbody>
      </table>
   </div>
</div>
@endsection