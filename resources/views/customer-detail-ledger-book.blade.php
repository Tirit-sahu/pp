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
    $fromDate=date('d-m-Y', strtotime($_GET['fromDate']));
}

if (isset($_GET['toDate'])) {
    $toDate=date('d-m-Y', strtotime($_GET['toDate']));
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
                            <i class="fa fa-list-alt" aria-hidden="true"></i>Party Detail Ledger Book
                        </h3>
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">

                            <!-- Datatable Filter -->
                            <form action="{{ url('/ledger-book-details') }}" method="GET">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th width="10%">From Date</th>
                                    <th width="10%">To Date</th>
                                    <th width="40%">Customer/Supplier/Loader </th>
                                    <th width="20%">Type</th>
                                    <th width="20%">Action</th>
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
                                        <a href="{{ url('/ledger-book-details') }}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Reset</a>
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                            </form>




                            
                            <table id="pagingFalseDataTable" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO</th>
                                        <th>Date</th>
                                        <th>Particular</th>
                                        <th>Narration</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Opening Bal.</th>
                                        <th>{{ $openingBlance." Dr." }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $currentBal = $openingBlance; 
                                        $debit = 0;
                                        $credit = 0;      
                                        $extraAmt=0;                                  
                                    ?>
                                    @foreach($CustomerLedgerBook as $row)       
                                                      
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                            <td style="font-weight: bold;">
                                                {{ $row->particular }} 
                                                
                                                <?php 
                                                
                                                if($row->particular == 'Sale'){
                                                    echo ':';
                                                    echo '<br>';
                                                    $sql = "SELECT * FROM `customer_sales` WHERE date BETWEEN '$row->date' AND '$row->date' AND partyId=$row->partyId";
                                                    $LedgerItemDetails = commonController::LedgerItemDetails($sql);
                                                    
                                                    $totalQTY = 0;
                                                    foreach ($LedgerItemDetails as $itemDetail) {                                                    
                                                    $unitRate = 0;
                                                    $totalQTY += $itemDetail->qty;
                                                    $unitRate = commonController::getStaticValueByMultiWhere('custom_unit_rates','rate',['partyId'=>$_GET['partyId'],'unitId'=>$itemDetail->unitId]);
                                                    if($unitRate == '' || $unitRate == null){
                                                        $unitRate = commonController::getValueStatic('master_units',$partType,'id',$itemDetail->unitId);
                                                    }
                                                    
                                                    $extraAmt = $unitRate*$totalQTY;

                                                        $itemName = commonController::getValueStatic('master_items','name','id',$itemDetail->itemId);
                                                        $unitName = commonController::getValueStatic('master_units','name','id',$itemDetail->unitId);

                                                        echo $itemName; 
                                                        echo '<span class="pull-right">'
                                                            .$itemDetail->qty.$unitName
                                                            ." ".$itemDetail->weight."*".$itemDetail->rate
                                                            ." = ".$itemDetail->amount.
                                                            
                                                            '</span><br>';

                                                    }
                                                        echo '<span class="pull-right">Other Charge = '.$extraAmt.'</span>';
                                                
                                                }

                                                $DR_CR_AMT = $row->amount+$extraAmt;
                                                ?>                                            
                                            
                                            </td>
                                            <td>{{ $row->remark }}</td>
                                            <td>
                                                @if($row->particular == 'Sale')
                                                    <a target="_blank" href="{{ url('customerSaleReportDetails?date='.$row->date.'&partyId='.$partyId) }}">
                                                        <b>{{ $DR_CR_AMT }}</b>
                                                    </a>
                                                    <?php 
                                                    $currentBal += $DR_CR_AMT; 
                                                    $debit += $DR_CR_AMT; 
                                                    ?>
                                                @endif
                                                @if($row->particular == 'Loading')
                                                    <a target="_blank" href="{{ url('loadingEntriesReport?fromDate='.$row->date.'&toDate='.$row->date.'&partyId='.$partyId) }}">
                                                        <b>{{ $DR_CR_AMT }}</b>
                                                    </a>
                                                    <?php 
                                                    $currentBal += $DR_CR_AMT; 
                                                    $debit += $DR_CR_AMT; 
                                                    ?>
                                                @endif
                                                @if($row->particular == 'Payment')
                                                    <a target="_blank" href="{{ url('report-purchase-payment-entries?fromDate='.$row->date.'&toDate='.$row->date.'&partyId='.$partyId) }}">
                                                        <b>{{ $row->amount }}</b>
                                                    </a>
                                                    <?php 
                                                    $currentBal += $row->amount; 
                                                    $debit += $row->amount; 
                                                    ?>
                                                @endif
                                                
                                            </td>
                                            <td>
                                                @if($row->particular == 'Recept')
                                                <a target="_blank" href="{{ url('/report-payment-receive?fromDate='.$row->date.'&toDate='.$row->date.'&partyId='.$partyId) }}">
                                                    <b>{{ $row->amount }}</b>
                                                </a>
                                                    <?php 
                                                    $currentBal -= $row->amount; 
                                                    $credit += $row->amount;     
                                                    ?>
                                                @endif
                                                @if($row->particular == 'Bijak')
                                                    <a target="_blank" href="{{ url('/report-purchase-entry?fromDate='.$row->date.'&toDate='.$row->date.'&partyId='.$partyId) }}">
                                                        <b>{{ $DR_CR_AMT }}</b>
                                                    </a>                                                    
                                                    <?php 
                                                    $currentBal -= $DR_CR_AMT; 
                                                    $credit += $DR_CR_AMT;     
                                                    ?>
                                                @endif
                                            </td>
                                            <td>{{ $currentBal." Dr." }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Net Balance:-</th>
                                        <th>{{ $debit }}</th>
                                        <th>{{ $credit }}</th>
                                        <th>{{ $currentBal." Dr." }}</th>
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
        // getCustSuppLoader();        
</script>





<script>
    $(document).ready(function(){  
        var check_group = @php echo json_encode($check_group); @endphp;  
        for (let i = 0; i < check_group.length; i++) {
            $('#'+check_group[i]).prop('checked', true);
            getCustSuppLoader();
        }
    });    
</script>
