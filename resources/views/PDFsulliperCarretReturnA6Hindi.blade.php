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
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700&amp;subset=devanagari,latin-ext" rel="stylesheet">
 
 <style>
  @font-face {
font-family: Hind;
font-style: normal;
font-weight: normal;
src: url(http://example.com/hind.ttf) format('truetype');
}
* { 
font-family: Hind, DejaVu Sans, sans-serif;
}

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
    line-height:15px;
}
table{
border-collapse: separate;
}

body{ margin: 25px; }

@page {
  size: 5.5in 8.5in;
}


    </style>
</head>
<body>
<table cellspacing="5px" rowspacing="5px" >
        <tr>
            <th  style='text-align:center; ' colspan="6">
            {{ $comp->nameHindi }}
            </th>
          
        </tr>
        <tr>
        <td  style='text-align:center;' colspan="6" ><b> {{ $comp->addressHindi }}<br><br>
        मो. :</b> {{ $comp->mobile }},{{ $comp->mobile2 }}<br><br>
        <b>कैरट पावती</b></td>
        </tr>
        <tr class="row2">
            <td colspan="3"> <b> तारीख :</b> </td>
            <td colspan="3"> {{ date('d-m-Y',strtotime($row->date)) }} </td>
        </tr>
        <tr>
            <td colspan="3"> <b>व्यापारी का नाम :</b></b></td>
            <td colspan="3"> {{ commonController::getValueStatic('master_customer_suppliers','nameHindi','id',$row->partyId) }}</td>
        </tr>
        <tr>
            <td colspan="3"> <b>पिछला बकाया कैरट </b></td>
            <td colspan="3"> <?php echo  CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($row->partyId, date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $row->date) ) ))  ) ?></td>
        </tr>
        <tr class="row3">
            <td colspan="3"> <b>जमा  कैरट : </b></td>
            <td colspan="3"> {{ commonController::getValueStatic('master_units','name','id',$row->unitId) }} : {{ $row->qty }}</td>
        </tr>
        @if($row->discount != 0)
        <tr>
            <td colspan="3"> <b>डिस्काउंट केरेट : </b></td>
            <td colspan="3"> {{ commonController::getValueStatic('master_units','name','id',$row->unitId) }} : {{ $row->discount }}</td>
        </tr>
       @endif
       
        <tr class="row4">
            <td colspan="3" > <b> बकाया कैरट  : </b></td>
            <td colspan="3"> <?php echo  CustomerSupplierCarretLedger::getPartyCarretBalanceByDateStatic($row->partyId, $row->date ) ?></td>
        </tr>
        <tr>
            <td colspan="6"   style='text-align:right;'> <br> For {{ $comp->name }} </td>
        </tr>
</table>
</body>
</html>