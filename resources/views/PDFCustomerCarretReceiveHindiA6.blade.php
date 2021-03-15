<?php 

use \App\Http\Controllers\commonController;
use \App\Http\Controllers\CustomerSupplierCarretLedger;
use \App\Http\Controllers\CustomerLedgerBook;
use Illuminate\Http\Request;

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$newdate = date("Y-m-d", strtotime("-1 day"));
$OldCarretBal = CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($customer_carret_receives->partyId, $newdate);
$CurCarretBal = CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($customer_carret_receives->partyId, $date);

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
<center>
<table cellspacing="5px" rowspacing="5px">
<tr>
<th style='text-align:center; ' colspan="6"><br><br>
{{ $comp->nameHindi }}
</th>          
</tr>
<tr>
<td  style='text-align:center;' colspan="6" ><b> {{ $comp->addressHindi }}<br><br>
मो. :</b> {{ $comp->mobile.", ".$comp->mobile2 }}<br><br>
<b>कैरट पावती</td>
</tr>
<tr class="row2">
<td colspan="3"> <b> तारीख : </b></td>
<td colspan="3"> {{ date('d-m-Y', strtotime($customer_carret_receives->date)) }} ( {{$dayInHi}} )</td>
</tr>
<tr>
<td colspan="3"> <b>ग्राहक का नाम :</b></td>
<td colspan="3"> {{ commonController::getValueStatic('master_customer_suppliers','nameHindi','id',$customer_carret_receives->partyId) }} </td>
</tr>
<tr>
<td colspan="3"> <b>पिछला बकाया कैरट : </b></td>
<td colspan="3"> {{ $OldCarretBal }}</td>
</tr>
<tr class="row3">
<td colspan="3"> <b>जमा  कैरट : </b></td>
<td colspan="3"> {{ $customer_carret_receives->qty }}</td>
</tr>
@if($customer_carret_receives->narration!='')
<tr>
<td colspan="3"> <b>रिमार्क </b></td>
<td colspan="3"> {{ $customer_carret_receives->narration }}</td>
</tr>
@endif
<tr class="row4">
<td colspan="3" > <b> बकाया कैरट  : </b></td>
<td colspan="3">{{ $CurCarretBal }}</td>
</tr>
<tr>
<td colspan="6" style='text-align:right;font-size:16px;'><br><br>For Pavan Putra Sabji Bhandar </td>
</tr>
</table>
</center>
</body>
</html>