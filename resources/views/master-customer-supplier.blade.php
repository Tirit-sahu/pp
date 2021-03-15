@extends('layouts.app')
@section('content')
<?php  

use \App\Http\Controllers\commonController;
use Illuminate\Http\Request;

$partyId=0;
$action=url('/master-customer-supplier-store');
$groupName='';
$status='';
$customer='';
$supplier='';
$loader='';
$button='SAVE';
$photo='';
$EbalanceType = '';
if (isset($master_customer_supplier)) {
    $action=url('/master-customer-supplier-update', array($master_customer_supplier->id));
    $groupName=$master_customer_supplier->groupName;
    $status=$master_customer_supplier->status;
    $customer=$master_customer_supplier->customer;
    $supplier=$master_customer_supplier->supplier;
    $loader=$master_customer_supplier->loader;
    $button='UPDATE';
    $photo = $master_customer_supplier->photo;
    $EbalanceType = $master_customer_supplier->balanceType;
    $partyId=$master_customer_supplier->id;
}
?>

<style>
    input{
        text-transform: capitalize;
    }
</style>
    <div class="container-fluid">
                
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Add New Customer/Supplier    
                        </h3>
                        <a href="{{ url('/master-customer-supplier-datatable') }}" class="btn btn-satgreen pull-right"><i class="fa fa-list-ul" aria-hidden="true"></i> {{ "Customer/Supplier Datatable" }}</a>
                    </div>
                    <div class="box-content">
                        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class='form-horizontal'>
                            @csrf
                            
                            <x-alert/>
                            
                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="name" class="control-label col-sm-2">Customer/Supplier Name </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" value="{{ old('name', isset($master_customer_supplier)?$master_customer_supplier->name:'') }}" id="name" class="form-control">
                                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="nameHindi" class="control-label col-sm-2">Customer/Supplier Name (Hindi) </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nameHindi" value="{{ old('nameHindi', isset($master_customer_supplier)?$master_customer_supplier->nameHindi:'') }}" id="nameHindi" class="form-control">
                                            @error('nameHindi') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
        
                                    <div class="form-group">
                                        <label for="mobile" class="control-label col-sm-2">Mobile Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="mobile" value="{{ old('mobile', isset($master_customer_supplier)?$master_customer_supplier->mobile:'') }}" id="mobile" maxlength="10" class="form-control">
                                            @error('mobile') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="address" class="control-label col-sm-2">Address
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="address" value="{{ old('address', isset($master_customer_supplier)?$master_customer_supplier->address:'') }}" id="address" class="form-control">
                                            @error('address') <span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>                                     
                                    
                                      
                                    <div class="form-group">
                                        <label for="openingBalance" class="control-label col-sm-2">Opening Balance</label>
                                        <div class="col-sm-10">
                                            <div class="col-sm-8" style="padding-left: 0;">
                                                <input type="text" name="openingBalance" value="{{ old('openingBalance', isset($master_customer_supplier)?$master_customer_supplier->openingBalance:'') }}" id="openingBalance" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <?php 
                                                    $balanceType = ['CR', 'DR'];
                                                ?>
                                                <select name="balanceType" id="balanceType" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($balanceType as $bt)
                                                    <option @if($EbalanceType==$bt) selected @endif value="{{ $bt }}">{{ $bt }}</option>
                                                    @endforeach
                                                </select>
                                            </div>                                           
                                        </div>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label for="creditLimitAmount" class="control-label col-sm-2">Credit Limit Amt
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="text" name="creditLimitAmount" value="{{ old('creditLimitAmount', isset($master_customer_supplier)?$master_customer_supplier->creditLimitAmount:'') }}" id="creditLimitAmount" class="form-control">
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="creditLimitTransaction" class="control-label col-sm-2">Credit Limit Tans.</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="creditLimitTransaction" value="{{ old('creditLimitTransaction', isset($master_customer_supplier)?$master_customer_supplier->creditLimitTransaction:'') }}" id="creditLimitTransaction" class="form-control">
                                        </div>
                                    </div> 

                                          

                                </div>
                                <div class="col-sm-6">

                                    

                                    <div class="form-group">
                                        <label for="type" class="control-label col-sm-2">Type</label>
                                        <div class="col-sm-10">
                                            <div class="check-demo-col">
                                            <div class="check-line">
                                                <input type="checkbox" name="customer" value="1" id="Customer" @if($customer==1) checked @endif class='icheck-me' data-skin="square" data-color="blue">
                                                <label class='inline' for="Customer">Customer</label>
                                            </div>
                                            </div>
                                            <div class="check-demo-col">
                                            <div class="check-line">
                                                <input type="checkbox" name="supplier" value="1" id="Supplier" @if($supplier==1) checked @endif class='icheck-me' data-skin="square" data-color="blue">
                                                <label class='inline' for="Supplier">Supplier</label>
                                            </div>
                                            </div>
                                            <div class="check-demo-col">
                                            <div class="check-line">
                                                <input type="checkbox" name="loader" value="1" @if($loader==1) checked @endif id="Loader" class='icheck-me' data-skin="square" data-color="blue">
                                                <label class='inline' for="Loader">Loader</label>
                                            </div>
                                            </div>                                            
                                           
                                        </div>
                                    </div> 


                                    <div class="form-group">
                                        <label for="addressHindi" class="control-label col-sm-2">Group Name</label>
                                        <div class="col-sm-10">
                                            <select id="groupName" name="groupName" class="form-control">
                                                <option value="" selected>Select</option>
                                                @foreach($master_groups as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                            <script>
                                                document.getElementById("groupName").value = @php echo $groupName; @endphp
                                            </script>
                                        </div>
                                    </div>

                                    @foreach($master_units as $row)
                                    <?php 
                                    $openingUnitE='';
                                    if(isset($master_customer_supplier)){
                                    $where = array(
                                        'mCustomerSupplierId'=>$master_customer_supplier->id,
                                        'unitId'=>$row->id
                                    );
                                    $openingUnitE = commonController::getStaticValueByMultiWhere('master_customer_supplier_unit_entries','openingUnit',$where);
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label for="openingSPN" class="control-label col-sm-2">Opening {{ $row->name }}</label>
                                        <div class="col-sm-10">

                                            <input type="hidden" name="unitId[]" value="{{ $row->id }}" id="unitId" class="form-control">

                                            <input type="text" name="openingUnit[]" value="{{ $openingUnitE }}" id="openingSPN" class="form-control">

                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="form-group">
                                        <label for="status" class="control-label col-sm-2">Status</label>
                                        <div class="col-sm-10">
                                            <?php $statusArray = ["Active", "InActive"]; ?>
                                            <select id="status" name="status" class="form-control">
                                                @foreach($statusArray as $row)
                                                <option @if($status==$row) selected @endif value="{{ $row }}">{{ $row }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="photo" class="control-label col-sm-2">Photo</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="photo" id=""><br>
                                            @if($photo!='')
                                            <a title="View Photo" target="_blank" href="{{ asset('public/storage/DOCCustomerSupplierLoader/'.$master_customer_supplier->photo) }}">
                                                <img width="80" src="{{ asset('public/storage/DOCCustomerSupplierLoader/'.$master_customer_supplier->photo) }}" alt="Photo Not Available">
                                            </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="photo" class="control-label col-sm-2">Manual</label>
                                        <div class="col-sm-10">
                                            <a onclick="unitModal()" style="cursor: pointer;" class="btn btn-danger"><i class="fa fa-link" aria-hidden="true"></i> Choose Unit</a>
                                        </div>
                                    </div>

                                </div>
                            </div>                     
                            
                            
                            <div class="form-actions pull-right">                                
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-floppy-o" aria-hidden="true"></i>  {{ $button }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>


    <!-- modal -->
    <div class="modal fade" id="unitModal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <form id="customUnitRateForm" method="POST">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" name="partyId" id="partyId" value="{{ $partyId }}">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Set Custom Unit Rate</h4>
            </div>
            <div class="modal-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>SNO</th>
                        <th>Unit Name</th>
                        <th>Unit Rate</th>
                      </tr>
                    </thead>
                    <tbody id="unitList">
                                          
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" style="background:#378EE0;color:white;" class="btn btn-Primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
            </div>
          </div>
        </form>
        </div>
    </div>
    <!-- end modal -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function unitModal(){           
            
            $("#unitModal").modal('show');
            getCustomUnitData();
        }


        function getCustomUnitData(){
            var partyId = $("#partyId").val();
            $.ajax({
                type:'GET',
                url:'{{ url("changeUnitRatePartyWise") }}?partyId='+partyId,
                success:function(res){  
                    console.log(res);
                    $("#unitList").html(res);
                }
            });
        }
    </script>

    <script>
    $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
 
     $('#customUnitRateForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
       //  $('#image-input-error').text('');
 
        $.ajax({
           type:'POST',
           url: '{{ url("postcustomUnitRate") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
             console.log(res);
            //  $('#customUnitRateForm')[0].reset();
             getCustomUnitData();
             $("#unitModal").modal('hide');
            //  $("#unitModal").modal('hide');
            //  if(res==1){
            //     $('#customUnitRateForm')[0].reset();
            //     showBatteryOpeingRecord();
            //     swal("New Record Added Successfully!", "", "success");
            //  }else{
            //     swal("Something went wrong", "", "error");
            //  }
            }
        });
   });
 
 </script>

@endsection
