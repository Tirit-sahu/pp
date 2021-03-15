@extends('layouts.app')
@section('content')

<?php 
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$editId = 0;
if (isset($_GET['id'])) {
    $editId = $_GET['id'];
}
?>


    <div class="container-fluid">             
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> <span id="formTitle">Purchase Entry</span>
                        </h3>
                        <a href="{{ url('/report-purchase-entry') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Purchase Entry Report" }}</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ url('submitPurchaseEntryForm') }}" method="POST" enctype="multipart/form-data" class='orm-vertical' id="customerSaleForm">
                            @csrf
                            <x-alert/>
                            <input type="hidden" id="editId" value="{{ $editId }}">
                            <input type="hidden" name="pid" value="0" id="pid">
                            <input type="hidden" id="purchaseEntryDetailId"> 

                            <div class="panel panel-default">
                                <div class="panel-body">
                            <table class="table">
                                <thead>
                                  <tr>                                    
                                    <th width="30%">Supplier Name &nbsp;&nbsp;
                                        <label style="cursor: pointer;" class="text-danger" for="getAllParty">SHOW ALL <input type="checkbox" id="getAllParty"></label>    
                                    </th>                                       
                                    <th width="6%">Purchase Date</th>                                
                                    <th width="10%">Vehicle Number</th>
                                    <th>Bill Print Name</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    
                                    <td>
                                        <select name="supplierId" class="js-select2" id="supplierId" tabindex="1">
                                            <option value="">Select Farmer</option>                                                
                                        </select>
                                    </td>
                                    
                                    <td>
                                        <input type="text" name="purchaseDate" value="{{ $date }}" id="date" placeholder="" class="form-control datemask" tabindex="2">
                                    </td>
                                    <td>
                                        <input type="text" name="vehicleNumber" value="" id="vehicleNumber" placeholder="" style="text-transform:uppercase" class="form-control" tabindex="3">
                                    </td>
                                    <td>
                                        <select class="js-select2" name="billPrintName" id="billPrintName" tabindex="4">    
                                            <option value="">Select Bill Print Name</option>                                        
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                  <th>Bilty No.</th>
                                    <th>
                                        Item Name
                                        <span id="lockDiv"><input name="checkLock" type="checkbox" id="checkLock"></span>
                                    </th>
                                    <th>Rate</th>
                                    <th>Unit</th>
                                    <th>QTY</th>                                  
                                    <th>KG/Unit</th>
                                    <th>Action</th>
                                    <th>Narration</th>
                                  </tr>
                                  <tr>

                                    <td>
                                         <input type="text" name="biltyNo" id="biltyNo" placeholder=""  class="form-control  w-200" tabindex="5">
                                    </td>
                                    <td>        
                                                           
                                        <select class="js-select2 w-300" name="itemId" id="itemId" onchange="getLockValue(this.value)" tabindex="6">    
                                            <option value="">Select Item</option>                                        
                                        </select>
                                    </td>
                                    
                                    <td>
                                        <input type="number" name="rate" id="rate" placeholder="" class="form-control w-100" tabindex="7">
                                    </td>

                                    <td>
                                        <select class="js-select2 w-150" name="unitId" id="unitId" tabindex="8">    
                                            <option value="">Select Unit</option>                                        
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" name="qty" id="qty" placeholder="" class="form-control w-100" tabindex="9">
                                    </td>                                    

                                    <td>
                                        <input type="number" name="weight" id="weight" placeholder="" class="form-control w-100" tabindex="10">
                                    </td>
                                    
                                    <td>
                                        <button onclick="AddPurchaseEntryDetails()" type="button" class="btn btn-primary" tabindex="11">  <span id="btnAddPurchaseDetails"><i class="fa fa-plus" aria-hidden="true"></i> ADD</span> </button>
                                    </td>
                                    <td>
                                        <input type="text" name="narration" value="" id="narration" placeholder="" class="form-control w-400" tabindex="12">
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            </div>


                    


                            
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div id="showPurchaseEntryDetails"></div>
                            
                                </div>
                            </div>

                            
                            <div class="panel panel-default">
                                <div class="panel-body">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Expenses</th>         
                                                <th>Type</th>    
                                                <th>Proccess</th>                                  
                                                <th>Amount</th>
                                                <th>Action</th>
                                              </tr>
                                        </thead>
                                                                       
                                            <tr>
                                                
                                                <td>
                                                    <select class="js-select2 w-200" onchange="getExpensesType(this.value)" name="masterAddtionalExpensesId" id="masterAddtionalExpensesId" tabindex="12">    
                                                        <option value="">Select Expenses</option>                                        
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="type" id="type" placeholder="" readonly class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="process" id="process" placeholder="" readonly class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number" name="amount" id="amount" placeholder="" class="form-control" tabindex="13">
                                                </td>
                                                <td>
                                                    <button onclick="AddPurchaseEntryExpenses()" type="button" class="btn btn-primary" tabindex="14"> <i class="fa fa-plus" aria-hidden="true"></i>  ADD </button>
                                                </td>
                                            </tr>
                                        <tbody id="ShowPurchaseEntryExpenses">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Total Expenses</th>         
                                                <td>
                                                    <input type="text" readonly name="expenseAmt" id="expenseAmt" placeholder="" class="form-control">
                                                </td>                                     
                                            </tr>

                                            <tr>
                                                <th>Other Charges</th>
                                                <td>
                                                    <input type="text" readonly name="otherChargesAmt" id="otherChargesAmt" placeholder="" class="form-control">
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Total Amount</th>
                                                <td>
                                                    <input type="text" readonly name="totalAmt" id="totalAmt" placeholder="" class="form-control">
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>                               
                                          
                                        </tbody>
                                    </table>
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
                    console.log(res);
                    $("#supplierId").html(res);
                    $("#supplierId").val(id);
                    $('#supplierId').trigger('change');
                }
            });
        }else{
            getSupplier();
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
                $("#supplierId").html(response);
                $("#supplierId").val(id);
                $('#supplierId').trigger('change'); 
            }
            });
        }
        getSupplier();


        function getBillPrintName(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select2") }}?table=master_bijak_print_names&id=id&column=name',
            success:function(response){
                console.log(response);
                $("#billPrintName").html(response);
                $("#billPrintName").val(id);
                $('#billPrintName').trigger('change'); 
            }
            });
        }
        getBillPrintName();


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

        
        function getAdditionalExpenses(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("common-get-select2") }}?table=master_addtional_expenses&id=id&column=name',
            success:function(response){
                // console.log(response);
                $("#masterAddtionalExpensesId").html(response);
                $("#masterAddtionalExpensesId").val(id);
                $('#masterAddtionalExpensesId').trigger('change'); 
            }
            });
        }
        getAdditionalExpenses();

        


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



    function AddPurchaseEntryDetails(){
        var purchaseEntryDetailId = $("#purchaseEntryDetailId").val();
        var itemId = $("#itemId").val();
        var rate = $("#rate").val();
        var unitId = $("#unitId").val();
        var qty = $("#qty").val();
        var weight = $("#weight").val();       
        var pid = $("#pid").val(); 
        var biltyNo = $("#biltyNo").val(); 
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
               
        if(biltyNo==''){
            alert(biltyNo);
            $("#biltyNo").addClass('border-danger');
            status = false;
        }else{
            $("#biltyNo").removeClass('border-danger');
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
        
        if(qty==''){
            $("#qty").addClass('border-danger');
            status = false;
        }else{
            $("#qty").removeClass('border-danger');
            status = true;
        }

        if(weight==''){
            $("#weight").addClass('border-danger');
            status = false;
        }else{
            $("#weight").removeClass('border-danger');
            status = true;
        }

       

        if(status==true){
            $.ajax({
                type:'GET',
                url:'{{ url("AddPurchaseEntryDetails") }}?itemId='+itemId+'&rate='+rate+'&unitId='+unitId+'&weight='+weight+'&qty='+qty+'&amount='+amount+'&purchaseEntryDetailId='+purchaseEntryDetailId+'&pid='+pid+'&biltyNo='+biltyNo,
                success:function(response){
                     console.log(response);
                    $("#btnAddPurchaseDetails").html('<i class="fa fa-plus" aria-hidden="true"></i> ADD');
                    if(pid==0){
                        showPurchaseEntryDetails();
                    }else{
                        EDITshowPurchaseEntry(pid);
                    }
                    
                    $("#purchaseEntryDetailId").val("");
                    $("#rate").val("");
                    $("#biltyNo").val("");
                    $("#narration").val("");
                    $("#weight").val("");
                    $("#qty").val("");
                }
            });
        }

        
        
    }



    function showPurchaseEntryDetails(){
        $.ajax({
            type:'GET',
            url:'{{ url("showPurchaseEntryDetails") }}',
            success:function(res){
                // console.log(res);                
                $("#showPurchaseEntryDetails").html(res);
                CalCTotalAmount();
            }
        });
    }

    


    function purchaseDetailsEdit(id){
        $.ajax({
            type:'GET',
            url:'{{ url("purchaseDetailsEdit") }}?id='+id,
            success:function(res){
                // console.log(res);
                var x = JSON.parse(res);
                // var billDate = moment(x.billDate).format('YYYY-MM-DD');
                // console.log(billDate);
                $("#btnAddPurchaseDetails").html('<i class="fa fa-pencil-square" aria-hidden="true"></i> UPDATE');
                getItem(x.itemId);
                getUnit(x.unitId);
                $("#purchaseEntryDetailId").val(x.id);
                $("#rate").val(x.rate);
                $("#biltyNo").val(x.biltyNo);
                $("#narration").val(x.narration);
                $("#weight").val(x.weight);
                $("#qty").val(x.qty);
            }
        });
    }


    function purchaseDetailsDelete(id){
        $.ajax({
            type:'GET',
            url:'{{ url("common-destroy") }}?table=purchase_entry_details&key=id&value='+id,
            success:function(res){
                // console.log(res);
                var pid = $("#pid").val();
                if(pid==0){
                    showPurchaseEntryDetails();
                }else{
                    EDITshowPurchaseEntry(pid);                    
                }
                
            }
        });
    }



    function AddPurchaseEntryExpenses(){
        var masterAddtionalExpensesId = $("#masterAddtionalExpensesId").val();
        var type = $("#type").val();
        var process = $("#process").val();
        var amount = $("#amount").val();
        var pid = $("#pid").val(); 
        var status = false;

        if(masterAddtionalExpensesId==null || masterAddtionalExpensesId==''){
            $("#masterAddtionalExpensesId").addClass('border-danger');
            status = false;
        }else{
            $("#masterAddtionalExpensesId").removeClass('border-danger');
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
            url:'{{ url("AddPurchaseEntryExpenses") }}?masterAddtionalExpensesId='+masterAddtionalExpensesId+'&type='+type+'&process='+process+'&amount='+amount+'&pid='+pid,
            success:function(res){
                console.log(res);
                $("#amount").val("");
                if(pid==0){
                    ShowPurchaseEntryExpenses();
                }else{
                    EDITshowPurchaseEntry(pid);
                }
            }
            });
        }
    }


    function getExpensesType(id){
        $.ajax({
            type:'GET',
            url:'{{ url("getExpensesType") }}?id='+id,
            success:function(res){
                // console.log(res);
                var x = JSON.parse(res);
                $("#type").val(x.type);
                $("#process").val(x.process);
            }
        });
    }


    function ShowPurchaseEntryExpenses(){
        $.ajax({
            type:'GET',
            url:'{{ url("ShowPurchaseEntryExpenses") }}',
            success:function(res){
                // console.log(res);
                $("#ShowPurchaseEntryExpenses").html(res);
                $("#expenseAmt").val($("#TotalExpenseAmt").html());
                CalCTotalAmount();
            }
        });
    }
    

    
    function purchaseEntryExpensesDelete(id){
        var editId = $("#editId").val();
        $.ajax({
            type:'GET',
            url:'{{ url("common-destroy") }}?table=purchase_entry_expenses&key=id&value='+id,
            success:function(res){
                // console.log(res);
                if(editId==0){
                    ShowPurchaseEntryExpenses();
                }else{
                    EDITshowPurchaseEntry(editId);
                }
                
            }
        });
    }



    function CalCTotalAmount(){
        var TotalExpenseAmt = $("#expenseAmt").val();
        var purchaseDetailsTotalAmt = $("#purchaseDetailsTotalAmt").html();
        var totalAmt=0;
        if(TotalExpenseAmt==''){ TotalExpenseAmt = 0; }
         
        if (TotalExpenseAmt > 0){
            var totalAmt = parseFloat(purchaseDetailsTotalAmt)+parseFloat(TotalExpenseAmt);
        }
        else if (TotalExpenseAmt == 0){
            var totalAmt = parseFloat(purchaseDetailsTotalAmt)+parseFloat(TotalExpenseAmt);
        }
        else{
            var ExpenseAmt = Math.abs(TotalExpenseAmt);
            var totalAmt = parseFloat(purchaseDetailsTotalAmt)-parseFloat(ExpenseAmt);
        }

        
        $("#totalAmt").val(totalAmt);
    }
     
</script>


<!-- ============= EDIT PART ============= -->
<script>
    function EDITshowPurchaseEntry(pid){
        $.ajax({
            type:'GET',
            url:'{{ url("EDITshowPurchaseEntry") }}?pid='+pid,
            success:function(res){
                var x = JSON.parse(res);
                console.log(x);                        
                $("#showPurchaseEntryDetails").html(x[0]);  
                $("#ShowPurchaseEntryExpenses").html(x[1]);
                $("#expenseAmt").val($("#TotalExpenseAmt").html());
                CalCTotalAmount();
            }
        });
    }


    function select_purchase_entry(pid){
        $.ajax({
            type:'GET',
            url:'{{ url("select-record") }}?table=purchase_entries&key=id&value='+pid,
            success:function(res){
                // console.log(res[2]);       
                var x = JSON.parse(res);
                // console.log(x);
                $("#pid").val(pid);      
                $("#formTitle").html("Edit Purchase Entry");
                getSupplier(x.partyId);
                var pdate = moment(x.purchaseDate).format('DD-MM-YYYY');
                $("#date").val(pdate);
                $("#vehicleNumber").val(x.vehicleNumber);
                $("#billPrintName").val(x.billPrintName);
                getBillPrintName(x.billPrintName);
            }
        });
    }

</script>


@if(isset($_GET['id']))
    <script>
        EDITshowPurchaseEntry(@php echo $_GET['id']; @endphp);
        select_purchase_entry(@php echo $_GET['id']; @endphp)
    </script>
@else
    <script>
        showPurchaseEntryDetails();
        ShowPurchaseEntryExpenses();
    </script>
@endif