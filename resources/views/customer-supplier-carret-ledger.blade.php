
@extends('layouts.app')
@section('content')
<?php 
use \App\Http\Controllers\commonController;
use \App\Http\Controllers\CustomerLedgerBook;
use \App\Http\Controllers\CustomerSupplierCarretLedger;
use Illuminate\Http\Request;

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$newdate = date("Y-m-d", strtotime("-1 months"));



$fromDate=$newdate;
$toDate=$date;
$partyId=0;

if (isset($_GET['fromDate'])) {
    $fromDate=$_GET['fromDate'];
}

if (isset($_GET['toDate'])) {
    $toDate=$_GET['toDate'];
}

if (isset($_GET['partyId'])) {
    $partyId=$_GET['partyId'];
}

$check_group=['customer'];
if (isset($_GET['check_group'])) {
    $check_group=$_GET['check_group'];
}


?>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Carret Roaker Book List
                        </h3>
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">

                            <!-- Datatable Filter -->
                            <form action="{{ url('/customer-supplier-carret-ledger') }}" method="GET">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Customer/Supplier/Loader </th>
                                    <th>Type</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                        <input type="date" value="{{ $fromDate }}" class="form-control w-200" name="fromDate" id="">                 
                                    </td>
                                    
                                    <td>
                                        <input type="date" value="{{ $toDate }}" class="form-control w-200" name="toDate" id="">                 
                                    </td>

                                    
                                    <td>
                                        <select name="partyId" class="js-select2 w-300" id="partyId">
                                            <option value="">Select All</option>    
                                        </select>
                                    </td>

                                    <td>
                                            <label style="color: white;weight:" class="btn btn-success">
                                                <input type="checkbox" id="customer" value="customer" class="check_group" name="check_group[]" onclick="getCustSuppLoader();"> <b>Customer</b>
                                            </label>

                                            <label style="color: white;weight:" class="btn btn-success">
                                                <input type="checkbox" id="supplier" value="supplier" class="check_group" name="check_group[]" onclick="getCustSuppLoader();"> <b>Supplier</b>
                                            </label>

                                            <label style="color: white;weight:" class="btn btn-success">
                                                <input type="checkbox" id="loader" value="loader" class="check_group" name="check_group[]" onclick="getCustSuppLoader();"> <b>Loader</b>
                                            </label>
                                    </td>
                                   
                                    <td>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                                        <a href="{{ url('/customer-supplier-carret-ledger') }}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Reset</a>
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                            </form>




                            
                            <table id="pagingFalseDataTable" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Particular</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Opening Bal.</th>
                                        <th>
                                            <?php 
                                            $openBalCarret='';
                                                foreach($master_units as $row){
                                                $balCarret = CustomerLedgerBook::getCarretOpenByDate($partyId, $row->id, $fromDate);
                                                $openBalCarret .= $row->name." : ".$balCarret.", ";
                                                }  
                                                echo $openBalCarret;  
                                            ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customerSupplierCarretLedger as $row)
                                    @if($row->particular != '')
                                    <?php 
                                    $unitName = commonController::getValueStatic('master_units','name','id',$row->unitId)
                                    ?>
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                            <td>
                                                @if($row->particular == 'Sale' || $row->particular == 'DR' || $row->particular == 'Loading')
                                                    <b>Caret Out</b>
                                                @endif
                                                @if($row->particular == 'Bijak' || $row->particular == 'CR')
                                                    <b>Caret In</b>
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->particular == 'Sale')
                                                <a target="_blank" href="{{ url('customerSaleReportDetails') }}?date={{ $row->date }}&partyId={{ $partyId }}">
                                                    <b>{{ $unitName." : ".$row->qty }}</b>
                                                </a>                                                    
                                                @endif

                                                @if($row->particular == 'DR')
                                                <a target="_blank" href="{{ url('report-supplier-carret-returns') }}?fromDate={{ $row->date }}&toDate={{ $row->date }}&partyId={{ $partyId }}">
                                                    <b>{{ $unitName." : ".$row->qty }}</b>
                                                </a>                                                    
                                                @endif

                                                @if($row->particular == 'Loading')
                                                <a target="_blank" href="{{ url('loadingEntriesReport') }}?fromDate={{ $row->date }}&toDate={{ $row->date }}&partyId={{ $partyId }}&status=">
                                                    <b>{{ $unitName." : ".$row->qty }}</b>
                                                </a>                                                    
                                                @endif
                                            </td>
                                            <td>                                                
                                                @if($row->particular == 'Bijak')
                                                <a target="_blank" href="{{ url('report-purchase-entry') }}?fromDate={{ $row->date }}&toDate={{ $row->date }}&partyId={{ $partyId }}&billPrintName="></a>
                                                    <b>{{ $unitName." : ".$row->qty }}</b>
                                                @endif
                                                @if($row->particular == 'CR')
                                                <a target="_blank" href="{{ url('report-customer-carret-receive') }}?fromDate={{ $row->date }}&toDate={{ $row->date }}&partyId={{ $partyId }}">
                                                    <b>{{ $unitName." : ".$row->qty }}</b>
                                                </a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($partyId, $row->date)}}
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>  
                                <tfoot>
                                    <tr>
                                        <th>Net Carret :</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            {{ CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($partyId, $toDate)}}
                                        </th>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<script>
    function getCustSuppLoader(id=0){
            var check_group = [];
            $.each($(".check_group:checked"), function(){
                check_group.push($(this).val());
            });            
        
            $.ajax({
            type:'GET',
            url:'{{ url("get-party") }}?key='+check_group,
            success:function(response){
                // console.log(response);
                $("#partyId").html(response);
                $("#partyId").val({{$partyId}});
                $('#partyId').trigger('change'); 
            }
            });
        }
        getCustSuppLoader();
</script>


<script>
    $(document).ready(function(){  
        var check_group = <?php echo json_encode($check_group); ?>;  
        for (let i = 0; i < check_group.length; i++) {
            $('#'+check_group[i]).prop('checked', true);
            getCustSuppLoader();
        }
    });    
</script>




