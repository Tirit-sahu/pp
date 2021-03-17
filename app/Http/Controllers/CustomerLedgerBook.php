<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterCustomerSupplier;
use DB;
use Session;

class CustomerLedgerBook extends Controller
{
    
    public $companyId;

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->companyId = Session::get('companyId');   
            return $next($request);
        });
    }


    public function index(Request $request)
    {   
        $companyId = $this->companyId;
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');

        $CustomerLedgerBook = [];
        $status = false;
        $condition = "companyId = ".$companyId;

        if (!empty($request->partyId) && !empty($request->fromDate) && !empty($request->toDate)) {
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            $condition .= " AND partyId = ".$request->partyId." AND date BETWEEN '$fromDate' AND '$toDate'";
            $status = true;
        }

        $partType = '';
        $openingBlance = 0;
        if ($status == true) {
            
            $partyId = $request->partyId;
            $fromDate = $request->fromDate;
            $newDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $fromDate) ) ));

            $openBal = DB::table('master_customer_suppliers')
            ->where('id', $partyId)            
            ->value('openingBalance');
            
            $openingBlance = $this->OpeningBalance2($partyId, $openBal, $request->fromDate);

            // return $openingBlance;

            $condition .= " GROUP BY date";

            $CustomerLedgerBook = DB::select("SELECT date AS date, partyId AS partyId, SUM(amount) AS amount, particular AS particular, remark AS remark FROM customer_sales 
            WHERE $condition 
            UNION 
            SELECT date AS date, partyId AS partyId, SUM(amount+discount) AS amount, particular AS particular, narration AS remark FROM customer_sales_payment_receives 
            WHERE $condition 
            UNION
            SELECT date AS date, partyId AS partyId, SUM(totalAmt) AS amount, particular AS particular, narration AS remark FROM purchase_entries 
            WHERE $condition
            UNION
            SELECT date AS date, partyId AS partyId, SUM(amount+discount) AS amount, particular AS particular, narration AS remark FROM purchase_payment_entries 
            WHERE $condition
            UNION
            SELECT date AS date, partyId AS partyId, SUM(netAmount) AS amount, particular AS particular, narration AS remark FROM loading_entries 
            WHERE $condition ORDER BY date ASC");    
            
            
            $master_customer_suppliers = DB::table('master_customer_suppliers')
            ->where('id', $request->partyId)
            ->first();
            
            if($master_customer_suppliers->customer == '1'){
            $partType = 'customerRate';
            }
            if($master_customer_suppliers->supplier == '1'){
            $partType = 'supplierRate';
            }
        }        

        // dd($CustomerLedgerBook);

        return view('customer-ledger-book', ['CustomerLedgerBook'=>$CustomerLedgerBook, 'openingBlance'=>$openingBlance, 'partType'=>$partType]);

    }




    public function ledgerBookDetails(Request $request)
    {
        $companyId = $this->companyId;
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');

        $CustomerLedgerBook = [];
        $status = false;
        $condition = "companyId = ".$companyId;

        if (!empty($request->partyId) && !empty($request->fromDate) && !empty($request->toDate)) {
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            $condition .= " AND partyId = ".$request->partyId." AND date BETWEEN '$fromDate' AND '$toDate'";
            $status = true;
        }

        // dd($condition);
        $partType = '';
        $openingBlance = 0;
        if ($status == true) {
            
            $partyId = $request->partyId;
            $fromDate = $request->fromDate;
            $newDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $fromDate) ) ));

            $openBal = DB::table('master_customer_suppliers')
            ->where('id', $partyId)            
            ->value('openingBalance');

            $openingBlance = $this->OpeningBalance2($partyId, $openBal, $request->fromDate);

            // dd($openingBlance);

            $condition .= " GROUP BY date";

            $CustomerLedgerBook = DB::select("SELECT date AS date, partyId AS partyId, SUM(amount) AS amount, particular AS particular, remark AS remark FROM customer_sales 
            WHERE $condition 
            UNION 
            SELECT date AS date, partyId AS partyId, SUM(amount+discount) AS amount, particular AS particular, narration AS remark FROM customer_sales_payment_receives 
            WHERE $condition 
            UNION
            SELECT date AS date, partyId AS partyId, SUM(totalAmt) AS amount, particular AS particular, narration AS remark FROM purchase_entries 
            WHERE $condition
            UNION
            SELECT date AS date, partyId AS partyId, SUM(amount+discount) AS amount, particular AS particular, narration AS remark FROM purchase_payment_entries 
            WHERE $condition
            UNION
            SELECT date AS date, partyId AS partyId, SUM(netAmount) AS amount, particular AS particular, narration AS remark FROM loading_entries WHERE $condition
            ORDER BY date ASC");       
            
            $master_customer_suppliers = DB::table('master_customer_suppliers')
            ->where('id', $request->partyId)
            ->first();

            
            if($master_customer_suppliers->customer == '1'){
            $partType = 'customerRate';
            }
            if($master_customer_suppliers->supplier == '1'){
            $partType = 'supplierRate';
            }

        }              
        // dd($CustomerLedgerBook);
        return view('customer-detail-ledger-book', ['CustomerLedgerBook'=>$CustomerLedgerBook, 'openingBlance'=>$openingBlance, 'partType'=>$partType]);
    }


    public function partyBalanceReport(Request $request)
    {       

        $companyId = $this->companyId;
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $status = false;
        $master_units = DB::table('master_units')
        ->where('isStockable', 'Yes')
        ->get();
        $parties = [];

        if (empty($request->all())) {
            return view('balance-report', ['parties'=>$parties, 'master_units'=>$master_units]);
        }

        

        $partyQry = MasterCustomerSupplier::query();
        $partyQry->orderBy('id','DESC');

        if (!empty($request->groupName)) {
            $partyQry->where(['companyId'=>$companyId, 'status'=>'Active', 'groupName'=>$request->groupName]);
        }  
        
        if (!empty($request->name)) {
            $partyQry->where(['companyId'=>$companyId, 'status'=>'Active'])
            ->where('id', $request->name);
        }       
        

        $partyQry->where(['companyId'=>$companyId, 'status'=>'Active']);

        $parties = $partyQry->paginate(1000)->appends(request()->query());
        
        return view('balance-report', ['parties'=>$parties, 'master_units'=>$master_units]);
    }



    public function getPartySelectOption(Request $request){
        
        $key = $request->key;
        $companyId = $this->companyId;

        $partyArray = explode(",", $key);
        $condition=' companyId = '.$companyId; 
        if (!empty($partyArray[0])) {
            $i=0;
            foreach($partyArray as $k){
                $x = '';
                if($i==0){
                    $x = ' AND ';
                }else{
                    $x = ' OR ';
                }
                $condition .= $x.$k.' = 1';
                ++$i;
            }
        }
            
        // return "SELECT * FROM `master_customer_suppliers` WHERE $condition ORDER BY `id` DESC";

        $collection=DB::select("SELECT * FROM `master_customer_suppliers` WHERE $condition ORDER BY `id` DESC");
        $select_option='';
        $select_option.="<option value=''>Select an Option</option>";
        foreach ($collection as $row) {
            $select_option.="<option value='".$row->id."'>".$row->name."</option>";
        }
        return $select_option;
    
    }




    public static function OpeningBalance($partyId, $openBal)
    {
            date_default_timezone_set('Asia/Kolkata');
            $date = date('Y-m-d');

            $newDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));

            $customer_sales = DB::select("SELECT SUM(amount) AS amount FROM `customer_sales` WHERE partyId = $partyId AND date <= '$newDate'");
            $customerSaleAmt = $customer_sales[0]->amount;
            
            $customer_sales_payment_receives = DB::select("SELECT SUM(amount+discount) AS amount FROM `customer_sales_payment_receives` WHERE partyId = $partyId AND date <= '$newDate'");
            $customerSalePaidAmt = $customer_sales_payment_receives[0]->amount;

            $purchase_entries = DB::select("SELECT SUM(totalAmt) AS totalAmt FROM purchase_entries WHERE partyId = $partyId AND date <= '$newDate'");
            $purchaseAmt = $purchase_entries[0]->totalAmt;

            $purchase_payment_entries = DB::select("SELECT SUM(amount+discount) AS amount FROM purchase_payment_entries WHERE partyId = $partyId AND date <= '$newDate'");
            $purchasePaidAmt = $purchase_payment_entries[0]->amount;

            $loading_entries = DB::select("SELECT SUM(netAmount) AS netAmount FROM loading_entries WHERE partyId = $partyId AND date <= '$newDate'");
            $loadingAmt = $loading_entries[0]->netAmount;

            $openingBlance = $openBal + $customerSaleAmt - $customerSalePaidAmt - $purchaseAmt + $purchasePaidAmt + $loadingAmt;

            return $openingBlance;
    }


    public function OpeningBalance2($partyId, $openBal, $date)
    {
        date_default_timezone_set('Asia/Kolkata');

        $newDate = date('Y-m-d', strtotime($date));
        
        $customer_sales = DB::select("SELECT SUM(amount) AS amount FROM `customer_sales` WHERE partyId = $partyId AND date <= '$newDate'");
        $customerSaleAmt = $customer_sales[0]->amount;
        
        $customer_sales_payment_receives = DB::select("SELECT SUM(amount+discount) AS amount FROM `customer_sales_payment_receives` WHERE partyId = $partyId AND date <= '$newDate'");
        $customerSalePaidAmt = $customer_sales_payment_receives[0]->amount;

        $purchase_entries = DB::select("SELECT SUM(totalAmt) AS totalAmt FROM purchase_entries WHERE partyId = $partyId AND date <= '$newDate'");
        $purchaseAmt = $purchase_entries[0]->totalAmt;

        $purchase_payment_entries = DB::select("SELECT SUM(amount+discount) AS amount FROM purchase_payment_entries WHERE partyId = $partyId AND date <= '$newDate'");
        $purchasePaidAmt = $purchase_payment_entries[0]->amount;

        $loading_entries = DB::select("SELECT SUM(netAmount) AS netAmount FROM loading_entries WHERE partyId = $partyId AND date <= '$newDate'");
        $loadingAmt = $loading_entries[0]->netAmount;

        $openingBlance = $openBal + $customerSaleAmt - $customerSalePaidAmt - $purchaseAmt + $purchasePaidAmt + $loadingAmt;
        return $openingBlance;
    }


    public static function partyBalance($partyId, $openBal)
    {
            date_default_timezone_set('Asia/Kolkata');
            $newDate = date('Y-m-d');
            // $newDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
            $customer_sales = DB::select("SELECT SUM(amount) AS amount FROM `customer_sales` WHERE partyId = $partyId AND date <= '$newDate'");
            $customerSaleAmt = $customer_sales[0]->amount;
            
            $customer_sales_payment_receives = DB::select("SELECT SUM(amount+discount) AS amount FROM `customer_sales_payment_receives` WHERE partyId = $partyId AND date <= '$newDate'");
            $customerSalePaidAmt = $customer_sales_payment_receives[0]->amount;

            $purchase_entries = DB::select("SELECT SUM(totalAmt) AS totalAmt FROM purchase_entries WHERE partyId = $partyId AND date <= '$newDate'");
            $purchaseAmt = $purchase_entries[0]->totalAmt;

            $purchase_payment_entries = DB::select("SELECT SUM(amount+discount) AS amount FROM purchase_payment_entries WHERE partyId = $partyId AND date <= '$newDate'");
            $purchasePaidAmt = $purchase_payment_entries[0]->amount;

            $loading_entries = DB::select("SELECT SUM(netAmount) AS netAmount FROM loading_entries WHERE partyId = $partyId AND date <= '$newDate'");
            $loadingAmt = $loading_entries[0]->netAmount;

            $openingBlance = $openBal + $customerSaleAmt - $customerSalePaidAmt - $purchaseAmt + $purchasePaidAmt + $loadingAmt;

            return $openingBlance;
    }


    public function nonStaticGetPartyBalance(Request $request)
    {
            date_default_timezone_set('Asia/Kolkata');
            $newDate = date('Y-m-d');
            $partyId = $request->partyId;
            $openBal = DB::table('master_customer_suppliers')->where('id', $partyId)->value('openingBalance');
            // $newDate = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date) ) ));
            $customer_sales = DB::select("SELECT SUM(amount) AS amount FROM `customer_sales` WHERE partyId = $partyId AND date <= '$newDate'");
            $customerSaleAmt = $customer_sales[0]->amount;
            
            $customer_sales_payment_receives = DB::select("SELECT SUM(amount+discount) AS amount FROM `customer_sales_payment_receives` WHERE partyId = $partyId AND date <= '$newDate'");
            $customerSalePaidAmt = $customer_sales_payment_receives[0]->amount;

            $purchase_entries = DB::select("SELECT SUM(totalAmt) AS totalAmt FROM purchase_entries WHERE partyId = $partyId AND date <= '$newDate'");
            $purchaseAmt = $purchase_entries[0]->totalAmt;

            $purchase_payment_entries = DB::select("SELECT SUM(amount+discount) AS amount FROM purchase_payment_entries WHERE partyId = $partyId AND date <= '$newDate'");
            $purchasePaidAmt = $purchase_payment_entries[0]->amount;

            $loading_entries = DB::select("SELECT SUM(netAmount) AS netAmount FROM loading_entries WHERE partyId = $partyId AND date <= '$newDate'");
            $loadingAmt = $loading_entries[0]->netAmount;

            $openingBlance = (($openBal + $customerSaleAmt) - $customerSalePaidAmt) - ($purchaseAmt + $purchasePaidAmt + $loadingAmt);

            return $openingBlance;
    }


    public static function getCarretOpenByDate($partyId, $unitId, $date)
    {
        
        $companyId = 1;

        $openBalCarret = DB::table('master_customer_supplier_unit_entries')
        ->where(['mCustomerSupplierId'=>$partyId, 'unitId'=>$unitId])
        ->value('openingUnit');

        $customerSaleCarret = DB::select("SELECT SUM(qty) AS customerSaleCarretQty FROM customer_sales WHERE partyId = $partyId AND unitId = $unitId AND date <= '$date'");
        
        $customerSaleCarretQty = $customerSaleCarret[0]->customerSaleCarretQty;


        $loading_entries = DB::select("SELECT SUM(loading_entry_details.qty) AS loadingCarretQty FROM loading_entries LEFT JOIN loading_entry_details ON loading_entry_details.loadingEntryId = loading_entries.id WHERE loading_entries.partyId = $partyId AND loading_entry_details.unitId = $unitId AND loading_entries.date <= '$date'");
        
        $loadingCarretQty = $loading_entries[0]->loadingCarretQty;

        $customerCarretReceive = DB::select("SELECT SUM(qty) AS customerCarretReceiveQty FROM `customer_carret_receives` WHERE companyId = $companyId AND partyId = $partyId AND unitId = $unitId AND date <= '$date'");

        $customerCarretReceiveQty = $customerCarretReceive[0]->customerCarretReceiveQty;

        $purchase_entries = DB::select("SELECT SUM(purchase_entry_details.qty) AS purchaseEntryCarretQty FROM purchase_entries LEFT JOIN purchase_entry_details ON purchase_entry_details.purchaseEntryId = purchase_entries.id WHERE purchase_entries.partyId = $partyId AND purchase_entry_details.unitId = $unitId AND purchase_entries.date <= '$date'");

        $purchaseEntryCarretQty = $purchase_entries[0]->purchaseEntryCarretQty;


        $supplier_carret_returns = DB::select("SELECT SUM(qty) AS supplierCarretReturn FROM supplier_carret_returns WHERE companyId = $companyId AND partyId = $partyId AND unitId = $unitId AND date <= '$date'");

        $supplierCarretReturn = $supplier_carret_returns[0]->supplierCarretReturn;

        return $openBalCarret + $customerSaleCarretQty + $purchaseEntryCarretQty + $loadingCarretQty - $customerCarretReceiveQty + $supplierCarretReturn;
        
    }



    public function getCarretOpenByDate2($partyId, $unitId, $date)
    {

        $companyId = 1;

        $openBalCarret = DB::table('master_customer_supplier_unit_entries')
        ->where(['mCustomerSupplierId'=>$partyId, 'unitId'=>$unitId])
        ->value('openingUnit');

        $customerSaleCarret = DB::select("SELECT SUM(qty) AS customerSaleCarretQty FROM customer_sales WHERE partyId = $partyId AND unitId = $unitId AND date <= '$date'");
        
        $customerSaleCarretQty = $customerSaleCarret[0]->customerSaleCarretQty;


        $loading_entries = DB::select("SELECT SUM(loading_entry_details.qty) AS loadingCarretQty FROM loading_entries LEFT JOIN loading_entry_details ON loading_entry_details.loadingEntryId = loading_entries.id WHERE loading_entries.partyId = $partyId AND loading_entry_details.unitId = $unitId AND loading_entries.date <= '$date'");
        
        $loadingCarretQty = $loading_entries[0]->loadingCarretQty;

        $customerCarretReceive = DB::select("SELECT SUM(qty) AS customerCarretReceiveQty FROM `customer_carret_receives` WHERE companyId = $companyId AND partyId = $partyId AND unitId = $unitId AND date <= '$date'");

        $customerCarretReceiveQty = $customerCarretReceive[0]->customerCarretReceiveQty;

        $purchase_entries = DB::select("SELECT SUM(purchase_entry_details.qty) AS purchaseEntryCarretQty FROM purchase_entries LEFT JOIN purchase_entry_details ON purchase_entry_details.purchaseEntryId = purchase_entries.id WHERE purchase_entries.partyId = $partyId AND purchase_entry_details.unitId = $unitId AND purchase_entries.date <= '$date'");

        $purchaseEntryCarretQty = $purchase_entries[0]->purchaseEntryCarretQty;


        $supplier_carret_returns = DB::select("SELECT SUM(qty) AS supplierCarretReturn FROM supplier_carret_returns WHERE companyId = $companyId AND partyId = $partyId AND unitId = $unitId AND date <= '$date'");

        $supplierCarretReturn = $supplier_carret_returns[0]->supplierCarretReturn;


        return $openBalCarret + $customerSaleCarretQty + $purchaseEntryCarretQty + $loadingCarretQty - $customerCarretReceiveQty + $supplierCarretReturn;
        
    }



}
