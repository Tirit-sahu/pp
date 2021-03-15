<?php 
use \App\Http\Controllers\commonController;
use \App\Http\Controllers\CustomerLedgerBook;
use Illuminate\Http\Request;

$partyId = 0;
if (isset($_GET['partyId'])) {
   $partyId = $_GET['partyId'];
}

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');

$count = sizeof($master_units); $i=1;
$balCarret='';
$totalBalance=0;

foreach($master_units as $row){
   $unitQty = CustomerLedgerBook::getCarretOpenByDate($_GET['partyId'], $row->id, $date);
   $comma = ''; if($i<$count){ $comma = ','; } 
   $balCarret .= $row->name ." : ".$unitQty.$comma." "; 
    ++$i; 
}

$openingBalance = commonController::getValueStatic('master_customer_suppliers','openingBalance','id',$_GET['partyId']);

$oldBalance = CustomerLedgerBook::OpeningBalance($_GET['partyId'], $openingBalance);

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
</style>
   <style>
         td{
         border-left:none;
         border-right:none;
         border-top:solid;
         font-size:14px;
         padding:4px;
         font-family:"Times New Roman", Times, serif;
         }
         
         th{
         border-left:none;
         border-right:none;
         color: #fff; 
         background: black;
         font-size:13px;
         }
         .border {
         position: fixed;
         top: 0;
         left: 0;
         border-style: solid;
         border-width: 1px;
         width: 100%;
         height: 100%;
         margin: 0;
         padding: 0;
         }
         td.tt{
         font-size:17px;
         }
         td.tq{
         border-bottom:solid;
         }
      </style>
   </head>
   <body>
     
            <div class="border">
               <table  cellpadding="0" cellspacing="0" style="width:100%" >
                  <tr>
                     <td style='text-align:center;' colspan="6" class="tt"> 
                        
                        <b>{{ $master_company_settings->name }}<br>
                           {{ $master_company_settings->address }}<br>
                        Mo. : {{ $master_company_settings->mobile }}, {{ $master_company_settings->mobile2 }}<br>
                        -: Customer Bill :- </b>
                        
                     </td>
                  </tr>
                  <tr>
                     <td colspan="3">
                        <b>  {{ commonController::getValueStatic('master_customer_suppliers','name','id',$_GET['partyId']) }}  <b>
                     </td>
                     <td colspan="3">
                        <p  style='text-align:right;'>
                           Vouchar No : {{ $_GET['partyId'].strtotime($_GET['date']) }}
                           <br>
                           Bill Date : <?php echo date('d-m-Y', strtotime($_GET['date'])); echo " (".date('D', strtotime($_GET['date'])).")"; ?>
                        </p>
                     </td>
                  </tr>
                  <tr>
                     <th >No.</th>
                     <th>Particulars</th>
                     <th>Weight</th>
                     <th>Rate </th>
                     <th>Remark</th>
                     <th>Amount </th>
                  </tr>
                  <?php 
                  $extraAmt=0;
                  $totalAmt=0;
                  ?>
                  @foreach($customer_sales as $row)
                  <?php                   
                  $unitRate = 0;
                  $unitRate = commonController::getStaticValueByMultiWhere('custom_unit_rates','rate',['partyId'=>$partyId,'unitId'=>$row->unitId]);
                  if($unitRate == '' || $unitRate == null){
                     $unitRate = commonController::getValueStatic('master_units',$partType,'id',$row->unitId);
                  }                  
                  $extraAmt += $row->qty * $unitRate;
                  $totalAmt += $extraAmt+$row->amount; 
                  ?>
                  <tr style='text-align:center;'>
                     <td >{{ $loop->index+1 }}</td>
                     <td>
                        {{ commonController::getValueStatic('master_items','name','id',$row->itemId) }} &nbsp;
                        {{ $row->qty }}
                        {{ commonController::getValueStatic('master_units','name','id',$row->unitId) }}
                     </td>
                     <td>{{ $row->weight * $row->qty }}</td>
                     <td>{{ $row->rate }}</td>
                     <td>{{ $row->remark }}</td>
                     <td>{{ $row->amount }}</td>
                  </tr>
                  @endforeach

                  <tr style='text-align:center;'>
                     <td colspan="5"style='text-align:right;'>
                        <b>Extra Amount:-</b><br>
                        <b>Total Amount :-</b>
                     </td>
                     <td colspan="1">
                        <b> 
                        {{ $extraAmt }}<br>
                        {{ $totalAmt }}</b>
                     </td>
                  </tr>
                  <tr style='text-align:center;'>
                     <td colspan="5"style='text-align:right;'>
                        <b>Old Bal. :- </b><br>
                     </td>
                     <td colspan="1">
                        <b> {{ $oldBalance }} </b><br>
                     </td>
                  </tr>
                  <tr style='text-align:center;'>
                     <td colspan="5"style='text-align:right;' class="tq">
                        <b>Toal Bal. :- </b><br>                        
                     </td>
                     <td colspan="1"  class="tq">
                        <b>
                        <?php 
                           if($oldBalance>=0){
                              $totalBalance = $oldBalance+$totalAmt;
                           }else{
                              $oldBalance = abs($oldBalance);
                              $totalBalance = $oldBalance-$totalAmt;
                           } 
                           
                           echo $totalBalance;
                        ?>
                        </b>
                        <br>
                     </td>
                  </tr>
                  <b style="font-size: 14px;">Bal. Carret : {{ $balCarret }}</b>
               </table>
            </div>
        
   </body>
</html>