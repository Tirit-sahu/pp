@extends('layouts.app')
@section('content')

<?php 
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
?>

<style>
.date-selector {
  position: relative;
}

.date-selector>input[type=date] {
  text-indent: -500px;
}

table .CustomerSaleDetailsTBody {
  display: block;
  max-height: 300px;
  overflow-y: scroll;
}

table thead, table .CustomerSaleDetailsTBody tr {
  display: table;
  width: 100%;
  table-layout: fixed;
}


</style>

    <div class="container-fluid">
        
     
        
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> 
                            <span id="formTitle">Customer Sale Entry</span>
                        </h3>
                        <a href="{{ url('/customerSaleReport') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Today Bill" }}</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ url('submitCustomerSaleData') }}" method="POST" enctype="multipart/form-data" class='orm-vertical' id="customerSaleForm">
                            @csrf
                            <x-alert/>
                            
                            <input type="hidden" name="" id="customerSaleId">

                            <div class="panel panel-default">
                                <div class="panel-body">
                            
                              <table class="table table-bordered">
                                
                                <tbody>
                                  
                                  <tr>
                                   
                                    <th width="15%">
                                        Date
                                    </th>
                                    <th width="20%">
                                        Farmer Name &nbsp;&nbsp;
                                        <label style="cursor: pointer;" class="text-danger" for="getAllParty2">SHOW ALL <input type="checkbox" id="getAllParty2"></label>
                                    </th>
                                    <th width="10%" ></th>
                                    <th width="8%">
                                        
                                    </th>
                                    <th width="10%"></th>
                                    <th width="10%"></th>  
                                    <th></th>
                                  </tr>





                                  <tr>
                                    <td>                             
                                        <input type="text" name="date" value="{{ $date }}" id="date" placeholder="DD-MM-YYYY" class="form-control datemask" tabindex="1">
                                    </td>
                                   
                                    <td>
                                        <select name="farmerId" class="js-select2" id="farmerId" style="width:100%" tabindex="2">
                                            <option value="">Select Farmer</option>                                                
                                        </select>
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              
                              <table class="table table-bordered">
                                
                                <tbody>
                                  
                                  <tr>
                                   
                                    <th width="20%">
                                        Item Name
                                        <span id="lockDiv"><input name="checkLock" type="checkbox" id="checkLock"></span>
                                    </th>
                                    <th width="5%">Rate</th>
                                    <th width="15%" >Unit</th>
                                    <th width="40%">
                                        Customer &nbsp;&nbsp;
                                        <label style="cursor: pointer;" class="text-danger" for="getAllParty">SHOW ALL <input type="checkbox" id="getAllParty"></label>
                                        <span class="pull-right text-danger" id="oldBalance"></span>
                                        <span style="margin-right: 10px;" class="pull-right text-danger" id="carretBalance"></span>
                                    </th>
                                    <th width="10%">KG/Unit <span style="font-size:10px; color:#F00">(Weight)</span></th>
                                    <th width="5%">QTY</th>  
                                    <th>Action</th>
                                  </tr>





                                  <tr>
                                    <td>                             
                                        <select class="js-select2" name="item" id="itemId" onchange="getLockValue(this.value)" style="width:100%" tabindex="3">    
                                            <option value="">Select Item</option>                                        
                                        </select>
                                    </td>
                                   
                                    <td>
                                        <input type="text" name="rate" id="rate" placeholder="" class="form-control w-100" style="width:100%" tabindex="4">
                                    </td>
                                    <td>
                                        <select class="js-select2" name="unitId" id="unitId"  tabindex="5">    
                                            <option value="">Select Unit</option>                                        
                                        </select>
                                    </td>
                                    <td>
                                        <select class="js-select2 customerId" name="customerId" id="customerId" style="width:100%" onchange="getOldBal(this.value)" tabindex="5">    
                                            <option value="">Select Customer</option>                                        
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="weight" id="weight" placeholder="" class="form-control" style="width:100%" tabindex="6">
                                    </td>
                                    <td>
                                        <input type="text" name="qty" id="qty" placeholder="" class="form-control" style="width:100%" tabindex="7">
                                    </td>
                                    <td>
                                        <button onclick="AddItems()" type="button" class="btn btn-primary" tabindex="8">
                                            <span id="CHANGEBTN">
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
                                <div class="panel-body" >
                            <table class="table table-bordered">
                                
                                <tbody>                                  
                                  <tr>                                   
                                    <th width="60%">Remark</th>
                                    <th width="40%"></th>
                                  </tr>
                                  <tr>
                                  
                                    <td>
                                        <input type="text" name="remark" id="remark" placeholder="" class="form-control " tabindex="9">
                                        <td></td>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            </div>


                            
                            <div class="panel panel-default">
                                <div class="panel-body">                                
                                
                                    <table class="table table-bordered rowClick">
                                        <thead>
                                            <tr>
                                            <th>TOTAL</th>
                                            <th></th>
                                            <th id="totalQTY">QTY</th>
                                            <th></th>
                                            <th id="totalKG">KG/Unit</th>
                                            <th></th>                        
                                            <th></th>
                                            <th></th>
                                            <th id="totalAmount"></th>
                                            <th></th>
                                            </tr>
                        
                                            <tr>
                                            <th>SNO.</th>
                                            <th>Item Name</th>
                                            <th>QTY</th>
                                            <th>Unit</th>
                                            <th>KG/Unit</th>
                                            <th>Rate</th>                        
                                            <th>Remark</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="CustomerSaleDetailsTBody" id="showCustomerSaleTableData">
                                        </tbody>
                                    </table>

                                <div >

                                </div>
                                                           
                                  
                                
                            </div>
                            </div>                    
                            
                            
                            <div class="form-actions">
                                <center>
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-floppy-o" aria-hidden="true"></i>  SUBMIT </button>
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
                    $("#customerId").html(res);
                    $("#customerId").val(id);
                    $('#customerId').trigger('change');
                }
            });
        }else{
            getCustomer();
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

        function getCustomer(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select") }}?table=master_customer_suppliers&id=id&key=customer&value=1&column=name',
            success:function(response){
                // console.log(response);
                $("#customerId").html(response);
                $("#customerId").val(id);
                $('#customerId').trigger('change'); 
            }
            });
        }
        getCustomer();

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
        var customerSaleId = $("#customerSaleId").val();
        var date = $("#date").val();
        var farmerId = $("#farmerId").val();
        var itemId = $("#itemId").val();
        var rate = $("#rate").val();
        var unitId = $("#unitId").val();
        var customerId = $("#customerId").val();
        var weight = $("#weight").val();
        var qty = $("#qty").val();
        var remark = $("#remark").val();
        var status = false;

        var lock = 0;
        var amount = 0;
        if ($('#checkLock').prop('checked')) {
        //    lock = 1;
        amount = parseFloat(rate)*parseFloat(qty);
        }
        else {
        //    lock = 0;
        amount = parseFloat(rate)*parseFloat(weight);
        }
        

        if(date==''){
            $("#date").addClass('border-danger');
            status = false;
        }else{
            $("#date").removeClass('border-danger');
            status = true;
        }

        if(farmerId==''){
            $("#farmerId").addClass('border-danger');
            status = false;
        }else{
            $("#farmerId").removeClass('border-danger');
            status = true;
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

        if(customerId==''){
            $("#customerId").addClass('border-danger');
            status = false;
        }else{
            $("#customerId").removeClass('border-danger');
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
                url:'{{ url("submitAddItems") }}?date='+date+'&farmerId='+farmerId+'&itemId='+itemId+'&rate='+rate+'&unitId='+unitId+'&customerId='+customerId+'&weight='+weight+'&qty='+qty+'&amount='+amount+'&remark='+remark+'&customerSaleId='+customerSaleId,
                success:function(response){
                    console.log(response);
                    showCustomerSaleTableData();
                    $("#CHANGEBTN").html('<i class="fa fa-plus" aria-hidden="true"></i> ADD');
                    $("#weight").val("");
                    $("#qty").val("");
                    $('#customerId').focus();
                    $('.customerId').css('border', '2px solid red');
                    $("#customerSaleId").val("");
                }
            });
        }

        
        
    }



    function showCustomerSaleTableData(){
        $.ajax({
            type:'GET',
            url:'{{ url("showCustomerSaleTableData") }}',
            success:function(res){
                // console.log(res);                
                $("#showCustomerSaleTableData").html(res[0]);
                $("#totalQTY").html(res[1]);
                $("#totalKG").html(res[2]);
                $("#totalAmount").html(res[3]);
            }
        });
    }

    showCustomerSaleTableData();


    function custumerSaleEdit(id){
        $.ajax({
            type:'GET',
            url:'{{ url("customerSaleEdit") }}?id='+id,
            success:function(res){
                // console.log(res);
                $("#CHANGEBTN").html('<i class="fa fa-pencil-square" aria-hidden="true"></i> UPDATE');
                var x = JSON.parse(res);
                var date = moment(x.date).format('DD-MM-YYYY');
                // console.log(date);                
                getFarmer(x.farmerId);
                getCustomer(x.partyId);
                getItem(x.itemId);
                getUnit(x.unitId);
                $("#customerSaleId").val(x.id);
                $("#date").val(date);
                $("#rate").val(x.rate);
                $("#weight").val(x.weight);
                $("#qty").val(x.qty);
                $("#remark").val(x.remark);
            }
        });
    }


    function deleteRecord(id){
        $.ajax({
            type:'GET',
            url:'{{ url("common-destroy") }}?table=customer_sales&key=id&value='+id,
            success:function(res){
                console.log(res);
                showCustomerSaleTableData();
            }
        });
    }

    function getOldBal(id){
        $.ajax({
            type:'GET',
            url:'{{ url('nonStaticGetPartyBalance') }}?partyId='+id,
            success:function(res){
                // console.log(res);
                $("#oldBalance").html("Old Balance: "+res);
                getCurrentCarretBalance(id);
            }
        });
    }

    function getCurrentCarretBalance(partyId){
        $.ajax({
            type:'GET',
            url:'{{ url("getPartyCarretBalanceByDate") }}?partyId='+partyId,
            success:function(res){
                console.log(res);
                $("#carretBalance").html(res);
            }
        });
    }
     
</script>

<script>
    function rowHighLight(thisrow){
        $(thisrow).parent().find('td').toggleClass("high-light");
    }
</script>


@if(isset($_GET['id']))
    <script>
        $("#formTitle").html("Edit Customer Sale");
        custumerSaleEdit(@php echo $_GET['id']; @endphp);
    </script>
@endif

