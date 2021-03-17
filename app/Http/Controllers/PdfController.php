<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use PDF;
use DB;
use Session;
use Redirect;



class PdfController extends Controller
{

    public $companyId;
    private $fpdf;

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->companyId = Session::get('companyId');   
            return $next($request);
        });
    }

    public function invoice_num ($input, $pad_len = 7, $prefix = null) {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);
    
        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
    
        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }


    public function PDFCustomerSaleA4(Request $request, CustomerSupplierCarretLedger $cscl, CustomerLedgerBook $clb, commonController $cc)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        
        $companyId = $this->companyId;
        $master_company_settings = DB::table('master_company_settings')
        ->where('id', $companyId)
        ->first();
        
        $customer_sales = DB::select("SELECT * FROM `customer_sales` WHERE partyId = $request->partyId AND date = '$request->date'");
    
        $master_units = DB::table('master_units')
        ->where('isStockable', 'Yes')
        ->get();
    
        $master_customer_suppliers = DB::table('master_customer_suppliers')
        ->where('id', $request->partyId)
        ->first();
    
        $partType = '';
        if($master_customer_suppliers->customer == '1'){
            $partType = 'customerRate';
        }
    
        if($master_customer_suppliers->supplier == '1'){
            $partType = 'supplierRate';
        }

        $id = DB::table('customer_sales')->where(['date'=>$request->date, 'partyId'=>$_GET['partyId']])->value('id');
        $Y = date('y', strtotime($request->date));
        $day = date('D', strtotime($request->date));
        $invoiceNumber = $this->invoice_num(++$id, 6, "CS".$Y."/");
    
        $name = $cc->getValueStatic('master_customer_suppliers','name','id',$_GET['partyId']);
        $openingBalance = $cc->getValueStatic('master_customer_suppliers','openingBalance','id',$_GET['partyId']);
    
        $oldBalance = $clb->OpeningBalance($_GET['partyId'], $openingBalance);
        $CurCarretBal = $cscl->getPartyCarretBalanceWithZeroByDateStatic($request->partyId, $date);
    
        $customer_sale_row = '';
        $remark_row = '';
        $i=0;
        $j=0;
        $totalAmt=0;
        $extraAmt=0;
        foreach($customer_sales as $row)
        {
            ++$i; ++$j;
    
            $unitRate = 0;
            $unitRate = $cc->getStaticValueByMultiWhere('custom_unit_rates','rate',['partyId'=>$row->partyId,'unitId'=>$row->unitId]);
            if($unitRate == '' || $unitRate == null){
                $unitRate = $cc->getValueStatic('master_units',$partType,'id',$row->unitId);      
            }                                                    
            $extraAmt += $row->qty * $unitRate;
    
            $totalAmt += $extraAmt+$row->amount; 
            $item_name = $cc->getValueStatic('master_items','name','id',$row->itemId);
            $unit_name = $cc->getValueStatic('master_units','name','id',$row->unitId);
            $customer_sale_row .= '
            <tr style="text-align:center;">
            <td>'.$i.'</td>
            <td>
               '.$item_name.' &nbsp;
               '.$row->qty.'
               '.$unit_name.'
            </td>
            <td>'.$row->weight.'</td>
            <td>'.$row->rate.'</td>
            <td>'.$row->amount.'</td>
            </tr>
            ';
    
            if($row->remark != ''){
                $remark_row .= '
                '.$j.'. '.$row->remark.'<br>
                ';
            }
            
        }            
    
        if($oldBalance>=0){
            $totalBalance = $oldBalance+$totalAmt;
        }else{
            $oldBalance = abs($oldBalance);
            $totalBalance = $oldBalance-$totalAmt;
        }
    
        $remarkHead = '';
        if($remark_row != ''){
            $remarkHead = "<span style='font-family:ind_hi_1_001;font-weight: bold;'>रिमार्क:</span><br>";
        }

        $html= "<html><head><meta charset='utf-8'></head><div style='width:100%;height:10%;background-color:white;border: #000000 1px solid' ><table width='100%'><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4>".$master_company_settings->name."</h4></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4>".$master_company_settings->address."</h4></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4>Mo. : ".$master_company_settings->mobile.",".$master_company_settings->mobile2."</h4></td></tr><tr><td width='280px' style='text-align:center;font-family:ind_hi_1_001;'><h4> :- Customer Bill:-</h4></td></tr></table></div><div style='width:100%;height:79%;background-color:white;border: #000000 1px solid' ><table width='100%'><tr ><td width='50%' style='text-align:left;font-family:ind_hi_1_001;font-size:17px;'><h5> Mr. :".$name."</h5></td><td width='50%' style='text-align:right;font-family:ind_hi_1_001;'><h6><p>Vouchar No : ".$invoiceNumber."<p>Bill Date : <NOBR>".date('d-m-Y', strtotime($_GET['date']))."</NOBR> (".$day.")</h6></td></tr></table> <br/><table width='100%' cellpadding='3' cellspacing='-1'><tr style='border-bottom: #000000 1px solid; background:#333333;'><td width='5%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>No.</h5></td><td width='30%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>Particulars</h5></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>Weight</h5></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>Rate</h5></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;text-align:center;color:#FFFFFF'><h5> Amount</h5></td></tr> ".$customer_sale_row."<tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-top: #000000 1px solid;'><h5> Extra Amount:-</h5></td><td style='text-align:right;border-top: #000000 1px solid;font-weight:bold'>".$extraAmt."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom:#000000 1px solid;'><h5>Total Amount :-</h5></td><td style='text-align:right;border-bottom:#000000 1px solid;font-weight:bold'>".$totalAmt."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom: #000000 1px solid;'><h5> Old Bal. :-</h5></td><td style='text-align:right;border-bottom: #000000 1px solid;font-weight:bold'>".$oldBalance."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom:#000000 1px solid; color:#000000;font-weight:bold'><h5>Total Bal. :-</h5></td><td style='text-align:right;border-bottom:#000000 1px solid;color:#000000;font-weight:bold'>".$totalBalance."</td></tr><tr><td colspan='4'> &nbsp;</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;'><h5>Bal. Carret : ".$CurCarretBal."</h5></td></tr></table> $remarkHead $remark_row</div>";
        $content = urlencode(base64_encode($html));
        $size='A4';            
        return Redirect::to('http://rashmihomecare.com/mpdf/mPDF.php?content='.$content.'&size='.$size);
    }


    public function PDFCustomerSaleA5(Request $request, CustomerSupplierCarretLedger $cscl, CustomerLedgerBook $clb, commonController $cc)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        
        $companyId = $this->companyId;
        $master_company_settings = DB::table('master_company_settings')
        ->where('id', $companyId)
        ->first();
        
        $customer_sales = DB::select("SELECT * FROM `customer_sales` WHERE partyId = $request->partyId AND date = '$request->date'");
    
        $master_units = DB::table('master_units')
        ->where('isStockable', 'Yes')
        ->get();
    
        $master_customer_suppliers = DB::table('master_customer_suppliers')
        ->where('id', $request->partyId)
        ->first();
    
        $partType = '';
        if($master_customer_suppliers->customer == '1'){
            $partType = 'customerRate';
        }
    
        if($master_customer_suppliers->supplier == '1'){
            $partType = 'supplierRate';
        }
        
        $id = DB::table('customer_sales')->where(['date'=>$request->date, 'partyId'=>$_GET['partyId']])->value('id');
        $Y = date('y', strtotime($request->date));
        $day = date('D', strtotime($request->date));
        $invoiceNumber = $this->invoice_num(++$id, 6, "CS".$Y."/");

        $name = $cc->getValueStatic('master_customer_suppliers','name','id',$_GET['partyId']);
        $openingBalance = $cc->getValueStatic('master_customer_suppliers','openingBalance','id',$_GET['partyId']);
    
        $oldBalance = $clb->OpeningBalance($_GET['partyId'], $openingBalance);
        $CurCarretBal = $cscl->getPartyCarretBalanceWithZeroByDateStatic($request->partyId, $date);
    
        $customer_sale_row = '';
        $remark_row = '';
        $i=0;
        $j=0;
        $totalAmt=0;
        $extraAmt=0;
        foreach($customer_sales as $row)
        {
            ++$i; ++$j;
    
            $unitRate = 0;
            $unitRate = $cc->getStaticValueByMultiWhere('custom_unit_rates','rate',['partyId'=>$row->partyId,'unitId'=>$row->unitId]);
            if($unitRate == '' || $unitRate == null){
                $unitRate = $cc->getValueStatic('master_units',$partType,'id',$row->unitId);      
            }                                                    
            $extraAmt += $row->qty * $unitRate;
    
            $totalAmt += $extraAmt+$row->amount; 
            $item_name = $cc->getValueStatic('master_items','name','id',$row->itemId);
            $unit_name = $cc->getValueStatic('master_units','name','id',$row->unitId);
            $customer_sale_row .= '
            <tr style="text-align:center;">
            <td>'.$i.'</td>
            <td>
               '.$item_name.' &nbsp;
               '.$row->qty.'
               '.$unit_name.'
            </td>
            <td>'.$row->weight.'</td>
            <td>'.$row->rate.'</td>
            <td>'.$row->amount.'</td>
            </tr>
            ';
    
            if($row->remark != ''){
                $remark_row .= '
                '.$j.'. '.$row->remark.'<br>
                ';
            }
            
        }            
    
        if($oldBalance>=0){
            $totalBalance = $oldBalance+$totalAmt;
        }else{
            $oldBalance = abs($oldBalance);
            $totalBalance = $oldBalance-$totalAmt;
        }
    
        $remarkHead = '';
        if($remark_row != ''){
            $remarkHead = "<span style='font-family:ind_hi_1_001;font-weight: bold;'>रिमार्क:</span><br>";
        }

        $html= "<html><head><meta charset='utf-8'></head><div style='width:100%;height:10%;background-color:white;border: #000000 1px solid' ><table width='100%'><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4>".$master_company_settings->name."</h4></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4>".$master_company_settings->address."</h4></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4>Mo. : ".$master_company_settings->mobile.",".$master_company_settings->mobile2."</h4></td></tr><tr><td width='280px' style='text-align:center;font-family:ind_hi_1_001;'><h4> :- Customer Bill:-</h4></td></tr></table></div><div style='width:100%;height:79%;background-color:white;border: #000000 1px solid' ><table width='100%'><tr ><td width='50%' style='text-align:left;font-family:ind_hi_1_001;font-size:17px;'><h5> Mr. :".$name."</h5></td><td width='50%' style='text-align:right;font-family:ind_hi_1_001;'><h6><p>Vouchar No : ".$invoiceNumber."<p>Bill Date : <NOBR>".date('d-m-Y', strtotime($_GET['date']))."</NOBR> (".$day.")</h6></td></tr></table> <br/><table width='100%' cellpadding='3' cellspacing='-1'><tr style='border-bottom: #000000 1px solid; background:#333333;'><td width='5%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>No.</h5></td><td width='30%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>Particulars</h5></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>Weight</h5></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>Rate</h5></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;text-align:center;color:#FFFFFF'><h5> Amount</h5></td></tr> ".$customer_sale_row."<tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-top: #000000 1px solid;'><h5> Extra Amount:-</h5></td><td style='text-align:right;border-top: #000000 1px solid;font-weight:bold'>".$extraAmt."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom:#000000 1px solid;'><h5>Total Amount :-</h5></td><td style='text-align:right;border-bottom:#000000 1px solid;font-weight:bold'>".$totalAmt."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom: #000000 1px solid;'><h5> Old Bal. :-</h5></td><td style='text-align:right;border-bottom: #000000 1px solid;font-weight:bold'>".$oldBalance."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom:#000000 1px solid; color:#000000;font-weight:bold'><h5>Total Bal. :-</h5></td><td style='text-align:right;border-bottom:#000000 1px solid;color:#000000;font-weight:bold'>".$totalBalance."</td></tr><tr><td colspan='4'> &nbsp;</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;'><h5>Bal. Carret : ".$CurCarretBal."</h5></td></tr></table> $remarkHead $remark_row</div>";
        $content = urlencode(base64_encode($html));
        $size='A5';            
        return Redirect::to('http://rashmihomecare.com/mpdf/mPDF.php?content='.$content.'&size='.$size);
    }


    public function PDFCustomerSaleA6(Request $request, CustomerSupplierCarretLedger $cscl, CustomerLedgerBook $clb, commonController $cc)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        
        $companyId = $this->companyId;
        $master_company_settings = DB::table('master_company_settings')
        ->where('id', $companyId)
        ->first();
        
        $customer_sales = DB::select("SELECT * FROM `customer_sales` WHERE partyId = $request->partyId AND date = '$request->date'");
    
        $master_units = DB::table('master_units')
        ->where('isStockable', 'Yes')
        ->get();
    
        $master_customer_suppliers = DB::table('master_customer_suppliers')
        ->where('id', $request->partyId)
        ->first();
    
        $partType = '';
        if($master_customer_suppliers->customer == '1'){
            $partType = 'customerRate';
        }
    
        if($master_customer_suppliers->supplier == '1'){
            $partType = 'supplierRate';
        }

        $id = DB::table('customer_sales')->where(['date'=>$request->date, 'partyId'=>$_GET['partyId']])->value('id');
        $Y = date('y', strtotime($request->date));
        $day = date('D', strtotime($request->date));
        $invoiceNumber = $this->invoice_num(++$id, 6, "CS".$Y."/");
    
        $name = $cc->getValueStatic('master_customer_suppliers','name','id',$_GET['partyId']);
        $openingBalance = $cc->getValueStatic('master_customer_suppliers','openingBalance','id',$_GET['partyId']);
    
        $oldBalance = $clb->OpeningBalance($_GET['partyId'], $openingBalance);
        $CurCarretBal = $cscl->getPartyCarretBalanceWithZeroByDateStatic($request->partyId, $date);
    
        $customer_sale_row = '';
        $remark_row = '';
        $i=0;
        $j=0;
        $totalAmt=0;
        $extraAmt=0;
        foreach($customer_sales as $row)
        {
            ++$i; ++$j;
    
            $unitRate = 0;
            $unitRate = $cc->getStaticValueByMultiWhere('custom_unit_rates','rate',['partyId'=>$row->partyId,'unitId'=>$row->unitId]);
            if($unitRate == '' || $unitRate == null){
                $unitRate = $cc->getValueStatic('master_units',$partType,'id',$row->unitId);      
            }                                                    
            $extraAmt += $row->qty * $unitRate;
    
            $totalAmt += $extraAmt+$row->amount; 
            $item_name = $cc->getValueStatic('master_items','name','id',$row->itemId);
            $unit_name = $cc->getValueStatic('master_units','name','id',$row->unitId);
            $customer_sale_row .= '
            <tr style="text-align:center;">
            <td>'.$i.'</td>
            <td>
               '.$item_name.' &nbsp;
               '.$row->qty.'
               '.$unit_name.'
            </td>
            <td>'.$row->weight.'</td>
            <td>'.$row->rate.'</td>
            <td>'.$row->amount.'</td>
            </tr>
            ';
    
            if($row->remark != ''){
                $remark_row .= '
                '.$j.'. '.$row->remark.'<br>
                ';
            }
            
        }            
    
        if($oldBalance>=0){
            $totalBalance = $oldBalance+$totalAmt;
        }else{
            $oldBalance = abs($oldBalance);
            $totalBalance = $oldBalance-$totalAmt;
        }
    
        $remarkHead = '';
        if($remark_row != ''){
            $remarkHead = "<span style='font-family:ind_hi_1_001;font-weight: bold;'>रिमार्क:</span><br>";
        }

        $html= "<html><head><meta charset='utf-8'></head><div style='width:100%;height:10%;background-color:white;border: #000000 1px solid' ><table width='100%'><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4>".$master_company_settings->name."</h4></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4>".$master_company_settings->address."</h4></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4>Mo. : ".$master_company_settings->mobile.",".$master_company_settings->mobile2."</h4></td></tr><tr><td width='280px' style='text-align:center;font-family:ind_hi_1_001;'><h4> :- Customer Bill:-</h4></td></tr></table></div><div style='width:100%;height:79%;background-color:white;border: #000000 1px solid' ><table width='100%'><tr ><td width='50%' style='text-align:left;font-family:ind_hi_1_001;font-size:17px;'><h5> Mr. :".$name."</h5></td><td width='50%' style='text-align:right;font-family:ind_hi_1_001;'><h6><p>Vouchar No : ".$invoiceNumber."<p>Bill Date : <NOBR>".date('d-m-Y', strtotime($_GET['date']))."</NOBR> (".$day.")</h6></td></tr></table> <br/><table width='100%' cellpadding='3' cellspacing='-1'><tr style='border-bottom: #000000 1px solid; background:#333333;'><td width='5%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>No.</h5></td><td width='30%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>Particulars</h5></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>Weight</h5></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h5>Rate</h5></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;text-align:center;color:#FFFFFF'><h5> Amount</h5></td></tr> ".$customer_sale_row."<tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-top: #000000 1px solid;'><h5> Extra Amount:-</h5></td><td style='text-align:right;border-top: #000000 1px solid;font-weight:bold'>".$extraAmt."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom:#000000 1px solid;'><h5>Total Amount :-</h5></td><td style='text-align:right;border-bottom:#000000 1px solid;font-weight:bold'>".$totalAmt."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom: #000000 1px solid;'><h5> Old Bal. :-</h5></td><td style='text-align:right;border-bottom: #000000 1px solid;font-weight:bold'>".$oldBalance."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom:#000000 1px solid; color:#000000;font-weight:bold'><h5>Total Bal. :-</h5></td><td style='text-align:right;border-bottom:#000000 1px solid;color:#000000;font-weight:bold'>".$totalBalance."</td></tr><tr><td colspan='4'> &nbsp;</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;'><h5>Bal. Carret : ".$CurCarretBal."</h5></td></tr></table> $remarkHead $remark_row</div>";
        $content = urlencode(base64_encode($html));
        $size='A6';            
        return Redirect::to('http://rashmihomecare.com/mpdf/mPDF.php?content='.$content.'&size='.$size);

    }


    public function PDFCustomerSaleHiA4(Request $request, CustomerSupplierCarretLedger $cscl, CustomerLedgerBook $clb, commonController $cc)
    {  
        
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    
    $companyId = $this->companyId;
    $master_company_settings = DB::table('master_company_settings')
    ->where('id', $companyId)
    ->first();
    
    $customer_sales = DB::select("SELECT * FROM `customer_sales` WHERE partyId = $request->partyId AND date = '$request->date'");

    $master_units = DB::table('master_units')
    ->where('isStockable', 'Yes')
    ->get();

    $master_customer_suppliers = DB::table('master_customer_suppliers')
    ->where('id', $request->partyId)
    ->first();

    $partType = '';
    if($master_customer_suppliers->customer == '1'){
        $partType = 'customerRate';
    }

    if($master_customer_suppliers->supplier == '1'){
        $partType = 'supplierRate';
    }

        $id = DB::table('customer_sales')->where(['date'=>$request->date, 'partyId'=>$_GET['partyId']])->value('id');
        $Y = date('y', strtotime($request->date));
        $day = $cc->EnDayToHiDay(date('D', strtotime($request->date)));
        $invoiceNumber = $this->invoice_num(++$id, 6, "CS".$Y."/");

    $nameHindi = $cc->getValueStatic('master_customer_suppliers','nameHindi','id',$_GET['partyId']);
    $openingBalance = $cc->getValueStatic('master_customer_suppliers','openingBalance','id',$_GET['partyId']);

    $oldBalance = $clb->OpeningBalance($_GET['partyId'], $openingBalance);
    $CurCarretBal = $cscl->getPartyCarretBalanceWithZeroByDateStatic($request->partyId, $date);

    $customer_sale_row = '';
    $remark_row = '';
    $i=0;
    $j=0;
    $totalAmt=0;
    $extraAmt=0;
    foreach($customer_sales as $row)
    {
        ++$i; ++$j;

        $unitRate = 0;
        $unitRate = $cc->getStaticValueByMultiWhere('custom_unit_rates','rate',['partyId'=>$row->partyId,'unitId'=>$row->unitId]);
        if($unitRate == '' || $unitRate == null){
            $unitRate = $cc->getValueStatic('master_units',$partType,'id',$row->unitId);      
        }                                                    
        $extraAmt += $row->qty * $unitRate;

        $totalAmt += $extraAmt+$row->amount; 
        $item_name = $cc->getValueStatic('master_items','nameHindi','id',$row->itemId);
        $unit_name = $cc->getValueStatic('master_units','nameHindi','id',$row->unitId);
        $customer_sale_row .= '
        <tr style="text-align:center;">
        <td>'.$i.'</td>
        <td style="font-family:ind_hi_1_001;">
           '.$item_name.' &nbsp;
           '.$row->qty.'
           '.$unit_name.'
        </td>
        <td>'.$row->weight.'</td>
        <td>'.$row->rate.'</td>
        <td>'.$row->remark.'</td>
        <td>'.$row->amount.'</td>
        </tr>
        ';

        if($row->remark != ''){
            $remark_row .= '
            '.$j.'. '.$row->remark.'<br>
            ';
        }

    }            

    if($oldBalance>=0){
        $totalBalance = $oldBalance+$totalAmt;
    }else{
        $oldBalance = abs($oldBalance);
        $totalBalance = $oldBalance-$totalAmt;
    }

    $remarkHead = '';
    if($remark_row != ''){
        $remarkHead = "<span style='font-family:ind_hi_1_001;font-weight: bold;'>रिमार्क:</span><br>";
    }

    $html = "<html><head><meta charset='utf-8'></head><div style='width:100%;height:10%;background-color:white;border:#000 1px solid'><table width='100%'><tr><td style='text-align:center;font-family:ind_hi_1_001'><h4>".$master_company_settings->nameHindi."</h4></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001'> <h5>".$master_company_settings->addressHindi."</h5></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001'><h5>मो. : ".$master_company_settings->mobile.",".$master_company_settings->mobile2."</h5></td></tr><tr><td width='280px' style='text-align:center;font-family:ind_hi_1_001'><h4> :- ग्राहक बिल :- </h4></td></tr></table></div><div style='width:100%;height:89%;background-color:white;border:#000 1px solid'><table width='100%'><tr><td width='50%' style='text-align:left;font-family:ind_hi_1_001;font-size:18px'><h5> श्री : ".$nameHindi."</h5></td> <td width='50%' style='text-align:right;font-family:ind_hi_1_001'><h6><p><h4> रशीद क्र. : ".$invoiceNumber." </h4></p> बिल की तारीख : <NOBR>".date('d-m-Y', strtotime($_GET['date']))."</NOBR>(".$day.")</h6></td></tr> </table><br/><table width='100%' cellpadding='3' cellspacing='-1'><tr style='border-bottom:#000 1px solid;background:#333'><td width='5%' style='border-bottom:#000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4> क्र. </h4></td><td width='30%' style='border-bottom:#000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'> <h4>सब्जी का नाम </h4></td><td width='15%' style='border-bottom:#000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4>वजन</h4></td><td width='15%' style='border-bottom:#000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4>दर</h4></td><td width='20%' style='border-bottom:#000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4>रिमार्क</h4></td><td width='15%' style='border-bottom:#000 1px solid;font-family:ind_hi_1_001;text-align:center;color:#FFFFFF'><h4> रकम </h4></td> </tr> ".$customer_sale_row." <tr> <td colspan='5' style='font-family:ind_hi_1_001;text-align:right;border-top:#000 1px solid'><h5> अतिरिक्त रकम :-</h5></td> <td style='text-align:right;border-top:#000 1px solid;font-weight:bold'>".$extraAmt."</td> </tr> <tr> <td colspan='5' style='font-family:ind_hi_1_001;text-align:right;border-bottom:#000 1px solid'> <h5>कुल रकम :-</h5></td> <td style='text-align:right;border-bottom:#000 1px solid;font-weight:bold'>".$totalAmt."</td> </tr> <tr> <td colspan='5' style='font-family:ind_hi_1_001;text-align:right;border-bottom:#000 1px solid'><h5> पिछला बकाया :-</h5></td> <td style='text-align:right;border-bottom:#000 1px solid;font-weight:bold'>".$oldBalance."</td> </tr> <tr> <td colspan='5' style='font-family:ind_hi_1_001;text-align:right;border-bottom:#000 1px solid;background:#ccc;color:#000'><h5>कुल बकाया :-</h5></td> <td style='text-align:right;border-bottom:#000 1px solid;background:#ccc;color:#000;font-weight:bold'>".$totalBalance."</td> </tr> <tr> <td colspan='5' style='font-family:ind_hi_1_001'><br><h5>बकाया केरेट : ".$CurCarretBal."</h5></td> </tr> </table> $remarkHead $remark_row </div>";

    $content = urlencode(base64_encode($html));

    $size='A4';            
    return Redirect::to('http://rashmihomecare.com/mpdf/mPDF.php?content='.$content.'&size='.$size);

    }


    public function PDFCustomerSaleHiA5(Request $request, CustomerSupplierCarretLedger $cscl, CustomerLedgerBook $clb, commonController $cc)
    {
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    
    $companyId = $this->companyId;
    $master_company_settings = DB::table('master_company_settings')
    ->where('id', $companyId)
    ->first();
    
    $customer_sales = DB::select("SELECT * FROM `customer_sales` WHERE partyId = $request->partyId AND date = '$request->date'");

    $master_units = DB::table('master_units')
    ->where('isStockable', 'Yes')
    ->get();

    $master_customer_suppliers = DB::table('master_customer_suppliers')
    ->where('id', $request->partyId)
    ->first();

    $partType = '';
    if($master_customer_suppliers->customer == '1'){
        $partType = 'customerRate';
    }

    if($master_customer_suppliers->supplier == '1'){
        $partType = 'supplierRate';
    }

        $id = DB::table('customer_sales')->where(['date'=>$request->date, 'partyId'=>$_GET['partyId']])->value('id');
        $Y = date('y', strtotime($request->date));
        $day = $cc->EnDayToHiDay(date('D', strtotime($request->date)));
        $invoiceNumber = $this->invoice_num(++$id, 6, "CS".$Y."/");

    $nameHindi = $cc->getValueStatic('master_customer_suppliers','nameHindi','id',$_GET['partyId']);
    $openingBalance = $cc->getValueStatic('master_customer_suppliers','openingBalance','id',$_GET['partyId']);

    $oldBalance = $clb->OpeningBalance($_GET['partyId'], $openingBalance);
    $CurCarretBal = $cscl->getPartyCarretBalanceWithZeroByDateStatic($request->partyId, $date);

    $customer_sale_row = '';
    $remark_row = '';
    $i=0;
    $j=0;
    $totalAmt=0;
    $extraAmt=0;
    foreach($customer_sales as $row)
    {
        ++$i; ++$j;

        $unitRate = 0;
        $unitRate = $cc->getStaticValueByMultiWhere('custom_unit_rates','rate',['partyId'=>$row->partyId,'unitId'=>$row->unitId]);
        if($unitRate == '' || $unitRate == null){
            $unitRate = $cc->getValueStatic('master_units',$partType,'id',$row->unitId);      
        }                                                    
        $extraAmt += $row->qty * $unitRate;

        $totalAmt += $extraAmt+$row->amount; 
        $item_name = $cc->getValueStatic('master_items','nameHindi','id',$row->itemId);
        $unit_name = $cc->getValueStatic('master_units','name','id',$row->unitId);
        $customer_sale_row .= '
        <tr style="text-align:center;">
        <td>'.$i.'</td>
        <td style="font-family:ind_hi_1_001;">
           '.$item_name.' &nbsp;
           '.$row->qty.'
           '.$unit_name.'
        </td>
        <td>'.$row->weight.'</td>
        <td>'.$row->rate.'</td>
        <td>'.$row->amount.'</td>
        </tr>
        ';

        if($row->remark != ''){
            $remark_row .= '
            '.$j.'. '.$row->remark.'<br>
            ';
        }
    }            

    if($oldBalance>=0){
        $totalBalance = $oldBalance+$totalAmt;
    }else{
        $oldBalance = abs($oldBalance);
        $totalBalance = $oldBalance-$totalAmt;
    }

    $remarkHead = '';
    if($remark_row != ''){
        $remarkHead = "<span style='font-family:ind_hi_1_001;font-weight: bold;'>रिमार्क:</span><br>";
    }

        $html= "<html><head><meta charset='utf-8'></head><div style='width:100%;height:10%;background-color:white;border: #000000 1px solid' ><table width='100%'><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4>".$master_company_settings->nameHindi."</h4></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h5>".$master_company_settings->addressHindi."</h5></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h5> मो. : ".$master_company_settings->mobile.",".$master_company_settings->mobile2."</h5></td></tr><tr><td width='280px' style='text-align:center;font-family:ind_hi_1_001;'><h4> :- ग्राहक बिल :-</h4></td></tr></table></div><div style='width:100%;height:79%;background-color:white;border: #000000 1px solid' ><table width='100%'><tr ><td width='50%' style='text-align:left;font-family:ind_hi_1_001;font-size:18px;'><h5> श्री : ".$nameHindi."</h5></td><td width='50%' style='text-align:right;font-family:ind_hi_1_001;'><h6><p><h4> रशीद क्र. : ".$invoiceNumber."</h4></p> बिल की तारीख : <NOBR>".date('d-m-Y', strtotime($_GET['date']))."</NOBR> (".$day.")</h6></td></tr></table> <br/><table width='100%' cellpadding='3' cellspacing='-1'><tr style='border-bottom: #000000 1px solid; background:#333333;'><td width='5%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4> क्र.</h4></td><td width='30%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4>सब्जी का नाम</h4></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4>वजन</h4></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4>दर</h4></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;text-align:center;color:#FFFFFF'><h4> रकम</h4></td></tr> ".$customer_sale_row."<tr><td colspan='5' style='font-family:ind_hi_1_001;text-align:right;border-top: #000000 1px solid;'><h5> अतिरिक्त रकम :-</h5></td><td style='text-align:right;border-top: #000000 1px solid;font-weight:bold'>".$extraAmt."</td></tr><tr><td colspan='5' style='font-family:ind_hi_1_001;text-align:right;border-bottom: #000000 1px solid;'><h5>कुल रकम :-</h5></td><td style='text-align:right;border-bottom: #000000 1px solid;font-weight:bold'>".$totalAmt."</td></tr><tr><td colspan='5' style='font-family:ind_hi_1_001;text-align:right;border-bottom: #000000 1px solid;'><h5> पिछला बकाया :-</h5></td><td style='text-align:right;border-bottom: #000000 1px solid;font-weight:bold'>".$oldBalance."</td></tr><tr><td colspan='5' style='font-family:ind_hi_1_001;text-align:right;border-bottom: #000000 1px solid;background:#CCCCCC; color:#000000;'><h5>कुल बकाया :-</h5></td><td style='text-align:right;border-bottom: #000000 1px solid;background:#CCCCCC; color:#000000;font-weight:bold'>".$totalBalance."</td></tr><tr><td colspan='5' style='font-family:ind_hi_1_001;'><br><h5>बकाया केरेट : ".$CurCarretBal."</h5></td></tr></table>$remarkHead $remark_row</div>";

        $content = urlencode(base64_encode($html));
        $size='A5';            
        return Redirect::to('http://rashmihomecare.com/mpdf/mPDF.php?content='.$content.'&size='.$size);


    }


    public function PDFCustomerSaleHiA6(Request $request, CustomerSupplierCarretLedger $cscl, CustomerLedgerBook $clb, commonController $cc)
    {
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    
    $companyId = $this->companyId;
    $master_company_settings = DB::table('master_company_settings')
    ->where('id', $companyId)
    ->first();
    
    $customer_sales = DB::select("SELECT * FROM `customer_sales` WHERE partyId = $request->partyId AND date = '$request->date'");

    $master_units = DB::table('master_units')
    ->where('isStockable', 'Yes')
    ->get();

    $master_customer_suppliers = DB::table('master_customer_suppliers')
    ->where('id', $request->partyId)
    ->first();

    $partType = '';
    if($master_customer_suppliers->customer == '1'){
        $partType = 'customerRate';
    }

    if($master_customer_suppliers->supplier == '1'){
        $partType = 'supplierRate';
    }

    $id = DB::table('customer_sales')->where(['date'=>$request->date, 'partyId'=>$_GET['partyId']])->value('id');
    $Y = date('y', strtotime($request->date));
    $day = $cc->EnDayToHiDay(date('D', strtotime($request->date)));
    $invoiceNumber = $this->invoice_num(++$id, 6, "CS".$Y."/");

    $nameHindi = $cc->getValueStatic('master_customer_suppliers','nameHindi','id',$_GET['partyId']);
    $openingBalance = $cc->getValueStatic('master_customer_suppliers','openingBalance','id',$_GET['partyId']);
    $oldBalance = $clb->OpeningBalance($_GET['partyId'], $openingBalance);
    $CurCarretBal = $cscl->getPartyCarretBalanceWithZeroByDateStatic($request->partyId, $date);

    $customer_sale_row = '';
    $remark_row = '';
    $i=0;
    $j=0;
    $totalAmt=0;
    $extraAmt=0;
    foreach($customer_sales as $row)
    {
        ++$i; ++$j;

        $unitRate = 0;
        $unitRate = $cc->getStaticValueByMultiWhere('custom_unit_rates','rate',['partyId'=>$row->partyId,'unitId'=>$row->unitId]);
        if($unitRate == '' || $unitRate == null){
            $unitRate = $cc->getValueStatic('master_units',$partType,'id',$row->unitId);      
        }                                                    
        $extraAmt += $row->qty * $unitRate;

        $totalAmt += $extraAmt+$row->amount; 
        $item_name = $cc->getValueStatic('master_items','nameHindi','id',$row->itemId);
        $unit_name = $cc->getValueStatic('master_units','name','id',$row->unitId);
        $customer_sale_row .= '
        <tr style="text-align:center;">
        <td>'.$i.'</td>
        <td style="font-family:ind_hi_1_001;">
           '.$item_name.' &nbsp;
           '.$row->qty.'
           '.$unit_name.'
        </td>
        <td>'.$row->weight.'</td>
        <td>'.$row->rate.'</td>
        <td>'.$row->amount.'</td>
        </tr>
        ';

        if($row->remark != ''){
            $remark_row .= '
            '.$j.'. '.$row->remark.'<br>
            ';
        }
        
    }            

    if($oldBalance>=0){
        $totalBalance = $oldBalance+$totalAmt;
    }else{
        $oldBalance = abs($oldBalance);
        $totalBalance = $oldBalance-$totalAmt;
    }

    $remarkHead = '';
    if($remark_row != ''){
        $remarkHead = "<span style='font-family:ind_hi_1_001;font-weight: bold;'>रिमार्क:</span><br>";
    }
    

        $html= "<html><head><meta charset='utf-8'></head><div style='width:100%;height:10%;background-color:white;border: #000000 1px solid' ><table width='100%'><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h4> ".$master_company_settings->nameHindi."</h4></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h5> ".$master_company_settings->addressHindi."</h5></td></tr><tr><td style='text-align:center;font-family:ind_hi_1_001;'><h5> मो. : ".$master_company_settings->mobile.",".$master_company_settings->mobile2."</h5></td></tr><tr><td width='280px' style='text-align:center;font-family:ind_hi_1_001;'><h4> :- ग्राहक बिल :-</h4></td></tr></table></div><div style='width:100%;height:79%;background-color:white;border: #000000 1px solid' ><table width='100%'><tr ><td width='50%' style='text-align:left;font-family:ind_hi_1_001;font-size:18px;'><h5> श्री : ".$nameHindi."</h5></td><td width='50%' style='text-align:right;font-family:ind_hi_1_001;'><h6><p><h4> रशीद क्र. : ".$invoiceNumber."</h4></p> बिल की तारीख : <NOBR>".date('d-m-Y', strtotime($_GET['date']))."</NOBR> (".$day.")</h6></td></tr></table> <br/><table width='100%' cellpadding='3' cellspacing='-1'><tr style='border-bottom: #000000 1px solid; background:#333333;'><td width='5%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4> क्र.</h4></td><td width='40%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4>सब्जी का नाम</h4></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4>वजन</h4></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;color:#FFFFFF'><h4>दर</h4></td><td width='15%' style='border-bottom: #000000 1px solid;font-family:ind_hi_1_001;text-align:center;color:#FFFFFF'><h4> रकम</h4></td></tr> ".$customer_sale_row."<tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-top: #000000 1px solid;'><h5> अतिरिक्त रकम :-</h5></td><td style='text-align:right;border-top: #000000 1px solid;font-weight:bold'>".$extraAmt."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom: #000000 1px solid;'><h5>कुल रकम :-</h5></td><td style='text-align:right;border-bottom: #000000 1px solid;font-weight:bold'>".$totalAmt."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom: #000000 1px solid;'><h5> पिछला बकाया :-</h5></td><td style='text-align:right;border-bottom: #000000 1px solid;font-weight:bold'>".$oldBalance."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;text-align:right;border-bottom: #000000 1px solid;background:#CCCCCC; color:#000000;'><h5>कुल बकाया :-</h5></td><td style='text-align:right;border-bottom: #000000 1px solid;background:#CCCCCC; color:#000000;font-weight:bold'>".$totalBalance."</td></tr><tr><td colspan='4' style='font-family:ind_hi_1_001;'><br><h5>बकाया केरेट : ".$CurCarretBal."</h5></td></tr></table> $remarkHead $remark_row</div>";
        $content = urlencode(base64_encode($html));
        $size='A6';            
        return Redirect::away('http://rashmihomecare.com/mpdf/mPDF.php?content='.$content.'&size='.$size);

    }



    public function hcsa4()
    {
    $pdf=PDF::loadView('hcsa4')->setPaper('A4');
    return $pdf->stream();
    }

    public function cpa6()
    {
    $pdf=PDF::loadView('cpa6')->setPaper('A6');
    return $pdf->stream();
    }

    public function purchase_report_A4()
    {
    $pdf=PDF::loadView('purchase_report_A4')->setPaper('A4');
    return $pdf->stream();
    }

    public function purchase_report_A5()
    {
    $pdf=PDF::loadView('purchase_report_A5')->setPaper('A5');
    return $pdf->stream();
    }



    public function loading_entryA6()
    {
    $pdf=PDF::loadView('loading_entryA6')->setPaper('A6');
    return $pdf->stream();
    }

    public function supplier_payment()
    {
    $customPaper = array(0,0,250,2500);
    $pdf=PDF::loadView('supplier_payment')->setPaper($customPaper);
    return $pdf->stream();
    }

    public function customer_ledgerA4()
    {
    $pdf=PDF::loadView('customer_ledgerA4')->setPaper('A4');
    return $pdf->stream();
    }

    public function item_wise_sale_details()
    {
    $pdf=PDF::loadView('item_wise_sale_details')->setPaper('A4');
    return $pdf->stream();
    }

    public function item_wise_sale_details_FARMER()
    {
    $pdf=PDF::loadView('item_wise_sale_details_FARMER')->setPaper('A4');
    return $pdf->stream();
    }

    public function customer_details_ledger()
    {
    $pdf=PDF::loadView('customer_details_ledger')->setPaper('A4');
    return $pdf->stream();
    }

    public function PDFPartyBalanceReportA4(Request $request)
    {
    $parties = $this->PDFpartyBalanceReport($request->partyId);
    view()->share(['parties'=>$parties]);
    $pdf=PDF::loadView('PDFPartyBalanceReportA4', ['parties'=>$parties])->setPaper('A4');
    return $pdf->stream();    
    }


    public function PDFPartyBalanceReportA5()
    {
        $parties = $this->PDFpartyBalanceReport($request->partyId);
        view()->share(['parties'=>$parties]);
        $pdf=PDF::loadView('PDFPartyBalanceReportA5', ['parties'=>$parties])->setPaper('A5');
        return $pdf->stream();
    }


    public function PDFpartyBalanceReport($partyId=0)
    {
        $companyId = $this->companyId;        
        $condition = "companyId = ".$companyId;
        if ($partyId==0) {
            $condition .= " AND status = 'Active'";
            $status = true;
        }else{
            $condition .= " AND id = ".$partyId." AND status = 'Active'";
        }

        $master_units = DB::table('master_units')
        ->where('isStockable', 'Yes')
        ->get();
        $parties = DB::select("SELECT * FROM `master_customer_suppliers` WHERE $condition ORDER BY `id` DESC");        
        return ['parties'=>$parties, 'master_units'=>$master_units];
    }


    //PDF Report By Tarachand Patel

    public function PdfPaymentA6Hindi(Request $request, CustomerSupplierCarretLedger $cscl, CustomerLedgerBook $clb, commonController $cc)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $companyId = $this->companyId;
        $master_company_settings=DB::table('master_company_settings')->find($companyId);
        $CSPR =  DB::table('customer_sales_payment_receives')->where('date',$request->date)->where('partyId',$request->customerId)->first();    
        $nameHindi = $cc->getValueStatic('master_customer_suppliers','nameHindi','id',$CSPR->partyId);
        $openingBalance = $cc->getValueStatic('master_customer_suppliers','openingBalance','id',$CSPR->partyId);
        $oldBalance = $clb->OpeningBalance2($CSPR->partyId, $openingBalance, $request->date);
        
        
        $id = $CSPR->id;
        $Y = date('y', strtotime($request->date));
        $day = $cc->EnDayToHiDay(date('D', strtotime($request->date)));
        $invoiceNumber = $this->invoice_num(++$id, 6, "CR".$Y."/");
    
            $content ='
            <html>
            <head>
            <meta charset="utf-8">
            </head>';
    
            $content.="
            <body>
            <div style='width:100%;height:10%;background-color:white;border:
            #000000 1px solid' >
            <table width='100%'>
    
            <tr>
            <td colspan='2' style='text-align:center;font-family:ind_hi_1_001;'><h2>".$master_company_settings->nameHindi."</h2></td>
            </tr>
            
            <tr>
            <td  colspan='2' style='text-align:center;font-family:ind_hi_1_001;'><h4>".$master_company_settings->addressHindi."</h4></td>
            </tr>
    
            <tr>
            <td  colspan='2' style='text-align:center;font-family:ind_hi_1_001;'><h4>मो. : ".$master_company_settings->mobile.",".$master_company_settings->mobile2."</h4></td>
            </tr>
    
            <tr>
            <td  style='text-align:center;font-family:ind_hi_1_001;'><h6> जमा पावती  </h6></td>
            <td  style='text-align:center;font-family:ind_hi_1_001;'><h6> ".$invoiceNumber." </h6></td>
            </tr>
            </table>
            </div>
    
            <div style='width:100%;height:75%;background-color:white;border:
            #000000 1px solid' >
            <table width='100%'>";
    
            // $content .="
            // <tr>
            // <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> Receipt No.  : </h4></td>
            // <td width='50%'> <h4> Receipt1936918</h4></td>
            // </tr>
            // "; 
    
    
            $content .="
            <tr>
            <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> तारख : </h4></td>
            <td width='50%'><h4 style='font-family:ind_hi_1_001;'>".date('d-m-Y', strtotime($request->date))." (".$day.")</h4></td>    
            </tr>
    
            <tr>
            <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4>ाहक का नाम : </h4></td>
            <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4>".$nameHindi."</h4></td>
            </tr>
    
           
            <tr>
            <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> पुराना बकाया राश : </h4></td>
            <td width='50%'><h4>".($oldBalance+$CSPR->amount)."</h4></td>
    
            </tr>
    
            <tr>
            <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> जमा राश :</h4></td>
            <td width='50%'><h4>".$CSPR->amount."</h4></td>
    
            </tr>
            <tr>
            <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4>डकाउंट राश : </h4></td>
            <td width='50%'><h4>".$CSPR->discount."</h4></td></tr>";
    
            $content .="       
    
            <tr>
            <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> वतमान बकाया राश : </h4></td>
            <td width='50%'><h4>".($oldBalance)."</h4></td>
    
            </tr>
    
            <tr>
            <td colspan=2 style='text-align:right;'>        
            <br>
            <br>
            <br>
            For ".$master_company_settings->name." &nbsp; &nbsp;
            </td>
            </tr>
    
            </table>
            </div>
    
            </body>	
            <html>
    
    
            ";
    
            $content = urlencode(base64_encode($content));
            $size='A6';            
            return Redirect::away('http://rashmihomecare.com/mpdf/mPDF.php?content='.$content.'&size='.$size);
    }

    
    public function PdfPaymentA6(Request $request, CustomerSupplierCarretLedger $cscl, CustomerLedgerBook $clb, commonController $cc)
    {      
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    $companyId = $this->companyId;
    $master_company_settings=DB::table('master_company_settings')->find($companyId);
    $CSPR =  DB::table('customer_sales_payment_receives')->where('date',$request->date)->where('partyId',$request->customerId)->first();    
    $name = $cc->getValueStatic('master_customer_suppliers','name','id',$CSPR->partyId);
    $openingBalance = $cc->getValueStatic('master_customer_suppliers','openingBalance','id',$CSPR->partyId);
    $oldBalance = $clb->OpeningBalance2($CSPR->partyId, $openingBalance, $request->date);
    
    
    $id = $CSPR->id;
    $Y = date('y', strtotime($request->date));
    $day = date('D', strtotime($request->date));
    $invoiceNumber = $this->invoice_num(++$id, 6, "CR".$Y."/");

        $content ='
        <html>
        <head>
        <meta charset="utf-8">
        </head>';

        $content.="
        <body>
        <div style='width:100%;height:10%;background-color:white;border:
        #000000 1px solid' >
        <table width='100%'>

        <tr>
        <td colspan='2' style='text-align:center;font-family:ind_hi_1_001;'><h2>".$master_company_settings->name."</h2></td>
        </tr>
        
        <tr>
        <td  colspan='2' style='text-align:center;font-family:ind_hi_1_001;'><h4>".$master_company_settings->address."</h4></td>
        </tr>

        <tr>
        <td  colspan='2' style='text-align:center;font-family:ind_hi_1_001;'><h4>Mo. : ".$master_company_settings->mobile.",".$master_company_settings->mobile2."</h4></td>
        </tr>

        <tr>
        <td  style='text-align:center;font-family:ind_hi_1_001;'><h6> Deposite Receipt  </h6></td>
        <td  style='text-align:center;font-family:ind_hi_1_001;'><h6> ".$invoiceNumber." </h6></td>
        </tr>
        </table>
        </div>

        <div style='width:100%;height:75%;background-color:white;border:
        #000000 1px solid' >
        <table width='100%'>";

        // $content .="
        // <tr>
        // <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> Receipt No.  : </h4></td>
        // <td width='50%'> <h4> Receipt1936918</h4></td>
        // </tr>
        // "; 


        $content .="
        <tr >
        <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> Date : </h4></td>
        <td width='50%'><h4>".date('d-m-Y', strtotime($request->date))." (".$day.")</h4></td>

        </tr>

        <tr >
        <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4>Customer Name : </h4></td>
        <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4>".$name."</h4></td>
        </tr>

       
        <tr>
        <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> Old Bal. Amount  : </h4></td>
        <td width='50%'><h4>".($oldBalance+$CSPR->amount)."</h4></td>

        </tr>

        <tr>
        <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> Deposite Amount :</h4></td>
        <td width='50%'><h4>".$CSPR->amount."</h4></td>

        </tr>
        <tr>
        <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> Discount Amount : </h4></td>
        <td width='50%'><h4>".$CSPR->discount."</h4></td></tr>";

        $content .="       

        <tr>
        <td width='50%' style='text-align:left;font-family:ind_hi_1_001;'><h4> Net Bal. Amount  : </h4></td>
        <td width='50%'><h4>".($oldBalance)."</h4></td>

        </tr>

        <tr>
        <td colspan=2 style='text-align:right;'>        
        <br>
        <br>
        <br>
        For ".$master_company_settings->name." &nbsp; &nbsp;
        </td>
        </tr>

        </table>
        </div>

        </body>	
        <html>


        ";

        $content = urlencode(base64_encode($content));
        $size='A6';            
        return Redirect::away('http://rashmihomecare.com/mpdf/mPDF.php?content='.$content.'&size='.$size);

    }

    //CARET RECEIVE EN A6
    public function PdfCarretReceiveA6(Request $request, CustomerSupplierCarretLedger $cscl, commonController $cc)
    {    
    
        $customer_carret_receives = DB::table('customer_carret_receives')->where('id',$request->id)->first();
        $comp = DB::table('master_company_settings')->where('id',$customer_carret_receives->companyId)->first();
    
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $newdate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $request->date) ) ));
        $OldCarretBal = $cscl->getPartyCarretBalanceWithZeroByDateStatic($customer_carret_receives->partyId, $newdate);
        $CurCarretBal = $cscl->getPartyCarretBalanceWithZeroByDateStatic($customer_carret_receives->partyId, $date);
        $day = date('D', strtotime($customer_carret_receives->date));
        $dayInHi = $cc->staticEnDayToHiDay($day);
        $customer_carret_receives->unitId;
        $unitName = $cc->getValueStatic('master_units','name','id',$customer_carret_receives->unitId);

        $partyName = $cc->getValueStatic('master_customer_suppliers','name','id',$customer_carret_receives->partyId);
        
        $remark = '';
        if($customer_carret_receives->narration!=''){
            $remark = '<tr><td colspan="3"> <b>Remark </b></td><td colspan="3"> '.$customer_carret_receives->narration.' </td></tr>';
        }
                

        //VIEW PART
        $content = urlencode('
        <!DOCTYPE html> <html lang="en"> <head> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Document</title> <style> tr, th, td{ font-family:ind_hi_1_001; } </style> </head> <body> <table cellspacing="5px" rowspacing="5px" > <tr> <th style="text-align:center;" colspan="6"> '.$comp->name.' </th> </tr> <tr> <td style="text-align:center;" colspan="6" ><b>'.$comp->address.'<br> Mo. :</b>'.$comp->mobile.', '.$comp->mobile2.'<br> <b>Caret Receipt</td> </tr> <tr class="row2"> <td colspan="3"> <b> Date : </b></td> <td colspan="3"> '. date("d-m-Y", strtotime($customer_carret_receives->date)).' ( '.$day.' )</td> </tr> <tr> <td colspan="3"> <b>Customer Name :</b></td> <td colspan="3"> '.$partyName.' </td> </tr> <tr> <td colspan="3"> <b>Old Bal. Carret : </b></td> <td colspan="3">'.$OldCarretBal.'</td> </tr> <tr class="row3"> <td colspan="3"> <b>Deposite Carret : </b></td> <td colspan="3">'.$unitName.' : '.$customer_carret_receives->qty.'</td> </tr> '.$remark.' <tr class="row4"> <td colspan="6" style="font-size: 14px;"> <b>Balance Carret : </b> '.$CurCarretBal.'</td> </tr> <tr> <td colspan="6" style="text-align:right;">For '.$comp->name.' </td> </tr> </table> </body> </html>
        ');

        $size = 'A6';

        return Redirect::to('http://localhost/mpdf/mPDF.php?content='.$content.'&size='.$size);

    }


    // CARET RECEIVE HINDI A6
    public function PdfCarretReceiveHindiA6(Request $request, CustomerSupplierCarretLedger $cscl, commonController $cc)
    {
        $customer_carret_receives=  DB::table('customer_carret_receives')->where('id',$request->id)->first();
        $comp=DB::table('master_company_settings')->where('id',$customer_carret_receives->companyId)->first();
        $master_units = DB::table('master_units')->get();

        // ===== GET DATA FOR VIEW =====
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $dateSub1Day = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $request->date) ) ));
        $OldCarretBal = $cscl->getPartyCarretBalanceWithZeroByDateStatic($customer_carret_receives->partyId, $dateSub1Day);
        $CurCarretBal = $cscl->getPartyCarretBalanceWithZeroByDateStatic($customer_carret_receives->partyId, $request->date);

        $day = date('D', strtotime($customer_carret_receives->date));
        $dayInHi = $cc->staticEnDayToHiDay($day);
        $unitName = $cc->getValueStatic('master_units','name','id',$customer_carret_receives->unitId);
        $partyHiName = $cc->getValueStatic('master_customer_suppliers','nameHindi','id',$customer_carret_receives->partyId);
        if ($partyHiName == '') {
            $partyHiName = $cc->getValueStatic('master_customer_suppliers','name','id',$customer_carret_receives->partyId);
        }

            $remark = '';
            if($customer_carret_receives->narration!=''){
                $remark = '<tr>
                <td colspan="3"> <b>रिमार्क </b></td>
                <td colspan="3"> '.$customer_carret_receives->narration.'</td>
                </tr>';
            }            
            
            //VIEW PART
            $content = urlencode('<!DOCTYPE html> <html lang="en"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Document</title> <style> tr, th, td{ font-family:ind_hi_1_001; } </style> </head> <body> <center> <table cellspacing="5px" rowspacing="5px"> <tr> <th style="text-align:center;" colspan="6"><br><br> '. $comp->nameHindi .' </th> </tr> <tr> <td style="text-align:center;" colspan="6" ><b> '.$comp->addressHindi.'<br><br> मो. :</b> '. $comp->mobile.'", "'.$comp->mobile2 .'"<br><br> <b>कैरट पावती</td> </tr> <tr class="row2"> <td colspan="3"> <b> तारीख : </b></td> <td colspan="3">'.date("d-m-Y", strtotime($customer_carret_receives->date))."(". $dayInHi .")".'</td> </tr> <tr> <td colspan="3"> <b>ग्राहक का नाम :</b></td> <td colspan="3"> '.$partyHiName.' </td> </tr> <tr> <td colspan="3"> <b>पिछला बकाया कैरट : </b></td> <td colspan="3"> '.$OldCarretBal.'</td> </tr> <tr class="row3"> <td colspan="3"> <b>जमा कैरट : </b></td> <td colspan="3"> '.$unitName.' : '.$customer_carret_receives->qty.'</td> </tr> '.$remark.' <tr class="row4"> <td colspan="3" > <b> बकाया कैरट : </b></td> <td colspan="3">'.$CurCarretBal.'</td> </tr> <tr> <td colspan="6" style="text-align:right;font-size:16px;"><br><br>For '.$comp->name.' </td> </tr> </table> </center> </body> </html> ');

        $size = 'A6';

        return Redirect::to('http://localhost/mpdf/mPDF.php?content='.$content.'&size='.$size);
        
    }


    


    public function PDFpurchaseEnteryA4(Request $request)
    {   
    $data=  DB::table('purchase_entries')->find($request->id); 
    $comp=DB::table('master_company_settings')->find($data->companyId);
    $records=DB::table('purchase_entry_details')->where('purchaseEntryId',$data->id)->get();
    $expenses=DB::table('purchase_entry_expenses')->where('purchaseEntryId',$data->id)->get();
    $pdf=PDF::loadView('PDFpurchaseEnteryA4',compact('data','comp','records','expenses'))->setPaper('A4');
    return $pdf->stream();
    }

    public function PDFpurchaseEnteryA5(Request $request)
    {   
    $data=  DB::table('purchase_entries')->find($request->id);
    $comp=DB::table('master_company_settings')->find($data->companyId);
    $records=DB::table('purchase_entry_details')->where('purchaseEntryId',$data->id)->get();
    $expenses=DB::table('purchase_entry_expenses')->where('purchaseEntryId',$data->id)->get();
    // dd($expenses);
    // dd($data);
    // dd($records);
    $pdf=PDF::loadView('PDFpurchaseEnteryA5',compact('data','comp','records','expenses'))->setPaper('A5');
    return $pdf->stream();
    }

    public function PDFpurchaseEnteryA4Hindi(Request $request)
    {    

    $data=  DB::table('purchase_entries')->find($request->id);
 
    $comp=DB::table('master_company_settings')->find($data->companyId);

    $records=DB::table('purchase_entry_details')->where('purchaseEntryId',$data->id)->get();
    $expenses=DB::table('purchase_entry_expenses')->where('purchaseEntryId',$data->id)->get();
    // dd($expenses);
    // dd($data);
    // dd($records);
    $pdf=PDF::loadView('PDFpurchaseEnteryA4Hindi',compact('data','comp','records','expenses'))->setPaper('A4');
    return $pdf->stream();
    }

    public function PDFpurchaseEnteryA5Hindi(Request $request)
    {    

    $data=  DB::table('purchase_entries')->find($request->id);
 
    $comp=DB::table('master_company_settings')->find($data->companyId);

    $records=DB::table('purchase_entry_details')->where('purchaseEntryId',$data->id)->get();
    $expenses=DB::table('purchase_entry_expenses')->where('purchaseEntryId',$data->id)->get();
    // dd($expenses);
    // dd($data);
    // dd($records);
    $pdf=PDF::loadView('PDFpurchaseEnteryA5Hindi',compact('data','comp','records','expenses'))->setPaper('A5');
    return $pdf->stream();
    }

    //incomete
    public function PDFSuppllierCarretReturnA6(Request $request)
    {
        $customPaper = array(0,0,290,1500);
        $row=  DB::table('customer_carret_receives')->where('id',$request->id)->first();
    //    dd($row);
        $comp=DB::table('master_company_settings')->where('id',$row->companyId)->first();
        // dd($comp);
        $pdf=PDF::loadView('PDFSuppllierCarretReturnA6',compact('row','comp'))->setPaper($customPaper);
        return $pdf->stream();
    }



    public function pdfLoadingEntryA6(Request $request)
    {
        $customPaper = array(0,0,290,1500);
        $row=  DB::table('loading_entries')->where('id',$request->id)->first();
        $data=  DB::table('loading_entry_details')->where('id',$row->id)->get();
        //dd($row);
        $comp=DB::table('master_company_settings')->where('id',$row->companyId)->first();
        // dd($comp);
        $pdf=PDF::loadView('pdfLoadingEntryA6',compact('row','comp','data'))->setPaper($customPaper);
        return $pdf->stream();
    }



    public function pdfLoadingEntryA6Hindi(Request $request)
    {
        $customPaper = array(0,0,290,1500);
        $row=  DB::table('loading_entries')->where('id',$request->id)->first();
        $data=  DB::table('loading_entry_details')->where('id',$row->id)->get();
        //dd($row);
        $comp=DB::table('master_company_settings')->where('id',$row->companyId)->first();
        // dd($comp);
        $pdf=PDF::loadView('pdfLoadingEntryA6Hindi',compact('row','comp','data'))->setPaper($customPaper);
        return $pdf->stream();
        //return view('pdfLoadingEntryA6Hindi',compact('row','comp','data'));
    }


    public function PDFpurchasePaymentA6(Request $request)
    {
        $customPaper = array(0,0,290,1500);
        $row=  DB::table('purchase_payment_entries')->where('partyId',$request->partyId)->where('date',$request->date)->first();
        // dd($row);     
      
        $comp=DB::table('master_company_settings')->where('id',$row->companyId)->first();
        // dd($comp);
        $pdf=PDF::loadView('PDFpurchasePaymentA6',compact('row','comp'))->setPaper($customPaper);
        return $pdf->stream();
    }


    public function PDFpurchasePaymentA6Hindi(Request $request)
    {
        $customPaper = array(0,0,290,1500);
        $customPaper = array(0,0,290,1500);
        $row=  DB::table('purchase_payment_entries')->where('partyId',$request->partyId)->where('date',$request->date)->first();
        // dd($row);     
      
        $comp=DB::table('master_company_settings')->where('id',$row->companyId)->first();
        $pdf=PDF::loadView('PDFpurchasePaymentA6Hindi',compact('row','comp'))->setPaper($customPaper);
        return $pdf->stream();
   
    }


    public function PDFsulliperCarretReturnA6(Request $request)
    {
        $customPaper = array(0,0,290,1500);
        $row= DB::table('supplier_carret_returns')->where('id',$request->id)->first();
      
        $comp=DB::table('master_company_settings')->where('id',$row->companyId)->first();
        $pdf=PDF::loadView('PDFsulliperCarretReturnA6',compact('row','comp'))->setPaper($customPaper);
        return $pdf->stream();
   
    }



    public function PDFsulliperCarretReturnA6Hindi(Request $request)
    {
        $customPaper = array(0,0,290,1500);
        $row= DB::table('supplier_carret_returns')->where('id',$request->id)->first();
        //  dd($row);
        $comp=DB::table('master_company_settings')->where('id',$row->companyId)->first();
        // $pdf=PDF::loadView('PDFsulliperCarretReturnA6Hindi',compact('row','comp'))->setPaper($customPaper);
        // return $pdf->stream();
        return view('PDFsulliperCarretReturnA6Hindi',compact('row','comp'));
   
    }

}
