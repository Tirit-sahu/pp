<?php 
use \App\Http\Controllers\commonController;
use \App\Http\Controllers\CustomerLedgerBook;
use Illuminate\Http\Request;

$count = sizeof($master_units); $i=1;
$balCarret='';

$totalAmt=0;
$extraAmt = 0;
$totalBalance=0;
foreach($master_units as $row){
   $unitRate = commonController::getValueStatic('master_units',$partType,'name',$row->name);
   $unitQty = CustomerLedgerBook::getCarretOpenByDate($_GET['partyId'], $row->id, $_GET['date']);
   $extraAmt += $unitRate*$unitQty;
   $comma = ''; if($i<$count){ $comma = ','; } 
   $balCarret .= $row->name ." : ".$unitQty.$comma." "; 
    ++$i; 
}

$openingBalance = commonController::getValueStatic('master_customer_suppliers','openingBalance','id',$_GET['partyId']);

$oldBalance = CustomerLedgerBook::OpeningBalance($_GET['partyId'], $openingBalance);
define("DOMPDF_UNICODE_ENABLED", true);
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>      
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
      
      <style>
         @page {
         size: A5;
         /* margin: 0;         */
         }
        
         td{
         border-left:none;
         border-right:none;
         border-top:solid;
         font-size:14px;
         padding:4px;
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
         /* top: 0; */
         /* left: 0; */
         border-style: solid;
         border-width: 1px;
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
   <body class="A5">

 
     
            <div class="border sheet padding-10mm"">
               <table  cellpadding="0" cellspacing="0" style="width:100%">
                  <tr>
                     <td style='text-align:center;' colspan="6" class="tt"> 
                     
                     <b>{{ $master_company_settings->nameHindi }}<br>
                        {{ $master_company_settings->addressHindi }}<br>
                        मो.: {{ $master_company_settings->mobile }}, {{ $master_company_settings->mobile2 }}<br>
                        -: ग्राहक बिल:- </b>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="3">
                        <b style="font-family:ind_hi_1_001;'"> {{ commonController::getValueStatic('master_customer_suppliers','nameHindi','id',$_GET['partyId']) }}  <b>
                     </td>
                     <td colspan="3">
                        <p  style="text-align:right;">
                          रशीद क्र. : {{ $_GET['partyId'].strtotime($_GET['date']) }}
                           <br>
                          बिल दिनांक: <?php echo date('d-m-Y', strtotime($_GET['date'])); echo " (".date('D', strtotime($_GET['date'])).")"; ?>
                        </p>
                     </td>
                  </tr>
                  <tr>
                     <th >क्र.</th>
                     <th>सब्जी का नाम</th>
                     <th>वजन</th>
                     <th>दर </th>
                     <th>रिमार्क</th>
                     <th>रकम </th>
                  </tr>
                  @foreach($customer_sales as $row)
                  <?php $totalAmt += $extraAmt+$row->amount; ?>
                  <tr style='text-align:center;'>
                     <td >{{ $loop->index+1 }}</td>
                     <td>
                        {{ commonController::getValueStatic('master_items','name','id',$row->itemId) }} &nbsp;
                        {{ $row->qty }}
                        {{ commonController::getValueStatic('master_units','name','id',$row->unitId) }}
                     </td>
                     <td>{{ $row->weight }}</td>
                     <td>{{ $row->rate }}</td>
                     <td>{{ $row->remark }}</td>
                     <td>{{ $row->amount }}</td>
                  </tr>
                  @endforeach
                  <tr style='text-align:center;'>
                     <td colspan="5"style='text-align:right;'>
                        <b>अतिरिक्त राशि:-</b><br>
                        <b>कुल राशि :-</b>
                     </td>
                     <td colspan="1">
                        <b> {{ $extraAmt }} <br>
                           {{ $totalAmt }}<b>
                     </td>
                  </tr>
                  <tr style='text-align:center;'>
                     <td colspan="5"style='text-align:right;'>
                        <b>पिछला बकाया:- </b><br>
                     </td>
                     <td colspan="1">
                        <b> {{ $oldBalance }} <br>
                     </td>
                  </tr>
                  <tr style='text-align:center;'>
                     <td colspan="5"style='text-align:right;' class="tq">
                        <b>कुल बकाया :- 
                        </b><br>
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
                        <br>
                     </td>
                  </tr>
                  
               </table>
               <b style="font-size: 16px;margin-left:5px;">Bal. Carret : {{ $balCarret }}</b>
            </div>
        
            

   </body>
</html>

<script>
   window.print();
   // window.resizeTo(595, 842);
   var size = [window.width,window.height];  //public variable

$(window).resize(function(){
  window.resizeTo(size[0],size[1]);
});
</script>

