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
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Payment Receive   
                        </h3>
                        <a href="{{ url('/report-payment-receive') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Today Bill" }}</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ url('submitPayment') }}" method="get" enctype="multipart/form-data" class='orm-vertical' id="customerSaleForm">
                            @csrf
                            <x-alert/>
                            
                            <input type="hidden" name="" id="paymentId">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                <table class="table">
                                
                                <tbody>                                  
                                  <tr>
                                    <th width="10%">Date</th>
                                    <th width="30%">Customer 
                                        <label style="cursor: pointer;" class="text-danger" for="getAllParty2">SHOW ALL <input type="checkbox" id="getAllParty2"></label>    
                                    <span class="pull-right text-danger" id="oldBalance"></span> 
                                    </th>
                                    <th width="8%">Pay Amt</th>
                                    <th width="8%">Dis.(Rs.)</th>
                                    <th width="7%">Action</th>
                                    <th width="35%">Narration</th>
                                    
                                  </tr>
                                  <tr>
                                    <td>
                                        <input type="text" name="date" value="{{ $date }}" id="date" placeholder="" class="form-control datemask">
                                    </td>
                                    <td>
                                        <select class="js-select2" name="customerId" id="customerId" onchange="getOldBal(this.value)">    
                                            <option value="">Select Customer</option>                                        
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="amount" id="amount" placeholder="" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="discount" id="discount" placeholder="" class="form-control">
                                    </td>
                                    <td>
                                        <button onclick="AddPayment()" type="button" class="btn btn-primary"> <span id="CHANGEBTN"><i class="fa fa-plus" aria-hidden="true"></i>  ADD</span> </button>
                                    </td>
                                    <td>
                                        <input type="text" name="narration" id="narration" placeholder="" class="form-control">
                                    </td>
                                    
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            </div>


                            
                            <div class="panel panel-default">
                                <div class="panel-body">

                                <span style="font-size: 16px;" class="btn btn-primary"><span id="totalAmount">00</span></span>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Paid Amount</th>
                                        <th>Discount</th>
                                        <th>Narration</th>
                                        <th>Action</th>
                                      </tr>
                                </thead>
                                <tbody id="showPaymentTableData">                               
                                  
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
                    console.log(res);
                    $("#customerId").html(res);
                    $("#customerId").val(id);
                    $('#customerId').trigger('change');
                }
            });
        }else{
            getCustomer();
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

        
</script>


<script>
   
    function AddPayment(){
        var paymentId = $("#paymentId").val();
        var date = $("#date").val();
        var customerId = $("#customerId").val();
        var amount = $("#amount").val();
        var discount = $("#discount").val();
        var narration = $("#narration").val();
        var status = false;

        if(discount ==''){
            discount = 0;
        }
       
        if(date==''){
            $("#date").addClass('border-danger');
            status = false;
        }else{
            $("#date").removeClass('border-danger');
            status = true;
        }        

        if(customerId==''){
            $("#customerId").addClass('border-danger');
            status = false;
        }else{
            $("#customerId").removeClass('border-danger');
            status = true;
        }

        if(amount==''){
            $("#amount").addClass('border-danger');
            status = false;
        }else{
            $("#amount").removeClass('border-danger');
            status = true;
        }

               

        if(status==true){
            $.ajax({
                type:'GET',
                url:'{{ url("AddPayment") }}?date='+date+'&partyId='+customerId+'&amount='+amount+'&discount='+discount+'&narration='+narration+'&paymentId='+paymentId,
                success:function(response){
                    console.log(response);
                    showPaymentTableData();
                    $("#CHANGEBTN").html('<i class="fa fa-plus" aria-hidden="true"></i>  ADD');
                    $("#paymentId").val("");
                    $("#amount").val("");
                    $("#discount").val("");
                    $("#narration").val("");
                }
            });
        }

        
        
    }



    function showPaymentTableData(){
        $.ajax({
            type:'GET',
            url:'{{ url("showPaymentTableData") }}',
            success:function(res){
                // console.log(res);                
                $("#showPaymentTableData").html(res[0]);
                $("#totalAmount").html(res[1]);
            }
        });
    }

    showPaymentTableData();


    function paymentEdit(id){
        $.ajax({
            type:'GET',
            url:'{{ url("paymentEdit") }}?id='+id,
            success:function(res){
                // console.log(res);
                var x = JSON.parse(res);
                var date = moment(x.date).format('DD-MM-YYYY');
                // console.log(date);
                $("#CHANGEBTN").html('<i class="fa fa-pencil-square" aria-hidden="true"></i>  UPDATE');
                getCustomer(x.partyId);
                $("#paymentId").val(x.id);
                $("#date").val(date);
                $("#amount").val(x.amount);
                $("#discount").val(x.discount);
                $("#narration").val(x.narration);
            }
        });
    }



    function deleteRecord(id){
        var answer = window.confirm("Are you sure ?");
        if (answer) {
        $.ajax({
        type:'GET',
        url:'{{ url("common-destroy") }}?table=customer_sales_payment_receives&key=id&value='+id,
        success:function(res){
            console.log(res);
            showPaymentTableData();
        }
        });
        }
        else {
        //some code
        }
        }

    function getOldBal(id){
        $.ajax({
            type:'GET',
            url:'{{ url('nonStaticGetPartyBalance') }}?partyId='+id,
            success:function(res){
                // console.log(res);
                $("#oldBalance").html("Old Balance: "+res);
            }
        });
    }
    

</script>




<?php 
if(isset($_GET['id'])){
    ?>
    <script>
        paymentEdit({{$_GET['id']}});
    </script>
    <?php
}
?>