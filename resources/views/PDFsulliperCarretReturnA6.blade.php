<?php 
use \App\Http\Controllers\commonController;
use \App\Http\Controllers\CustomerLedgerBook;
use \App\Http\Controllers\CustomerSupplierCarretLedger;
use Illuminate\Http\Request;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    

    <style>
   
    th.{
        font-size:24px;
    }
    

    tr.row2 td {
    padding-top: 20px;
   font-size:18px
}
tr.row3 td {
    padding-top: 20px;
   font-size:18px
}
tr.row4 td {
    padding-top: 20px;
   font-size:18px
}
td{
  
    font-size:18px;
}
table{
            border-collapse: separate;
        
                }

            body { margin: -25px; }

    </style>
</head>
<body>
<table   style="width:100%" cellspacing="5px" rowspacing="5px" >
        <tr>
            <th  style='text-align:center; ' colspan="6">
            {{ $comp->name }}
            </th>          
        </tr>
        <tr>
        <td  style='text-align:center;' colspan="6" ><b> {{ $comp->address }}<br>
        Mo. :</b> {{ $comp->mobile }},{{ $comp->mobile2 }}<br>
        <b>Caret Receipt </b></td>
        </tr>
        <tr class="row2">
            <td colspan="3"> <b> Date : </b></td>
            <td colspan="3"> {{ date('d-m-Y',strtotime($row->date)) }}</td>
        </tr>
        <tr>
            <td colspan="3"> <b>Supplier Name :</b></td>
            <td colspan="3"> {{ commonController::getValueStatic('master_customer_suppliers','name','id',$row->partyId) }}</td>
        </tr>
        <tr>
            <td colspan="3"> <b>Old Bal. Carret : </b></td>
            <td colspan="3">  <?php echo  CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($row->partyId, date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $row->date) ) ))  ) ?></td>
        </tr>
        <tr class="row3">
            <td colspan="3"> <b>Deposite Carret : </b></td>
            <td colspan="3"> {{ commonController::getValueStatic('master_units','name','id',$row->unitId) }} : {{ $row->qty }}</td>
        </tr>

        @if($row->discount != 0)
        <tr>
            <td colspan="3"> <b>Discount Carret : </b></td>
            <td colspan="3"> {{ commonController::getValueStatic('master_units','name','id',$row->unitId) }} : {{ $row->discount }}</td>
        </tr>
       @endif 

        <tr class="row4">
            <td colspan="3"> <b>Balance Carret : </b></td>
            <td colspan="3"> <?php echo  CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($row->partyId, $row->date ) ?></td>
        </tr>
        <tr>
            <td colspan="6" style='text-align:right;'>For  {{ $comp->name }} </td>
        </tr>
</body>
</html>