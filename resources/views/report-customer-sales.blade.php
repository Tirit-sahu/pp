@extends('layouts.app')
@section('content')
<?php 
use \App\Http\Controllers\commonController;
use Illuminate\Http\Request;

date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$newdate = date("d-m-Y", strtotime("-1 months"));

$fromDate=$date;
$toDate=$date;
$partyId='';
$farmerId='';

if (isset($_GET['fromDate'])) {
    $fromDate=$_GET['fromDate'];
}

if (isset($_GET['toDate'])) {
    $toDate=$_GET['toDate'];
}

if (isset($_GET['partyId'])) {
    $partyId=$_GET['partyId'];
}

if (isset($_GET['farmerId'])) {
    $farmerId=$_GET['farmerId'];
}

?>
    <div class="container-fluid">
                
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Customer Sale Report   
                        </h3>
                        {{-- <a href="{{ url('/master-unit') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ "Add New Unit" }}</a> --}}
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">

                            <!-- Datatable Filter -->
                            <form action="{{ url('customerSaleReport') }}" method="GET">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th width="8%">From Date</th>
                                    <th width="8%">To Date</th>
                                    <th width="20%">Customer </th>
                                    <th width="20%">Farmer</th>
                                    <th width="10%">Action</th>
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
                                        <select name="farmerId" class="js-select2" id="farmerId">
                                            <option value="">Select All</option>                                              
                                            @foreach($supplier as $row)
                                            <option @if($farmerId==$row->id) selected @endif value="{{ $row->id }}">{{ $row->name }}</option> 
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                                        <a href="{{ url('/customerSaleReport') }}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Reset</a>
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
                                        <th>Bill Date</th>
                                        <th>Amount</th>
                                        <th>Print</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach($customer_sales as $row)
                                    <?php 
                                        $partType = commonController::getPartyTypeStatic($row->partyId);
                                        $unitRate = 0;
                                        $unitRate = commonController::getStaticValueByMultiWhere('custom_unit_rates','rate',['partyId'=>$row->partyId,'unitId'=>$row->unitId]);
                                        if($unitRate == '' || $unitRate == null){
                                        $unitRate = commonController::getValueStatic('master_units',$partType,'id',$row->unitId);                                        
                                        }
                                        $extraAmt = $unitRate*$row->qty;
                                    ?>
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>{{ commonController::getValueStatic('master_customer_suppliers','name','id',$row->partyId) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                            <td>{{ $row->amount+$extraAmt }}</td>
                                            <td>
                                                <a target="_blank" href="{{ url('PDFCustomerSaleA4') }}?partyId={{ $row->partyId }}&date={{ $row->date }}" class="btn btn-primary" rel="tooltip" title="Print EN A4">
                                                    <i class="fa fa-print" aria-hidden="true"></i> A4
                                                </a>
                                                <a target="_blank" href="{{ url('PDFCustomerSaleA5') }}?partyId={{ $row->partyId }}&date={{ $row->date }}" class="btn btn-primary" rel="tooltip" title="Print A5">
                                                    <i class="fa fa-print" aria-hidden="true"></i> A5
                                                </a>
                                                <a target="_blank" href="{{ url('PDFCustomerSaleA6') }}?partyId={{ $row->partyId }}&date={{ $row->date }}" class="btn btn-primary" rel="tooltip" title="Print A6">
                                                    <i class="fa fa-print" aria-hidden="true"></i> A6
                                                </a>

                                                <a onclick="window.open('{{ url('PDFCustomerSaleHiA4') }}?partyId={{ $row->partyId }}&date={{ $row->date }}','popup'); return false;" href="{{ url('PDFCustomerSaleHiA4') }}?partyId={{ $row->partyId }}&date={{ $row->date }}" class="btn btn-warning" rel="tooltip" title="Print HI A4">
                                                    <i class="fa fa-print" aria-hidden="true"></i> A4
                                                </a>

                                                <a onclick="window.open('{{ url('PDFCustomerSaleHiA5') }}?partyId={{ $row->partyId }}&date={{ $row->date }}','popup'); return false;" href="{{ url('PDFCustomerSaleHiA5') }}?partyId={{ $row->partyId }}&date={{ $row->date }}" class="btn btn-warning" rel="tooltip" title="Delete">
                                                    <i class="fa fa-print" aria-hidden="true"></i> A5
                                                </a>

                                                <a onclick="window.open('{{ url('PDFCustomerSaleHiA6') }}?partyId={{ $row->partyId }}&date={{ $row->date }}','popup'); return false;" href="{{ url('PDFCustomerSaleHiA6') }}?partyId={{ $row->partyId }}&date={{ $row->date }}" class="btn btn-warning" rel="tooltip" title="Delete">
                                                    <i class="fa fa-print" aria-hidden="true"></i> A6
                                                </a>

                                            </td>
                                            <td class='hidden-480'>
                                           
                                                <a href="{{ url('customerSaleReportDetails') }}?date={{ $row->date }}&partyId={{ $row->partyId }}" class="btn btn-inverse btn--icon" rel="tooltip" title="View">
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

