@extends('layouts.app')
@section('content')
<?php 
use \App\Http\Controllers\commonController;
use Illuminate\Http\Request;

date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$newdate = date("d-m-Y", strtotime("-1 months"));

$fromDate=$newdate;
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
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Payment Receive Report   
                        </h3>
                        {{-- <a href="{{ url('/master-unit') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ "Add New Unit" }}</a> --}}
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">

                            <!-- Datatable Filter -->
                            <form action="{{ url('report-payment-receive') }}" method="GET">
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
                                        <select name="partyId" class="js-select2" id="partyId">
                                            <option value="">Select All</option>    
                                            @foreach($customer as $row)
                                            <option @if($partyId==$row->id) selected @endif value="{{ $row->id }}">{{ $row->name }}</option> 
                                            @endforeach                                            
                                        </select>
                                    </td>
                                   
                                    <td>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                                        <a href="{{ url('/report-payment-receive') }}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Reset</a>
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                            </form>




                            
                            <table id="myTable2" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>All</th>
                                        <th>Customer</th>
                                        <th>Payment Date</th>
                                        <th>Paid Amount</th>
                                        <th>Discount Amount</th>
                                        {{-- <th>Print</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach($customer_sales_payment_receives as $row)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ commonController::getValueStatic('master_customer_suppliers','name','id',$row->partyId) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                            <td>{{ $row->amount }}</td>
                                            <td>{{ $row->discount }}</td>
                                            
                                            <td class='hidden-480'>
                                           
                                                <a href="{{ url('paymentReceiveReportDetails') }}?date={{ $row->date }}&customerId={{ $row->partyId }}" class="btn btn-inverse btn--icon" rel="tooltip" title="View">
                                                    <i class="fa fa-eye"></i>View
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

