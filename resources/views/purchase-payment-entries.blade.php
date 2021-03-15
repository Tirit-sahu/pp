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
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Purchase Payment Entry
                        </h3>
                        <a href="{{ url('/report-purchase-payment-entries') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Today Bill" }}</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ url('submitPurchasePayment') }}" method="get" enctype="multipart/form-data" class='orm-vertical' id="customerSaleForm">
                            @csrf
                            <x-alert/>
                            
                            <input type="hidden" name="" id="paymentId">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                <table class="table table-bordered">
                                
                                <tbody>                                  
                                  <tr>
                                    <th width="9%">Date</th>
                                    <th width="30%">Supplier <span class="pull-right text-danger" id="oldBalance"></span></th>
                                    <th width="8%">Pay Amount</th>
                                    <th width="8%">Discount (Rs.)</th>
                                    <th width="5%">Action</th>
                                    <th>Narration</th>
                                  </tr>
                                  <tr>
                                    <td>
                                        <input type="text" name="date" value="{{ $date }}" id="date" placeholder="" class="form-control datemask">
                                    </td>
                                    <td>
                                        <select class="js-select2" name="supplierId" onchange="getOldBal(this.value)" id="supplierId">    
                                            <option value="">Select Supplier</option>                                        
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="amount" id="amount" placeholder="" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="discount" id="discount" placeholder="" class="form-control">
                                    </td>
                                    <td>
                                        <button onclick="AddPayment()" type="button" class="btn btn-primary"> <span id="btnType"><i class="fa fa-plus" aria-hidden="true"></i>  ADD</span> </button>
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
                                        <th>Supplier</th>
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

        function getSupplier(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select") }}?table=master_customer_suppliers&id=id&key=supplier&value=1&column=name',
            success:function(response){
                // console.log(response);
                $("#supplierId").html(response);
                $("#supplierId").val(id);
                $('#supplierId').trigger('change'); 
                }
            });
        }
        getSupplier();



        function getOldBal(id){
        $.ajax({
            type:'GET',
            url:'{{ url("nonStaticGetPartyBalance") }}?partyId='+id,
            success:function(res){
                // console.log(res);
                $("#oldBalance").html("Old Balance: "+res);
            }
        });
        }

        
</script>


<script>
   
    function AddPayment(){
        var paymentId = $("#paymentId").val();
        var date = $("#date").val();
        var supplierId = $("#supplierId").val();
        var amount = $("#amount").val();
        var discount = $("#discount").val();
        var narration = $("#narration").val();
        var status = false;             

        if(date==''){
            $("#date").addClass('border-danger');
            status = false;
        }else{
            $("#date").removeClass('border-danger');
            status = true;
        }        

        if(supplierId==''){
            $("#supplierId").addClass('border-danger');
            status = false;
        }else{
            $("#supplierId").removeClass('border-danger');
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
                url:'{{ url("AddPurchasePayment") }}?date='+date+'&partyId='+supplierId+'&amount='+amount+'&discount='+discount+'&narration='+narration+'&paymentId='+paymentId,
                success:function(response){
                    console.log(response);
                    showPaymentTableData();
                    $("#btnType").html('<i class="fa fa-plus" aria-hidden="true"></i>  ADD');
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
            url:'{{ url("showPurchasePaymentTableData") }}',
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
            url:'{{ url("purchasePaymentEdit") }}?id='+id,
            success:function(res){
                console.log(res);
                var x = JSON.parse(res);
                var date = moment(x.date).format('DD-MM-YYYY');
                console.log(date);
                $("#btnType").html('<i class="fa fa-pencil" aria-hidden="true"></i>  UPDATE');
                getSupplier(x.partyId);
                $("#paymentId").val(x.id);
                $("#date").val(date);
                $("#amount").val(x.amount);
                $("#discount").val(x.discount);
                $("#narration").val(x.narration);
            }
        });
    }



    function deleteRecord(id){
        $.ajax({
            type:'GET',
            url:'{{ url("common-destroy") }}?table=purchase_payment_entries&key=id&value='+id,
            success:function(res){
                console.log(res);
                showPaymentTableData();
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
