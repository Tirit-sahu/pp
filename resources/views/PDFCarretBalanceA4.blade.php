<?php 
use \App\Http\Controllers\commonController;
use \App\Http\Controllers\CustomerLedgerBook;
use Illuminate\Http\Request;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>customer_balance_report_A5</title>
    <style>
    .border {
         position: fixed;
         top: 0;
         left: 0;
         border-style: solid;
         /* border-width: 1px;
         /* width: 100%; */
         height: 104%;
         border: 1px solid black;
         /* padding: 5px; */
         margin:-20px;
         }
         td{
            border: 1px solid black;
            font-size:14px;
            padding:4px;
         }
         tr.t1 td{
            padding-bottom: 20px;
         }
         th{
             font-size:22px;
         }
         td.l1{
            font-size:16px;
         }
         p{
             padding-top:450px;

         }
    </style>
</head>
<body>
<div class="border">
    <table style="width:100%" cellspacing="0" rowspacing="1px" >
        <tr>
           <th style='text-align:center; ' colspan="6">
              Pavan Putra Sabji Bhandar <br>
              Customer Balance Report
           </th>
        </tr>
       
        <tr class="t1">
            <td colspan="6" class="l1"><b>Customer Name : </b></td>
           
        </tr>
  
        <tr >
        <td class="tt"><b> Sno</td>
        <td class="tt"colspan="2">Customer Name</td>
        >
        <td class="tt">Address </td>
        <td class="tt">Mobile No</td>
        <td class="tt" >Bal Amt</td>
    </tr>
    <?php $totalAmt = 0; ?>
    @foreach($parties['parties'] as $row)
    <?php 
      $partyBalance = CustomerLedgerBook::partyBalance($row->id, $row->openingBalance);
      $totalAmt += $partyBalance;
    ?>
      <tr >
        <td  class="tt">{{ $loop->index+1 }}</td>
        <td   class="tt"colspan="2">{{ $row->name }}</td>
        >
        <td   class="tt">{{ $row->address }} </td>
        <td   class="tt">{{ $row->mobile }}</td>
        <td    class="tt" >{{ $partyBalance }}</td>
    </tr>
    @endforeach
  
    <tr>
    <td class="l1" colspan="5"  style='text-align:right;'> <b>Total</b>
    </td>
    <td class="l1" colspan="1" style='text-align:right;'><b>{{ $totalAmt }}</b> </td>
    </tr>
    </table>
  <p style='text-align:center;'>|| Developed By +91-8871181890 || <br>Page 1/1 </p>

</body>
</html>