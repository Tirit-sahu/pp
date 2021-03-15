<?php 
use \App\Http\Controllers\commonController;
use \App\Http\Controllers\CustomerSupplierCarretLedger;
use \App\Http\Controllers\CustomerLedgerBook;
use Illuminate\Http\Request;

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$newdate = date("Y-m-d", strtotime("-1 day"));
$OldCarretBal= CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($customer_carret_receives->partyId, $newdate);
$CurCarretBal= CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($customer_carret_receives->partyId, $date);

        $day = date('D', strtotime($customer_carret_receives->date));
        $dayInHi = commonController::staticEnDayToHiDay($day);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table cellspacing="5px" rowspacing="5px" >
        <tr>
            <th  style='text-align:center; ' colspan="6">
                {{ $comp->name }}
            </th>
          
        </tr>
        <tr>
        <td  style='text-align:center;' colspan="6" ><b>{{ $comp->address }}<br>
            Mo. :</b> {{ $comp->mobile.", ".$comp->mobile2 }}<br>
            <b>Caret Receipt</td>
        </tr>
        <tr class="row2">
            <td colspan="3"> <b> Date : </b></td>
            <td colspan="3"> {{ date('d-m-Y', strtotime($customer_carret_receives->date)) }} ( {{$day}} )</td>
        </tr>
        <tr>
            <td colspan="3"> <b>Customer Name :</b></td>
            <td colspan="3"> {{ commonController::getValueStatic('master_customer_suppliers','name','id',$customer_carret_receives->partyId) }} </td>
        </tr>
        <tr>
            <td colspan="3"> <b>Old Bal. Carret : </b></td>
            <td colspan="3"> {{ $OldCarretBal }}</td>
        </tr>
        <tr class="row3">
            <td colspan="3"> <b>Deposite Carret : </b></td>
            <td colspan="3">{{ $customer_carret_receives->qty }}</td>
        </tr>
        @if($customer_carret_receives->narration!='')
        <tr>
            <td colspan="3"> <b>Remark </b></td>
            <td colspan="3"> {{ $customer_carret_receives->narration }}</td>
        </tr>
        @endif
        <tr class="row4">
            <td colspan="6" style="font-size: 14px;"> <b>Balance Carret : </b> {{ $CurCarretBal }}</td>
        </tr>
        <tr>
            <td colspan="6"   style='text-align:right;'>For {{ $comp->name }} </td>
        </tr>
</body>
</html>