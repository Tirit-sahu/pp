@extends('layouts.app')
@section('content')
<?php 
use \App\Http\Controllers\commonController;
use \App\Http\Controllers\CustomerLedgerBook;
use Illuminate\Http\Request;

$groupName=0;
$minAmt='';
$name = '';


if (isset($_GET['groupName'])) {
    $groupName=$_GET['groupName'];
}
if(isset($_GET['minAmt'])){
    $minAmt=$_GET['minAmt'];
}
if(isset($_GET['name'])){
    $name=$_GET['name'];
}



?>
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Party Balance report
                        </h3>
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">                            

                            <!-- Datatable Filter -->
                            <form action="{{ url('/party-balance-report') }}" method="GET">                                
                            <table class="table">
                                <thead>
                                  <tr>                                   
                                    <th width="20%">Group Name</th>
                                    <th width="10%">Min. Amt</th>
                                    <th width="10%">Customer Name</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                   
                                    <td>
                                        <select name="groupName" class="js-select2" id="groupName">
                                            <option value="">Select All</option>    
                                        </select>
                                    </td>                                 

                                    <td>
                                        <input type="text" class="form-control" name="minAmt" value="{{ $minAmt }}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" name="name" value="{{ $name }}">
                                    </td>
                                   
                                    <td>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                                        <a href="{{ url('/party-balance-report') }}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Reset</a>
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                            </form>



                            <div class="pull-right">

                                <a href="" class="btn btn-warning">A4</a>

                                <a href="" class="btn btn-warning">A5</a>

                                <a target="_blank" href="{{ url('PDFPartyBalanceReportA4') }}" class="btn btn-warning">Carret Bal A4</a>

                                <a target="_blank" href="{{ url('PDFPartyBalanceReportA4') }}" class="btn btn-primary">A4</a>

                                <a target="_blank" href="{{ url('PDFPartyBalanceReportA4') }}" class="btn btn-primary">A5</a>
                                
                            </div>
                            
                            <table class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO</th>
                                        <th>Customer Name</th>
                                        <th>Mobile No.</th>
                                        <th>Balance Amt</th>
                                        @foreach($master_units as $unit)
                                        <th>{{ $unit->name }}</th>
                                        @endforeach
                                    </tr>
                                   
                                </thead>
                                <tbody>
                                   
                                    @foreach($parties as $index => $row)  
                                    <?php 
                                    date_default_timezone_set('Asia/Kolkata');
                                    $date = date('Y-m-d');
                                    
                                    $partyBalance = CustomerLedgerBook::partyBalance($row->id, $row->openingBalance);
                                    if($minAmt!=''){
                                        if($partyBalance > $minAmt){
                                            ?>
                                            <tr>
                                                <td>{{ $index + $parties->firstItem() }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->mobile }}</td>
                                                <td>{{ $partyBalance }}</td>
                                                @foreach($master_units as $unit)
                                                <td>
                                                    {{ CustomerLedgerBook::getCarretOpenByDate($row->id, $unit->id, $date) }}
                                                </td>
                                                @endforeach
                                            </tr>
                                        <?php
                                        }
                                    }else{
                                        ?>
                                            <tr>
                                                <td>{{ $index + $parties->firstItem() }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->mobile }}</td>
                                                <td>{{ $partyBalance }}</td>
                                                @foreach($master_units as $unit)
                                                <td>
                                                    {{ CustomerLedgerBook::getCarretOpenByDate($row->id, $unit->id, $date) }}
                                                </td>
                                                @endforeach
                                            </tr>
                                        <?php
                                    }
                                    ?>                                     
                                    @endforeach
                                </tbody>

                                
                            </table>
                            {{ $parties->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>


@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function getCustSuppLoader(){
           
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select2") }}?table=master_groups&id=id&column=name',
            success:function(response){
                console.log(response);
                $("#groupName").html(response);
                $("#groupName").val(@php echo $groupName; @endphp);
                $('#groupName').trigger('change'); 
            }
            });

        }
        getCustSuppLoader();
        
</script>


