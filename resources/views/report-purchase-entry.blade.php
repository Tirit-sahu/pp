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
$billPrintName='';

if (isset($_GET['fromDate'])) {
    $fromDate=$_GET['fromDate'];
}

if (isset($_GET['toDate'])) {
    $toDate=$_GET['toDate'];
}

if (isset($_GET['partyId'])) {
    $partyId=$_GET['partyId'];
}

if (isset($_GET['billPrintName'])) {
    $billPrintName=$_GET['billPrintName'];
}

?>
    <div class="container-fluid">
            
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Purchase Entry Report  
                        </h3>
                        {{-- <a href="{{ url('/master-unit') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ "Add New Unit" }}</a> --}}
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">

                            <!-- Datatable Filter -->
                            <form action="{{ url('/report-purchase-entry') }}" method="GET">
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th width="10%">From Date</th>
                                        <th width="10%">To Date</th>
                                        <th width="30%">Supplier </th>
                                        <th width="20%">Pirnt Name</th>
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
                                                <option value="">Select ALL</option>    
                                                @foreach($master_customer_suppliers as $row)
                                                <option @if($partyId==$row->id) selected @endif value="{{ $row->id }}">{{ $row->name }}</option> 
                                                @endforeach                                            
                                            </select>
                                        </td>
                                        <td>
                                            <?php 
                                            $printNameArray = array("Yes", "No");    
                                            ?>
                                            <select name="billPrintName" class="js-select2" id="billPrintName">
                                                <option value="">Select</option>                                              
                                                @foreach($printNameArray as $printName)
                                                <option @if($printName==$billPrintName) selected @endif value="{{ $printName }}">{{ $printName }}</option> 
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                                            <a href="{{ url('/report-purchase-entry') }}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Reset</a>
                                        </td>
                                      </tr>
                                      
                                    </tbody>
                                  </table>
                                </form>

                           
                            
                            <table id="myTable2" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Purchase Date</th>
                                        <th>Supplier Name</th>
                                        <th>Print Name</th>   
                                        <th>Vehicle Number</th>   
                                        <th>Amount</th>
                                        <th>Print</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase_entries as $row)
                                   
                                        <tr>
                                            <td>
                                                <input type="checkbox">
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                            <td>{{ commonController::getValueStatic('master_customer_suppliers','name','id',$row->partyId) }}</td>                                           
                                            <td>{{ commonController::getValueStatic('master_bijak_print_names','name','id',$row->billPrintName) }}</td>
                                            <td>{{ $row->vehicleNumber }}</td>                                           
                                            <td>{{ $row->totalAmt }}</td>
                                            

                                            <td class='hidden-480'>                                           
                                                <a href="{{ route('PDFpurchaseEnteryA4') }}?id={{ $row->id }}" target="_blank" class="btn btn-primary btn--icon" rel="tooltip" title="View">
                                                    <i class="fa fa-print"></i>A4
                                                </a>
                                                <a href="{{ route('PDFpurchaseEnteryA5') }}?id={{ $row->id }}" target="_blank" class="btn btn-primary btn--icon" rel="tooltip" title="View">
                                                    <i class="fa fa-print"></i>A5
                                                </a>
                                                <a href="{{ route('PDFpurchaseEnteryA4Hindi') }}?id={{ $row->id }}" target="_blank" class="btn btn-warning btn--icon" rel="tooltip" title="Print Hindi">
                                                    <i class="fa fa-print"></i>A4
                                                </a>
                                                <a href="{{ route('PDFpurchaseEnteryA5Hindi') }}?id={{ $row->id }}" target="_blank" class="btn btn-warning btn--icon" rel="tooltip" title="Print Hindi">
                                                    <i class="fa fa-print"></i>A5
                                                </a>                                           
                                            </td>

                                            <td class='hidden-480'>                                           
                                                <a href="{{ url('/purchase-entry') }}?id={{ $row->id }}" class="btn btn-inverse btn--icon" rel="tooltip" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="{{ url('/purchase-entry-delete?id='.$row->id) }}" class="btn btn-danger btn--icon" rel="tooltip" title="Delete">
                                                    <i class="fa fa-trash"></i>
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

