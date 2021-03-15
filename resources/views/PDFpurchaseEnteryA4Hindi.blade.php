<?php 
use \App\Http\Controllers\commonController;
use \App\Http\Controllers\CustomerLedgerBook;
use Illuminate\Http\Request;
use \App\Http\Controllers\CustomerSupplierCarretLedger;

$openingBalance = commonController::getValueStatic('master_customer_suppliers','openingBalance','id',$data->partyId);

$oldBalance = CustomerLedgerBook::OpeningBalance($data->partyId, $openingBalance);

?>
<!DOCTYPE html>
<html lang="en">
<head>


<link href="https://fonts.googleapis.com/css?family=Hind:400,700&amp;subset=devanagari,latin-ext" rel="stylesheet">
 
 <style>
  @font-face {
font-family: Hind;
font-style: normal;
src: url(http://example.com/hind.ttf) format('truetype');
}
* { 
font-family: Hind, DejaVu Sans, sans-serif;
}
         .border {
         position: fixed;
         top: 0;
         left: 0;
         border-style: solid;
        /* border-width: 1px;
         /* width: 100%; */
         height: 104%;
         border: 1px solid black;
         padding: 5px;
         margin:-20px;
         }

         td.tt{
            background-color: #686868;
            color: white;
            border: 1px solid black;
            font-size:16px;
         }
         td.t5{
            background-color:LightGray;
            border-bottom:solid 1px;
            border-top:solid 1px;
         }
         td.t1{
            border-top:solid 1px;
            font-size:15px;
         }
         td.t2{
            border: 1px solid black;
            font-size:15px;
            border-bottom:solid 1px;
         }
         td.t3{
            font-size:15px;
         }
         td.dot{
            border-top: 1px dotted black;
            border-bottom:solid 1px;
         }
         td{
             padding:4px;
         }
        
         th{
            font-size: 22px;
         }
         td{
            font-size: 18px;
            
         }
         table{
            /* border-collapse: separate; */
            /* border-spacing: 0 11px; */
         }

         .footer {
   position: fixed;
   left: 0;
   bottom: 30px;
   width: 100%;
   
   color: black;
   text-align: right;
}
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDFPurchaseEntryA4Hidni</title>
</head>
<body>
<div class="border">
    <table   style="width:100%" cellspacing="0" rowspacing="1px" >
        <tr>
            <td  style='text-align:center; ' colspan="6">
            {{ $comp->slogHindi }}
            </td>  
        </tr>
        <tr>
            <th  style='text-align:center; ' colspan="6">
            {{ $comp->nameHindi }}
            </th>
          
        </tr>
        <tr>
        <td  style='text-align:center;' colspan="6" ><b> {{ $comp->addressHindi }}<br>
        मो. :</b> {{ $comp->mobile }},{{ $comp->mobile2 }}<br>
<b>:- किसान बीजक:-</td>
        </tr>
        <tr>
            <td  colspan="3" class="t1"><b>श्री. : {{ isset($data->billPrintName) ? $data->billPrintName : commonController::getValueStatic('master_customer_suppliers','nameHindi','id',$data->partyId) }} </td>
            <td  colspan="3" style='text-align:right;' class="t1">बिल की तारीख: 02-02-2021 (मंगलवार)<br>
            गाडी नं. :</td>
        </tr>
  <tr>
      <td  class="tt">क्र.</td>
      <td   class="tt">बिल्टी नं</td>
      <td  class="tt">सब्जी का नाम</td>
      <td  style='text-align:right;' class="tt">वजन</td>
      <td  style='text-align:right;' class="tt">दर</td>
      <td  style='text-align:right;'  class="tt" >रकम</td>
  </tr>
  @php
        
        $totalWeight=0;
        $totalAmount=0;
         @endphp
        @foreach($records as $row)
        <tr>
            <td class="t2">{{ $loop->index+1 }}</td>
            <td class="t2"></td>
            <td class="t2">{{ commonController::getValueStatic('master_items','nameHindi','id',$row->itemId ) }}</td>
            <td class="t2" style='text-align:right;'>{{ $row->weight }}</td>
            <td class="t2" style='text-align:right;'>{{ $row->rate }}</td>
            <td class="t2" style='text-align:right;'>{{ $row->amount }}</td>
        </tr>
       
        @php
        
        $totalWeight+=$row->weight;
        $totalAmount+=$row->amount;
         @endphp
        @endforeach
        <tr>
            <td colspan="3" class="t2" style='text-align:right;'>Total Weight : {{ number_format($totalWeight,2) }}</td>
            <td colspan="2" class="t2" style='text-align:right;'>Total Amount </td>
            <td colspan="1" class="t2" style='text-align:right;'>{{ number_format($totalAmount,2) }}</td>
        </tr>
        <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tt" colspan="4"><b>खर्च :-</td>
    
    </tr>
    @php $totalExpenses=0; @endphp
    @foreach($expenses as $expen)
    <tr>
    <td colspan="3" class="t3"><b>(-) {{ commonController::getValueStatic('master_addtional_expenses','nameHindi','id',$expen->masterAddtionalExpensesId ) }} </td>
    <td style='text-align:right;'>{{ number_format($expen->amount,2) }}</td>
    </tr>
    @php $totalExpenses+=$expen->amount; @endphp
    @endforeach
  <tr>
    <td colspan="3" class="dot"><b> Totel</td>
    <td style='text-align:right;' class="dot">-{{ number_format($totalExpenses,2) }}</td>
    </tr>
    <tr><td colspan="4"></td></tr>
<tr>

    <td></td>
    <td colspan="4"><br><b>Total Exp. :</td>
    <td colspan="1" style='text-align:right;' ><br>-{{ number_format($totalExpenses,2) }}</td>
</tr>
<tr>
    <td class="t5"></td>
    <td  colspan="4" class="t5"><b>Pakka Sale :</td>
    <td  colspan="1" class="t5" style='text-align:right;'>{{ number_format($totalAmount-$totalExpenses,2) }}</td>
</tr>
<b><br>Balance Carret : <?php echo  CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($data->partyId, $data->date ) ?></b>
    </table>
  
</div >

</body>
</html>