@extends('layouts.app')
@section('content')
<?php 
use \App\Http\Controllers\commonController;
use Illuminate\Http\Request;

?>
    <div class="container-fluid">
                
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Purchase Payment Details  
                        </h3>
                        {{-- <a href="{{ url('/master-unit') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ "Add New Unit" }}</a> --}}
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">

                           
                            
                            <table id="myTable2" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Receipt No.</th>
                                        <th>Payment Date</th>
                                        <th>Customer</th>   
                                        <th>Paid Amount</th>   
                                        <th>Discount Amount</th>   
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $AMOUNTT=0; $DISCAMT=0; @endphp
                                    @foreach($purchase_payment_entries as $row)
                                    <?php 
                                        $AMOUNTT += $row->amount; 
                                        $DISCAMT += $row->discount; 
                                    ?>
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td></td>
                                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                            <td>{{ commonController::getValueStatic('master_customer_suppliers','name','id',$row->partyId) }}</td>                                           
                                            <td>{{ $row->amount }}</td>
                                            <td>{{ $row->discount }}</td>                                          
                                            
                                            <td class='hidden-480'>
                                                {{-- {{ url('/purchase-payment-entries') }}?id={{ $row->id }} --}}
                                                <a onclick="editPurchasePayment({{ $row->id }});" href="#" class="btn btn-inverse btn--icon" rel="tooltip" title="View">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a onclick="return confirm('Are you sure?')" href="{{ url('common-destroy?table=purchase_payment_entries&key=id&value='.$row->id) }}" class="btn btn-danger btn--icon" rel="tooltip" title="View">
                                                    <i class="fa fa-trash"></i>
                                                </a>                                               

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total:</th>
                                        <th></th>                                       
                                        <th></th>
                                        <th></th>
                                        <th>{{ $AMOUNTT }}</th>
                                        <th>{{ $DISCAMT }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>

    @include('purchasePaymentEditModal')

@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

        
</script>

<script>
    function editPurchasePayment(id){
        $("#purchasePaymentEdit").modal('show');
        $.ajax({
            type:'GET',
            url:'{{ url("purchasePaymentEdit") }}?id='+id,
            success:function(res){
                // console.log(res);
                var x = JSON.parse(res);
                var date = moment(x.date).format('YYYY-MM-DD');
                // console.log(date);
                $('#purchasePaymentEditForm').attr('action', "purchasePaymentUpdate/"+id);
                getSupplier(x.partyId);
                $("#date").val(date);
                $("#amount").val(x.amount);
                $("#discount").val(x.discount);
                $("#narration").val(x.narration);
            }
        });
    }
</script>

