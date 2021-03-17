@extends('layouts.app')
@section('content')
<?php 
use \App\Http\Controllers\commonController;
use Illuminate\Http\Request;

date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');

$fromDate=$date;
$partyId='';
$toDate=$date;

if (isset($_GET['fromDate'])) {
    $fromDate=$_GET['fromDate'];
}

if (isset($_GET['toDate'])) {
    $toDate=$_GET['toDate'];
}

if (isset($_GET['partyId'])) {
    $partyId=$_GET['partyId'];
}

?>
    <div class="container-fluid">
                
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Customer Carret Receive Report    
                        </h3>
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">

                            <!-- Datatable Filter -->
                            <form action="{{ url('report-customer-carret-receive') }}" method="GET">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th width="10%">From Date</th>
                                    <th width="10%">To Date</th>
                                    <th width="30%">Customer </th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                        <input type="text" value="{{ $fromDate }}" class="form-control datemask" name="fromDate" id="">                 
                                    </td>
                                    
                                    <td>
                                        <input type="text" value="{{ $toDate }}" class="form-control datemask" name="toDate" id="">                 
                                    </td>

                                    
                                    <td>
                                        <select name="partyId" class="js-select2" id="customerId">
                                            <option value="">Select All</option>    
                                            @foreach($customer as $row)
                                            <option @if($partyId==$row->id) selected @endif value="{{ $row->id }}">{{ $row->name }}</option> 
                                            @endforeach                                            
                                        </select>
                                    </td>
                                   
                                    <td>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                                        <a href="{{ url('/report-customer-carret-receive') }}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Reset</a>
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                            </form>




                            
                            <table id="myTable2" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Carret Type</th>
                                        <th>Return QTY</th>
                                        <th>Discount</th>
                                        <th>Narration</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $TQTY=0; $TDIS = 0; @endphp
                                    @foreach($customer_carret_receives as $row)
                                    @php $TQTY += $row->qty; $TDIS += $row->discount; @endphp
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ commonController::getValueStatic('master_customer_suppliers','name','id',$row->partyId) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                            <td>{{ commonController::getValueStatic('master_units','name','id',$row->unitId) }}</td>
                                            <td>{{ $row->qty }}</td>
                                            <td>{{ $row->discount }}</td>
                                            <td>{{ $row->narration }}</td>
                                            <td class='hidden-480'>                                                
                                                <a href="{{ route('PdfCarretReceiveA6') }}?id={{ $row->id }}&date={{ $row->date }}" target="_blank" class="btn btn-primary" rel="tooltip" title="Print">
                                                    A6
                                                </a>
                                                
                                                <a href="{{ route('PdfCarretReceiveHindiA6') }}?id={{ $row->id }}&date={{ $row->date }}" target="_blank"  class="btn btn-warning" rel="tooltip" title="Print">
                                                    A6
                                                </a>

                                                <a href="{{ url('/customer-carret-receive') }}?id={{ $row->id }}" class="btn btn-success" rel="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a onclick="return confirm('Are you sure ?')" href="{{ url('common-destroy?table=customer_carret_receives&key=id&value='.$row->id) }}" class="btn btn-danger" rel="tooltip" title="Delete">
                                                    <i class="fa fa-times"></i>
                                                </a>                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total:</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ $TQTY }}</th>
                                        <th>{{ $TDIS }}</th>
                                        <th></th>      
                                        <th></th>                              
                                    </tr>
                                </tfoot>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>


@endsection

