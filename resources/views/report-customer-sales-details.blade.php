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
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Customer Sale Report Details  
                        </h3>
                        {{-- <a href="{{ url('/master-unit') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ "Add New Unit" }}</a> --}}
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">

                            <div class="pull-right">
                                <a target="_blank" href="{{ url('PDFCustomerSaleA4') }}?partyId={{ $_GET['partyId'] }}&date={{ $_GET['date'] }}" class="btn btn-primary" rel="tooltip" title="Print EN A4">
                                    <i class="fa fa-print" aria-hidden="true"></i> A4
                                </a>
                                <a target="_blank" href="{{ url('PDFCustomerSaleA5') }}?partyId={{ $_GET['partyId'] }}&date={{ $_GET['date'] }}" class="btn btn-primary" rel="tooltip" title="Print A5">
                                    <i class="fa fa-print" aria-hidden="true"></i> A5
                                </a>
                                <a target="_blank" href="{{ url('PDFCustomerSaleA6') }}?partyId={{ $_GET['partyId'] }}&date={{ $_GET['date'] }}" class="btn btn-primary" rel="tooltip" title="Print A6">
                                    <i class="fa fa-print" aria-hidden="true"></i> A6
                                </a>
    
                                <a target="_blank" href="{{ url('PDFCustomerSaleHiA4') }}?partyId={{ $_GET['partyId'] }}&date={{ $_GET['date'] }}" class="btn btn-warning" rel="tooltip" title="Print HI A4">
                                    <i class="fa fa-print" aria-hidden="true"></i> A4
                                </a>
    
                                <a target="_blank" href="{{ url('PDFCustomerSaleHiA5') }}?partyId={{ $_GET['partyId'] }}&date={{ $_GET['date'] }}" class="btn btn-warning" rel="tooltip" title="Delete">
                                    <i class="fa fa-print" aria-hidden="true"></i> A5
                                </a>
    
                                <a target="_blank" href="{{ url('PDFCustomerSaleHiA6') }}?partyId={{ $_GET['partyId'] }}&date={{ $_GET['date'] }}" class="btn btn-warning" rel="tooltip" title="Delete">
                                    <i class="fa fa-print" aria-hidden="true"></i> A6
                                </a>
                            </div>
                            
                            <table id="myTable2" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Bill Date</th>
                                        <th>Customer</th>   
                                        <th>Item</th>   
                                        <th>Unit</th>   
                                        <th>Rate</th>       
                                        <th>KG/Unit</th>   
                                        <th>QTY</th>    
                                        <th>Unit Charge</th>                 
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $QTYT=0; $AMOUNTT=0; $WEIGHTT=0; $extraAmt=0;
                                    @endphp
                                    @foreach($customer_sales as $row)
                                    <?php 
                                        $QTYT += $row->qty; 
                                        $AMOUNTT += $row->amount; 
                                        $WEIGHTT += $row->weight; 

                                        $partType = commonController::getPartyTypeStatic($row->partyId);
                                        $unitRate = 0;
                                        $unitRate = commonController::getStaticValueByMultiWhere('custom_unit_rates','rate',['partyId'=>$row->partyId,'unitId'=>$row->unitId]);
                                        if($unitRate == '' || $unitRate == null){
                                            $unitRate = commonController::getValueStatic('master_units',$partType,'id',$row->unitId);                                       
                                        }
                                        $extraAmt += $unitRate*$row->qty;
                                    ?>
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ date('d-m-Y', strtotime($row->date)) }}</td>
                                            <td>{{ commonController::getValueStatic('master_customer_suppliers','name','id',$row->partyId) }}</td>                                           
                                            <td>{{ commonController::getValueStatic('master_items','name','id',$row->itemId) }}</td>
                                            <td>{{ commonController::getValueStatic('master_units','name','id',$row->unitId) }}</td>
                                            <td>{{ $row->rate }}</td>
                                            <td>{{ $row->weight }}</td>
                                            <td>{{ $row->qty }}</td>
                                            <td>{{ $unitRate*$row->qty }}</td>
                                            <td>{{ $row->amount+($unitRate*$row->qty) }}</td>
                                            
                                            <td class='hidden-480'>
                                           
                                                <a href="{{ url('/customer-sale') }}?id={{ $row->id }}" class="btn btn-inverse btn--icon" rel="tooltip" title="View">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="{{ url('common-destroy?table=customer_sales&key=id&value='.$row->id) }}" class="btn btn-danger btn--icon" rel="tooltip" title="View">
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
                                        <th></th>                                        
                                        <th></th>
                                        <th>{{ $WEIGHTT }}</th>
                                        <th>{{ $QTYT }}</th>
                                        <th>{{ $extraAmt }}</th>
                                        <th>{{ $AMOUNTT+$extraAmt }}</th>
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


@endsection

