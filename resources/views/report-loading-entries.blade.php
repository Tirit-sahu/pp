@extends('layouts.app')
@section('content')
<?php 
use \App\Http\Controllers\commonController;
use Illuminate\Http\Request;

date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');

$fromDate=$date;
$toDate=$date;
$partyId='';
$status = '';
if (isset($_GET['fromDate'])) {
    $fromDate=$_GET['fromDate'];
}

if (isset($_GET['toDate'])) {
    $toDate=$_GET['toDate'];
}

if (isset($_GET['partyId'])) {
    $partyId=$_GET['partyId'];
}

if (isset($_GET['status'])) {
    $status=$_GET['status'];
}

?>
    <div class="container-fluid">
                
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Loader Report   
                        </h3>
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">

                            <!-- Datatable Filter -->
                            <form action="{{ url('/loadingEntriesReport') }}" method="GET">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th width="10%">From Date</th>
                                    <th width="10%">To Date</th>
                                    <th width="30%">Loader </th>
                                    <th width="10%">Status</th>
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
                                            @foreach($loader as $row)
                                            <option @if($partyId==$row->id) selected @endif value="{{ $row->id }}">{{ $row->name }}</option> 
                                            @endforeach                                            
                                        </select>
                                    </td>

                                    <td>
                                        <?php 
                                        $statusArray = array('Pending', 'Complete');    
                                        ?>
                                        <select name="status" class="js-select2 w-200" id="status">
                                            <option value="">Select All</option>    
                                            @foreach($statusArray as $sts)
                                            <option @if($status==$sts) selected @endif value="{{ $sts }}">{{ $sts }}</option> 
                                            @endforeach                                            
                                        </select>
                                    </td>
                                   
                                    <td>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                                        <a href="{{ url('/loadingEntriesReport') }}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Reset</a>
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                            </form>




                            
                            <table id="myTable2" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>All</th>
                                        <th>Loader</th>
                                        <th>Date</th>
                                        <th>Bill Amount</th>
                                        <th>Net Amount</th>
                                        <th>Profit/Loss</th>
                                        <th>Print</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalAmount=0; @endphp
                                    @foreach($loading_entries as $row)
                                    @php $totalAmount += $row->totalAmount; @endphp
                                        <tr>
                                            <td>
                                                <input type="checkbox">
                                            </td>
                                            <td>{{ commonController::getValueStatic('master_customer_suppliers','name','id',$row->partyId) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                            <td>{{ $row->totalAmount }}</td>
                                            <td>{{ $row->netAmount }}</td>
                                            <td>
                                                {{ $row->netAmount-$row->totalAmount }}
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-primary" rel="tooltip" title="Print">
                                                    A6
                                                </a>                                                
                                                <a href="#" class="btn btn-warning" rel="tooltip" title="Print">
                                                    A6
                                                </a>
                                            </td>
                                            <td class='hidden-480'>                                                
                                                
                                                <a href="{{ url('/loading_entries') }}?id={{ $row->id }}" class="btn btn-success" rel="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a onclick="return confirm('Are you sure ?')" href="{{ url('loading-entry-delete') }}?id={{ $row->id }}" class="btn btn-danger" rel="tooltip" title="Delete">
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
                                        <th>{{ $totalAmount }}</th>
                                        <th></th>
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