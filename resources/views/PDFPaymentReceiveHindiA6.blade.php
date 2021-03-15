<?php 
use \App\Http\Controllers\commonController;
use \App\Http\Controllers\CustomerLedgerBook;
use Illuminate\Http\Request;

 $openingBalance = commonController::getValueStatic('master_customer_suppliers','openingBalance','id',$data->partyId);

 $oldBalance = CustomerLedgerBook::OpeningBalance($data->partyId, $openingBalance);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@300&display=swap" rel="stylesheet">
    
 <style>
        * {
            font-family: 'Hind', sans-serif;
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
         /* margin:-20px; */
         }

         td.tt{
            border-top:solid;
         }

         th{
            font-size: 22px;         
         }
         td{
            font-size: 18px;
            padding:4px;
            line-height: 0.7;
         }
         table{
            border-collapse: separate;
            border-spacing: 0 11px;
         }

        .footer {
        position: fixed;
        left: 0;
        bottom: 40px;
        width: 100%;
        color: black;
        text-align: right;
        }
    </style>
    
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
        <br> मो. :</b> {{ $comp->mobile }},{{ $comp->mobile2 }}
        <br><br>
        <b>जमा रसीद</td>
           
        </tr>       
     
        <tr>
            <td colspan="3" class="tt"><b><br> तारीख :</td>
            <td colspan="3" class="tt"> {{ date('d-m-Y',strtotime($data->date)) }}</td>
        </tr>
        <tr>
            <td colspan="3"><b>ग्राहक का नाम :</td>
            <td colspan="3"> {{ commonController::getValueStatic('master_customer_suppliers','nameHindi','id',$data->partyId) }}</td>
        </tr>
        <tr>
            <td colspan="3"><b> पुराना बकाया राशि :</td>
            <td colspan="3">{{ number_format($oldBalance,2) }} </td>
        </tr>
        <tr>
            <td colspan="3"><b> जमा राशि : </td>
            <td colspan="3"> {{ number_format($data->amount,2) }}</td>
        </tr>
        <tr>
            <td colspan="3"><b> डिस्काउंट राशि : </td>
            <td colspan="3"> {{ number_format($data->discount,2) }}</td>
        </tr>
        <tr>
            <td  colspan="3"><b>वर्तमान बकाया राशि : </td>
            <td colspan="3"> {{ number_format($oldBalance-$data->amount,2) }}</td>
        </tr>
        
    </table>
    
    <div class="footer">
        <p>For {{ $comp->name }} </p>
    </div>
  
    </div>
</body>
</html>