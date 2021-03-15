<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class CustomerSupplierCarretLedger extends Controller
{
    
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->companyId = Session::get('companyId');   
            return $next($request);
        });
    }

    public function CustSuppCarretLedger(CustomerLedgerBook $c, Request $request)
    {
        $companyId=$this->companyId;
        $date = date('Y-m-d');

        $customerSupplierCarretLedger=[];

        if (!empty($request->partyId) && !empty($request->fromDate) && !empty($request->toDate)) {
            
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            $partyId = $request->partyId;          
                    
            
            $customerSupplierCarretLedger = DB::select("SELECT date AS date, partyId AS partyId, qty AS qty, unitId AS unitId, particular AS particular FROM customer_sales 
            WHERE companyId = $companyId AND partyId = $partyId AND date BETWEEN '$fromDate' AND '$toDate'
            UNION
            SELECT date AS date, partyId AS partyId, qty+discount AS qty, unitId AS unitId, particular AS particular FROM customer_carret_receives 
            WHERE companyId = $companyId AND partyId = $partyId AND date BETWEEN '$fromDate' AND '$toDate'
            UNION
            SELECT purchase_entries.date AS date, purchase_entries.partyId AS partyId, purchase_entry_details.qty AS qty, purchase_entry_details.unitId AS unitId, purchase_entries.particular AS particular FROM purchase_entries
            LEFT JOIN purchase_entry_details ON purchase_entries.id = purchase_entry_details.purchaseEntryId
            WHERE purchase_entries.companyId = $companyId AND purchase_entries.partyId = $partyId AND purchase_entries.date BETWEEN '$fromDate' AND '$toDate'
            UNION
            SELECT date AS date, partyId AS partyId, qty+discount AS qty, unitId AS unitId, particular AS particular FROM supplier_carret_returns 
            WHERE companyId = $companyId AND partyId = $partyId AND date BETWEEN '$fromDate' AND '$toDate'
            UNION
            SELECT loading_entries.date AS date, loading_entries.partyId AS partyId, loading_entry_details.qty AS qty, loading_entry_details.unitId AS unitId, loading_entries.particular AS particular FROM loading_entries
            LEFT JOIN loading_entry_details ON loading_entries.id = loading_entry_details.loadingEntryId
            WHERE loading_entries.companyId = $companyId AND loading_entries.partyId = $partyId AND loading_entries.date BETWEEN '$fromDate' AND '$toDate' ORDER BY date");    
            
        }
        
        $master_units = DB::table('master_units')
            ->where(['isStockable'=>'Yes', 'companyId'=>$companyId])
            ->get(); 
        // dd($customerSupplierCarretLedger);        
        
        return view('customer-supplier-carret-ledger', ['master_units'=>$master_units, 'customerSupplierCarretLedger'=>$customerSupplierCarretLedger]);
    }


    public static function getPartyCarretBalanceByDateStatic($partyId, $date)
    {
       $companyId = Session::get('companyId'); 

        $master_units = DB::table('master_units')
        ->where(['companyId'=>$companyId, 'isStockable'=>'Yes'])
        ->get();
        
        $unitArray = [];
        $unitNameArray = [];        
        

        $OUARRAY = [];
        foreach ($master_units as $munit) {
            $unitName = $munit->name;
            $customer_sales = DB::select("SELECT SUM(openingUnit) AS qty FROM `master_customer_supplier_unit_entries` WHERE mCustomerSupplierId = $partyId AND unitId = $munit->id");    
            foreach($customer_sales as $ou){
                $qty = isset($ou->qty)?$ou->qty:0;
                $OUARRAY = array_merge($OUARRAY, [$unitName=>$qty]);
            } 
        }


        $CSARRAY = [];
        foreach ($master_units as $munit) {
            $unitName = $munit->name;
            $customer_sales = DB::select("SELECT SUM(qty) AS qty FROM customer_sales WHERE partyId = $partyId AND unitId = $munit->id AND date <= '$date'");    
            foreach($customer_sales as $cs){
                $qty = isset($cs->qty)?$cs->qty:0;
                $CSARRAY = array_merge($CSARRAY, [$unitName=>$qty]);
            } 
        }

        $PEARRAY = [];
        foreach ($master_units as $munit) {
            $unitName = $munit->name;
            $purchase_entries = DB::select("SELECT SUM(purchase_entry_details.qty) AS qty FROM purchase_entries LEFT JOIN purchase_entry_details ON purchase_entries.id = purchase_entry_details.purchaseEntryId WHERE purchase_entries.partyId = $partyId AND purchase_entry_details.unitId = $munit->id AND purchase_entries.date <= '$date'");    
            foreach($purchase_entries as $pe){
                $qty = isset($pe->qty)?$pe->qty:0;
                $PEARRAY = array_merge($PEARRAY, [$unitName=>$qty]);
            } 
        }

        $LEARRAY = [];
        foreach ($master_units as $munit) {
            $unitName = $munit->name;
            $loading_entries = DB::select("SELECT SUM(loading_entry_details.qty) AS qty FROM loading_entries LEFT JOIN loading_entry_details ON loading_entries.id = loading_entry_details.loadingEntryId WHERE loading_entries.partyId = $partyId AND loading_entry_details.unitId = $munit->id AND loading_entries.date <= '$date'");    
            foreach($loading_entries as $le){
                $qty = isset($le->qty)?$le->qty:0;
                $LEARRAY = array_merge($LEARRAY, [$unitName=>$qty]);
            } 
        }


        $CCRARRAY = [];        
        foreach ($master_units as $munit) {            
            $unitName = $munit->name;           
            $customer_carret_receives = DB::select("SELECT SUM(qty+discount) AS qty FROM customer_carret_receives WHERE partyId = $partyId AND unitId = $munit->id AND date <= '$date'");    
            foreach($customer_carret_receives as $ccr){
                $qty = isset($ccr->qty)?$ccr->qty:0;
                $CCRARRAY = array_merge($CCRARRAY, [$unitName=>$qty]);
            } 
        }

        
        $SCRARRAY = [];
        foreach ($master_units as $munit) {
            $unitName = $munit->name;
            array_push($unitNameArray, $unitName);
            $supplier_carret_returns = DB::select("SELECT SUM(qty+discount) AS qty FROM supplier_carret_returns WHERE partyId = $partyId AND unitId = $munit->id AND date <= '$date'");    
            foreach($supplier_carret_returns as $scr){
                $qty = isset($scr->qty)?$scr->qty:0;
                $SCRARRAY = array_merge($SCRARRAY, [$unitName=>$qty]);
            } 
        }

        
        $unitArray1 = array($OUARRAY, $CSARRAY, $PEARRAY, $LEARRAY);
        $unitArray2 = array($CCRARRAY, $SCRARRAY);
        
        // echo '<pre>';
        // print_r($unitArray1);
        // print_r($unitArray2);
        // echo '</pre>';
        $counArray = sizeof($unitNameArray);
        
        // echo array_sum(array_column($unitArray1, 'TMN'));
        $carretWithQty = '';
        for($i=0;$i<$counArray;$i++){
            $comma = '';
            if($i<$counArray-1){
                $comma = ',';
            }
            $cr = array_sum(array_column($unitArray1, $unitNameArray[$i]));
            $dr = array_sum(array_column($unitArray2, $unitNameArray[$i]));
            $bal = $cr - $dr ." ";
            if ($bal !=0) {
                $carretWithQty .= $unitNameArray[$i]." : ".$bal.$comma." ";   
            }
               
        }
        
        return $carretWithQty;


    }


    public function getPartyCarretBalanceByDate(Request $request)
    {
        $partyId = $request->partyId;
        $date = '';
        if(!empty($request->date)){
            $date = $request->date;
        }else{
            date_default_timezone_set('Asia/Kolkata');
            $date = date('Y-m-d');
        }
        $master_units = DB::table('master_units')
        ->where(['companyId'=>1, 'isStockable'=>'Yes'])
        ->get();
        
        $unitArray = [];
        $unitNameArray = [];        
        

        $OUARRAY = [];
        foreach ($master_units as $munit) {
            $unitName = $munit->name;
            $customer_sales = DB::select("SELECT SUM(openingUnit) AS qty FROM `master_customer_supplier_unit_entries` WHERE mCustomerSupplierId = $partyId AND unitId = $munit->id");    
            foreach($customer_sales as $ou){
                $qty = isset($ou->qty)?$ou->qty:0;
                $OUARRAY = array_merge($OUARRAY, [$unitName=>$qty]);
            } 
        }


        $CSARRAY = [];
        foreach ($master_units as $munit) {
            $unitName = $munit->name;
            $customer_sales = DB::select("SELECT SUM(qty) AS qty FROM customer_sales WHERE companyId = 1 AND partyId = $partyId AND unitId = $munit->id AND date <= '$date'");    
            foreach($customer_sales as $cs){
                $qty = isset($cs->qty)?$cs->qty:0;
                $CSARRAY = array_merge($CSARRAY, [$unitName=>$qty]);
            } 
        }

        $PEARRAY = [];
        foreach ($master_units as $munit) {
            $unitName = $munit->name;
            $purchase_entries = DB::select("SELECT SUM(purchase_entry_details.qty) AS qty FROM purchase_entries LEFT JOIN purchase_entry_details ON purchase_entries.id = purchase_entry_details.purchaseEntryId WHERE purchase_entries.partyId = $partyId AND purchase_entry_details.unitId = $munit->id AND purchase_entries.date <= '$date'");    
            foreach($purchase_entries as $pe){
                $qty = isset($pe->qty)?$pe->qty:0;
                $PEARRAY = array_merge($PEARRAY, [$unitName=>$qty]);
            } 
        }

        $LEARRAY = [];
        foreach ($master_units as $munit) {
            $unitName = $munit->name;
            $loading_entries = DB::select("SELECT SUM(loading_entry_details.qty) AS qty FROM loading_entries LEFT JOIN loading_entry_details ON loading_entries.id = loading_entry_details.loadingEntryId WHERE loading_entries.partyId = $partyId AND loading_entry_details.unitId = $munit->id AND loading_entries.date <= '$date'");    
            foreach($loading_entries as $le){
                $qty = isset($le->qty)?$le->qty:0;
                $LEARRAY = array_merge($LEARRAY, [$unitName=>$qty]);
            } 
        }


        $CCRARRAY = [];        
        foreach ($master_units as $munit) {            
            $unitName = $munit->name;           
            $customer_carret_receives = DB::select("SELECT SUM(qty+discount) AS qty FROM customer_carret_receives WHERE companyId = 1 AND partyId = $partyId AND unitId = $munit->id AND date <= '$date'");    
            foreach($customer_carret_receives as $ccr){
                $qty = isset($ccr->qty)?$ccr->qty:0;
                $CCRARRAY = array_merge($CCRARRAY, [$unitName=>$qty]);
            } 
        }

        
        $SCRARRAY = [];
        foreach ($master_units as $munit) {
            $unitName = $munit->name;
            array_push($unitNameArray, $unitName);
            $supplier_carret_returns = DB::select("SELECT SUM(qty+discount) AS qty FROM supplier_carret_returns WHERE companyId = 1 AND partyId = $partyId AND unitId = $munit->id AND date <= '$date'");    
            foreach($supplier_carret_returns as $scr){
                $qty = isset($scr->qty)?$scr->qty:0;
                $SCRARRAY = array_merge($SCRARRAY, [$unitName=>$qty]);
            } 
        }

        
        $unitArray1 = array($OUARRAY, $CSARRAY, $PEARRAY, $LEARRAY);
        $unitArray2 = array($CCRARRAY, $SCRARRAY);
        
        // echo '<pre>';
        // print_r($unitArray1);
        // print_r($unitArray2);
        // echo '</pre>';
        $counArray = sizeof($unitNameArray);
        
        // echo array_sum(array_column($unitArray1, 'TMN'));
        $carretWithQty = '';
        for($i=0;$i<$counArray;$i++){
            $comma = '';
            if($i<$counArray-1){
                $comma = ',';
            }
            $cr = array_sum(array_column($unitArray1, $unitNameArray[$i]));
            $dr = array_sum(array_column($unitArray2, $unitNameArray[$i]));
            $bal = $cr - $dr ." ";
            if ($bal !=0) {
                $carretWithQty .= $unitNameArray[$i]." : ".$bal.$comma." ";   
            }    
        }
        
        return $carretWithQty;


    }



}
