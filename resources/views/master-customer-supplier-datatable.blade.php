@extends('layouts.app')
@section('content')
<?php 
use \App\Http\Controllers\commonController;
use Illuminate\Http\Request;
?>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Customer/Supplier Datatable   
                        </h3>
                        <a href="{{ url('/master-customer-supplier') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Add New Customer/Supplier" }}</a>
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">
                            <table id="myTable2" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Name</th>
                                        <th>Name<br>Hindi</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Opening <br>Balancee</th>
                                        <th>Credit <br>Limit Amount</th>
                                        <th>Credit <br>Limit Transaction</th>        
                                        <th>Type</th>    
                                        <th>Group Name</th>   
                                        <th>Photo</th>  
                                        <th>Status</th>              
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($master_customer_suppliers as $row)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->nameHindi }}</td>
                                            <td>{{ $row->mobile }}</td>
                                            <td>{{ $row->address }}</td>
                                            <td>{{ $row->openingBalance }} {{ $row->balanceType }} </td>
                                            <td>{{ $row->creditLimitAmount }}</td>
                                            <td>{{ $row->creditLimitTransaction }}</td>
                                            <td>
                                                <?php 
                                                if($row->customer==1){
                                                    echo "Customer<br>";
                                                }
                                                if($row->supplier==1){
                                                    echo "Supplier<br>";
                                                }
                                                if($row->loader==1){
                                                    echo "Loader<br>";
                                                }
                                                ?> 
                                            </td>
                                            <td>{{ commonController::getValueStatic('master_groups','name','id',$row->groupName) }}</td>
                                           
                                            <td>
                                                @if(isset($row->photo))
                                                <a target="_blank" href="{{ asset('public/storage/DOCCustomerSupplierLoader/'.$row->photo) }}">
                                                    <img width="40" src="{{ asset('public/storage/DOCCustomerSupplierLoader/'.$row->photo) }}" alt="Doc">
                                                </a>
                                                @endif
                                            </td>
                                            <td>{{ $row->status }}</td>                                           
                                            <td class='hidden-480'>                                           
                                                <a href="{{ url('master-customer-supplier-edit/'.$row->id) }}" class="btn" rel="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ url('common-destroy?table=master_customer_suppliers&key=id&value='.$row->id) }}" class="btn" rel="tooltip" title="Delete">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>

@endsection