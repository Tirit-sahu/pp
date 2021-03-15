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
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Supplier Carret Return Entry 
                        </h3>
                        <a href="{{ url('/report-supplier-carret-returns') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Today Bill" }}</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ url('submitCarretReturn') }}" method="get" enctype="multipart/form-data" class='orm-vertical' id="customerSaleForm">
                            @csrf
                            <x-alert/>
                            
                            <input type="hidden" name="" id="CarretReturnId">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                <table class="table table-bordered">                                
                                <tbody>                                  
                                  <tr>
                                    <th width="8%">Date</th>
                                    <th width="20%">Supplier
                                        <label style="cursor: pointer;" class="text-danger" for="getAllParty2">SHOW ALL <input type="checkbox" id="getAllParty2"></label> 
                                        <span id="carretBalance" class="pull-right text-danger"></span>
                                    </th>
                                    <th width="10%">Carret Type</th>
                                    <th width="8%">Depo. QTY</th>
                                    <th width="5%">Dis. <input id="carretDis" type="checkbox"></th>
                                    <th width="8%">Action</th>
                                    <th width="10%">Vehicle Number</th>
                                    <th width="10%">Driver Mobile</th>
                                  </tr>
                                  <tr>
                                      <td><input type="text" name="date" value="{{ $date }}" id="date" placeholder="" class="form-control datemask"></td>
                                    <td>
                                        <select onchange="getCurrentCarretBalance(this.value)" class="js-select2" name="partyId" id="partyId">    
                                            <option value="">Select Supplier</option>                                        
                                        </select>
                                    </td>
                                    <td>
                                        <select class="js-select2" name="unitId" id="unitId">    
                                            <option value="">Select Carret Type</option>                                        
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="qty" id="qty" placeholder="" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" name="discount" id="discount" placeholder="" class="form-control" style="width: 60px;">
                                    </td>
                                    <td>
                                        <button onclick="CarretReturn()" type="button" class="btn btn-primary"> 
                                            <span id="CHANGEBTN">
                                                <i class="fa fa-plus" aria-hidden="true"></i>  ADD
                                            </span>
                                        </button>
                                    </td>
                                    <td>
                                        <input type="text" name="vehicleNumber" id="vehicleNumber" placeholder="" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="driverMobile" id="driverMobile" placeholder="" class="form-control">
                                    </td>
                                    
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            </div>


                            
                            <div class="panel panel-default">
                                <div class="panel-body">

                                <span style="font-size: 16px;" class="btn btn-primary">Total Deposite QTY: <span id="totalQty">00</span></span>

                                <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Carret Type</th>
                                        <th>Depo. QTY</th>
                                        <th>Dis.</th>
                                        <th>Vehicle Number</th>      
                                        <th>Driver Name</th>                                
                                        <th>Action</th>
                                      </tr>
                                </thead>
                                <tbody id="showSupplierCarretReturn">                               
                                  
                                </tbody>
                                </table>

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

        $('#getAllParty2').change(function() {
        if(this.checked) {
            $.ajax({
                type:'GET',
                url:'{{ url("common-get-select2") }}?table=master_customer_suppliers&id=id&column=name',
                success:function(res){
                    // console.log(res);
                    $("#partyId").html(res);
                    $("#partyId").val(id);
                    $('#partyId').trigger('change');
                }
            });
        }else{
            getSupplier();
        }
        });

    });
</script>

<script>
    $(document).ready(function() {
        $("#discount").css('display', 'none');
        $('#carretDis').change(function() {
        if(this.checked) {
            $("#discount").css('display', 'block');  
        }else{
            $("#discount").css('display', 'none');
        }
    });
    });
</script>

<script>

        function getSupplier(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select") }}?table=master_customer_suppliers&id=id&key=supplier&value=1&column=name',
            success:function(response){
                // console.log(response);
                $("#partyId").html(response);
                $("#partyId").val(id);
                $('#partyId').trigger('change'); 
            }
            });
        }
        getSupplier();

        
        
        function getUnit(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select") }}?table=master_units&id=id&column=name&key=isStockable&value=Yes',
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
  
    function CarretReturn(){
        var CarretReturnId = $("#CarretReturnId").val();
        var date = $("#date").val();
        var partyId = $("#partyId").val();
        var unitId = $("#unitId").val();
        var qty = $("#qty").val();
        var discount = $("#discount").val();
        var vehicleNumber = $("#vehicleNumber").val();
        var driverMobile = $("#driverMobile").val();
        var status = false;        

        if(date==''){
            $("#date").addClass('border-danger');
            status = false;
        }else{
            $("#date").removeClass('border-danger');
            status = true;
        }

        if(partyId==''){
            $("#partyId").addClass('border-danger');
            status = false;
        }else{
            $("#partyId").removeClass('border-danger');
            status = true;
        }       

        if(unitId==''){
            $("#unitId").addClass('border-danger');
            status = false;
        }else{
            $("#unitId").removeClass('border-danger');
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
                url:'{{ url("AddCarretReturn") }}?date='+date+'&partyId='+partyId+'&unitId='+unitId+'&qty='+qty+'&discount='+discount+'&vehicleNumber='+vehicleNumber+'&driverMobile='+driverMobile+'&CarretReturnId='+CarretReturnId,
                success:function(response){
                    console.log(response);
                    showSupplierCarretReturn();
                    $("#CHANGEBTN").html('<i class="fa fa-plus" aria-hidden="true"></i>  ADD');
                    $("#CarretReturnId").val("");
                    $("#qty").val("");
                    $("#vehicleNumber").val("");
                    $("#driverMobile").val("");
                }
            });
        }        
        
    }



    function showSupplierCarretReturn(){
        $.ajax({
            type:'GET',
            url:'{{ url("showSupplierCarretReturn") }}',
            success:function(res){
                // console.log(res[1]);                
                $("#showSupplierCarretReturn").html(res[0]);
                $("#totalQty").html(res[1]);
            }
        });
    }

    showSupplierCarretReturn();


    function CarretReturntEdit(id){
        $.ajax({
            type:'GET',
            url:'{{ url("CarretReturntEdit") }}?id='+id,
            success:function(res){
                // console.log(res);
                var x = JSON.parse(res);
                var date = moment(x.date).format('DD-MM-YYYY');
                // console.log(date);
                $("#CHANGEBTN").html('<i class="fa fa-pencil-square" aria-hidden="true"></i>  UPDATE');
                getSupplier(x.partyId);
                getUnit(x.unitId);
                if(x.discount != 0){
                    $("#discount").css('display', 'block');
                    $("#discount").val(x.discount);
                }else{
                    $("#discount").css('display', 'none');
                    $("#discount").val(0);
                }
                $("#CarretReturnId").val(x.id);
                $("#date").val(date);
                $("#qty").val(x.qty);
                $("#vehicleNumber").val(x.vehicleNumber);
                $("#driverMobile").val(x.driverMobile);
            }
        });
    }


    function CarretReturnDelete(id){
        $.ajax({
            type:'GET',
            url:'{{ url("common-destroy") }}?table=supplier_carret_returns&key=id&value='+id,
            success:function(res){
                // console.log(res);
                showSupplierCarretReturn();
            }
        });
    }


    function getCurrentCarretBalance(partyId, date){
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



<?php 
if(isset($_GET['id'])){
    ?>
    <script>
        CarretReturntEdit({{$_GET['id']}});
    </script>
    <?php
}
?>