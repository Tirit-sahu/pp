@extends('layouts.app')
@section('content')

<?php 
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
?>

    <div class="container-fluid">
            
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> <span id="formTitle">Loading Entry</span>   
                        </h3>
                        <a href="{{ url('/loadingEntriesReport') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> Today Bill</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ url('submitLoadingEntryData') }}" method="POST" enctype="multipart/form-data" class='orm-vertical' id="loadingEntryForm">
                            @csrf
                            <x-alert/>
                            
                            <input type="hidden" name="loadingEntryId" value="0" id="loadingEntryId">
                            <input type="hidden" name="loadingEntryDetailsId" id="loadingEntryDetailsId">

                            <div class="panel panel-default">
                                <div class="panel-body">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th>Date</th>
                                    <th>Loader
                                        <label style="cursor: pointer;" class="text-danger" for="getAllParty">SHOW ALL <input type="checkbox" id="getAllParty"></label> 
                                    </th>
                                    <th>Vehicle</th>
                                    <th>Farmer
                                        <label style="cursor: pointer;" class="text-danger" for="getAllParty2">SHOW ALL <input type="checkbox" id="getAllParty2"></label>     
                                    </th>                                    
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                        <input type="text" name="date" value="{{ $date }}" id="date" placeholder="" class="form-control w-200" tabindex="1">
                                    </td>
                                    <td>
                                        <select name="partyId" class="js-select2 w-300" id="loaderId" tabindex="2">
                                            <option value="">Select Loader</option>                                                
                                        </select>
                                    </td>                                   
                                    <td>
                                        <input type="text" name="vehicleNumber" id="vehicleNumber" placeholder="" class="form-control w-200" tabindex="3">
                                    </td>    
                                    <td>
                                        <select name="farmerId" class="js-select2 w-300" id="farmerId" tabindex="4">
                                            <option value="">Select Farmer</option>                                                
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <th>
                                        Item Name
                                        <span id="lockDiv"><input type="checkbox" id="checkLock"></span>
                                    </th>
                                    <th>Rate</th>
                                    <th>First Unit</th>
                                    <th>QTY</th>
                                    <th>KG/Unit</th>
                                    <th>Action</th>
                                  </tr>
                                  <tr>
                                    <td>                             
                                        <select class="js-select2 w-200" id="itemId" onchange="getLockValue(this.value)" tabindex="5">    
                                            <option value="">Select Item</option>                                        
                                        </select>
                                    </td>
                                    
                                    <td>
                                        <input type="number" id="rate" placeholder="" class="form-control w-100" tabindex="6">
                                    </td>
                                    <td>
                                        <select class="js-select2 w-200" id="unitId" tabindex="7">    
                                            <option value="">Select Item</option>                                        
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" id="qty" placeholder="" class="form-control w-100" tabindex="8">
                                    </td>
                                    <td>
                                        <input type="number" id="weight" placeholder="" class="form-control w-100" tabindex="9">
                                    </td>
                                    <td>
                                        <button onclick="AddItems()" type="button" class="btn btn-primary" tabindex="10"> 
                                        <span id="CHANGEBUTTON">
                                            <i class="fa fa-plus" aria-hidden="true"></i>  ADD
                                        </span>
                                        </button>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            </div>


                            


                            
                            <div class="panel panel-default">
                                <div class="panel-body">

                                <span style="font-size: 16px;" class="btn btn-primary">Total Amount: <span id="totalItemAmount">00</span></span>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Item Name</th>
                                        <th>Rate</th>
                                        <th>First Unit</th>
                                        <th>QTY</th>                                        
                                        <th>KG/Unit</th>                                        
                                        <th>Amount</th>
                                        <th>Action</th>
                                      </tr>
                                </thead>
                                <tbody id="showLoadingEntryDetails">                               
                                  
                                </tbody>
                              </table>
                            </div>
                            </div>



                            <div class="panel panel-default">
                                <div class="panel-body">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th>Bhada</th>
                                    <th>Advance</th>
                                    <th>Driver Inaam</th>
                                    <th>Total Bhada</th>                                    
                                    <th>Total Amount</th>
                                    <th></th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>
                                        <input type="text" name="motorBhada" value="" id="motorBhada" placeholder="" class="form-control w-100" tabindex="11">
                                    </td>
                                    <td>
                                        <input type="text" name="advance" value="" onkeyup="calcTotalAmount()" id="advance" placeholder="" class="form-control w-100" tabindex="12">
                                    </td>                                   
                                    <td>
                                        <input type="text" name="driverInaam" value="" id="driverInaam" placeholder="" class="form-control w-100" tabindex="13">
                                    </td>    
                                    <td>
                                        <input type="text" name="totalBhada" value="" id="totalBhada" placeholder="" class="form-control w-100" tabindex="14">
                                    </td> 
                                    <td>
                                        <input type="text" name="totalAmount" value="" id="totalAmount" placeholder="" readonly class="form-control w-150" tabindex="15">
                                    </td> 
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <th>Driver Mobile</th>
                                    <th>Narration</th>
                                    <th></th>
                                    <th></th>
                                    <th>Net Amount</th>
                                    <th></th>
                                    <th></th>
                                  </tr>
                                  <tr>
                                    <td>
                                        <input type="text" name="driverMobile" id="driverMobile" placeholder="" maxlength="10" class="form-control w-150" tabindex="16">
                                    </td>
                                    <td colspan="3">
                                        <input type="text" name="narration" id="narration" placeholder="" class="form-control" tabindex="17">
                                    </td>
                                    <td>
                                        <input type="text" name="netAmount" value="0" id="netAmount" placeholder="" class="form-control w-150" tabindex="18">                                    
                                    </td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            </div>


                     
                            
                            
                            <div class="form-actions">
                                <center>
                                    <button type="submit" class="btn btn-primary" tabindex="19"> <i class="fa fa-floppy-o" aria-hidden="true"></i>  SUBMIT </button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>


@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        
        $('#getAllParty').change(function() {
        if(this.checked) {
            $.ajax({
                type:'GET',
                url:'{{ url("common-get-select2") }}?table=master_customer_suppliers&id=id&column=name',
                success:function(res){
                    // console.log(res);
                    $("#loaderId").html(res);
                    $("#loaderId").val(id);
                    $('#loaderId').trigger('change');
                }
            });
        }else{
            getLoader();
        }
        });

        $('#getAllParty2').change(function() {
        if(this.checked) {
            $.ajax({
                type:'GET',
                url:'{{ url("common-get-select2") }}?table=master_customer_suppliers&id=id&column=name',
                success:function(res){
                    // console.log(res);
                    $("#farmerId").html(res);
                    $("#farmerId").val(id);
                    $('#farmerId').trigger('change');
                }
            });
        }else{
            getFarmer();
        }
        });

    });
</script>

<script>

        function getFarmer(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select") }}?table=master_customer_suppliers&id=id&key=supplier&value=1&column=name',
            success:function(response){
                // console.log(response);
                $("#farmerId").html(response);
                $("#farmerId").val(id);
                $('#farmerId').trigger('change'); 
            }
            });
        }
        getFarmer();


        function getLoader(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select") }}?table=master_customer_suppliers&id=id&key=loader&value=1&column=name',
            success:function(response){
                // console.log(response);
                $("#loaderId").html(response);
                $("#loaderId").val(id);
                $('#loaderId').trigger('change'); 
            }
            });
        }
        getLoader();


        function getItem(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select2") }}?table=master_items&id=id&column=name',
            success:function(response){
                // console.log(response);
                $("#itemId").html(response);
                $("#itemId").val(id);
                $('#itemId').trigger('change'); 
            }
            });
        }   
        getItem();
        
        function getUnit(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select2") }}?table=master_units&id=id&column=name',
            success:function(response){
                // console.log(response);
                $("#unitId").html(response);
                $("#unitId").val(id);
                $('#unitId').trigger('change'); 
                }
            });
        }
        getUnit();

</script>

<script>
$(document).ready(function(){
    $('#checkLock').click(function() {
        var item = $("#itemId").val();
        var lock = 0;
        if ($(this).prop('checked')) {
           lock = 1;
        }
        else {
           lock = 0;
        }

        $.ajax({
            type:'GET',
            url:'{{ url("ItemLockUpdate") }}?item='+item+'&lock='+lock,
            success:function(response){
                console.log(response);
            }
        });

    });
});
</script>

<script>
    function getLockValue(id){
        $.ajax({
            type:'GET',
            url:'{{ url("GetItemLock") }}?itemid='+id,
            success:function(response){
                // console.log(response);
                if(response==1){
                    $("#checkLock").prop("checked", true);                    
                }else{
                    $("#checkLock").prop("checked", false);
                }
                
            }
        });
    }



    function AddItems(){
        var loadingEntryId = $("#loadingEntryId	").val();
        var loadingEntryDetailsId = $("#loadingEntryDetailsId").val();
        var itemId = $("#itemId").val();
        var rate = $("#rate").val();
        var unitId = $("#unitId").val();
        var weight = $("#weight").val();
        var qty = $("#qty").val();
        var status = false;

        var lock = 0;
        var amount = 0;
        if ($('#checkLock').prop('checked')) {
        amount = parseFloat(rate)*parseFloat(qty);
        }
        else {
        amount = parseFloat(rate)*parseFloat(weight);
        }
        

        if(itemId==''){
            $("#itemId").addClass('border-danger');
            status = false;
        }else{
            $("#itemId").removeClass('border-danger');
            status = true;
        }

        if(rate==''){
            $("#rate").addClass('border-danger');
            status = false;
        }else{
            $("#rate").removeClass('border-danger');
            status = true;
        }

        if(unitId==''){
            $("#unitId").addClass('border-danger');
            status = false;
        }else{
            $("#unitId").removeClass('border-danger');
            status = true;
        }

        if(weight==''){
            $("#weight").addClass('border-danger');
            status = false;
        }else{
            $("#weight").removeClass('border-danger');
            status = true;
        }

        if(qty==''){
            $("#qty").addClass('border-danger');
            status = false;
        }else{
            $("#qty").removeClass('border-danger');
            status = true;
        }
        

        if(status==true){
            $.ajax({
                type:'GET',
                url:'{{ url("AddLoadingEntryDetails") }}?itemId='+itemId+'&rate='+rate+'&unitId='+unitId+'&weight='+weight+'&qty='+qty+'&amount='+amount+'&loadingEntryId='+loadingEntryId+'&loadingEntryDetailsId='+loadingEntryDetailsId,
                success:function(response){
                    console.log(response);
                    $("#CHANGEBUTTON").html('<i class="fa fa-plus" aria-hidden="true"></i>  ADD');
                    if(loadingEntryId==0){
                        showLoadingEntryDetails();
                    }else{
                        loadingEntryEdit(loadingEntryId);
                    }                    
                    
                    $("#loadingEntryDetailsId").val("");
                    $("#rate").val("");
                    $("#weight").val("");
                    $("#qty").val("");
                }
            });
        }

        
        
    }



    function showLoadingEntryDetails(){
        $.ajax({
            type:'GET',
            url:'{{ url("showLoadingEntryDetails") }}',
            success:function(res){
                // console.log(res[1]);                
                $("#showLoadingEntryDetails").html(res[0]);
                $("#totalItemAmount").html(res[1]);
                calcTotalAmount();
            }
        });
    }

    showLoadingEntryDetails();


    function loadingEntryDetailsEdit(id){
        $.ajax({
            type:'GET',
            url:'{{ url("loadingEntryDetailsEdit") }}?id='+id,
            success:function(res){
                // console.log(res);
                var x = JSON.parse(res);
                // var billDate = moment(x.billDate).format('YYYY-MM-DD');
                // console.log(billDate);
                $("#CHANGEBUTTON").html('<i class="fa fa-pencil-square" aria-hidden="true"></i> UPDATE')
                getItem(x.itemId);
                getUnit(x.unitId);
                $("#loadingEntryDetailsId").val(x.id);
                $("#rate").val(x.rate);
                $("#weight").val(x.weight);
                $("#qty").val(x.qty);
            }
        });
    }


    function loadingEntryDetailsDelete(id){
        var loadingEntryId = $("#loadingEntryId").val();
        $.ajax({
            type:'GET',
            url:'{{ url("common-destroy") }}?table=loading_entry_details&key=id&value='+id,
            success:function(res){
                if(loadingEntryId==0){
                        showLoadingEntryDetails();
                    }else{
                        loadingEntryEdit(loadingEntryId);
                    } 
            }
        });
    }
     
</script>

<script>
     function calcTotalAmount(){
        var totalItemAmount = $("#totalItemAmount").html();
        var advance = $("#advance").val();
        if(advance == ''){ advance = 0; }
        // console.log(totalItemAmount)
        var totalAmount = parseFloat(totalItemAmount)+parseFloat(advance);
        $("#totalAmount").val(totalAmount);
    }
    
</script>


<!-- EDIT PART -->
<script>

    function loadingEntryEdit(id){
        $.ajax({
            type:'GET',
            url:'{{ url("loadingEntryEdit") }}?id='+id,
            success:function(res){
                // console.log(res);
                var x = JSON.parse(res);
                // console.log(x[0]);
                $("#formTitle").html("Edit Loading Entry");
                $("#loadingEntryId").val(id);
                $("#showLoadingEntryDetails").html(x[0]);
                $("#totalItemAmount").html(x[1]);
                calcTotalAmount();               

            }
        });
    }


    function select_loading_entry(id){
        $.ajax({
            type:'GET',
            url:'{{ url("select-record") }}?table=loading_entries&key=id&value='+id,
            success:function(res){
                // console.log(res);
                var x = JSON.parse(res);
                // console.log(x);
                var loadDate = moment(x.date).format('DD-MM-YYYY');
                // console.log(loadDate);                  
                getLoader(x.partyId);
                getFarmer(x.farmerId);
                $("#vehicleNumber").val(x.vehicleNumber);
                $("#date").val(loadDate);
                $("#motorBhada").val(x.motorBhada);
                $("#advance").val(x.advance);
                $("#driverInaam").val(x.driverInaam);
                $("#totalBhada").val(x.totalBhada);
                // $("#totalAmount").val(x[0].totalAmount);
                $("#driverMobile").val(x.driverMobile);
                $("#narration").val(x.narration);
                $("#netAmount").val(x.netAmount);
                calcTotalAmount();

            }
        });
    }
</script>


 
@if(isset($_GET['id'])){
    <script>
        loadingEntryEdit(@php echo $_GET['id'] @endphp);
        select_loading_entry(@php echo $_GET['id'] @endphp);
    </script>
@endif