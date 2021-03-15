<?php

namespace App\Http\Controllers;

use App\Models\CustomerSale;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;
use App;
use PDF;

class CustomerSaleController extends Controller
{
    public $companyId;

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->companyId = Session::get('companyId');   
            return $next($request);
        });
    }    

    public function getValue($table,$column,$key,$value)
    {
        $result = DB::table($table)
          ->where($key, '=', $value)
          ->orderBy('id','asc')
          ->value($column);
        return $result;
    }

    
    public function index()
    {        
        return view('customer-sale');
    }

    

    public function GetItemLock(Request $request)
    {
        $id = $request->itemid;
        $lock = DB::table('master_items')->where('id', $id)->value('lock');        
        return $lock;
    }

    public function ItemLockUpdate(Request $request)
    {
        $item = $request->item;
        $lock = $request->lock;
        if(DB::table('master_items')
        ->where('id', $item)
        ->update(['lock'=>$lock])){
            return 'SUCCESS';
        }else{
            return 'FAIL';
        } 
    }

    
    public function submitAddItems(Request $request)
    {
        $userId = Auth::id();
        $clentIp = $request->ip(); 

        $customerSaleId = $request->customerSaleId;       


        $myArray = array(
            'date' => date('Y-m-d', strtotime($request->date)),
            'farmerId' => $request->farmerId,
            'itemId' => $request->itemId,
            'rate' => $request->rate,
            'unitId' => $request->unitId,
            'partyId' => $request->customerId,
            'weight' => $request->weight,
            'qty' => $request->qty,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'companyId' => $this->companyId,
            'createdById' => $userId,
            'ipAddress' => $clentIp,
            'session' => '2021',
            'particular' => 'Sale'
        );

        if(isset($customerSaleId)){
            if(DB::table('customer_sales')
            ->where('id', $customerSaleId)
            ->update($myArray)){
            return 1;
            }else{
            return 0;
            }
        }else{
            if(DB::table('customer_sales')
            ->insert($myArray)){
            return 1;
            }else{
            return 0;
            }
        }

        
    }

   

    public function showCustomerSaleTableData(CustomerSale $customerSale)
    {
        $userId = Auth::id();
        $companyId = $this->companyId;

        $where = array(
            'isComplete'=>0,
            'createdById'=>$userId,
            'companyId'=>$companyId
        );

        $customer_sales = DB::table('customer_sales')
        ->orderBy('id', 'DESC')
        ->where($where)
        ->get();

        $html = '';
        $tableBody = '';
        $totalAmount=0;
        $totalQTY = 0;
        $totalKG = 0;
        $i=0;
        foreach($customer_sales as $row){
            $i++;
            $itemName = $this->getValue('master_items','name','id',$row->itemId);
            $customerName = $this->getValue('master_customer_suppliers','name','id',$row->partyId);
            $unit = $this->getValue('master_units','name','id',$row->unitId);
            $totalAmount += $row->amount;
            $totalQTY += $row->qty;
            $totalKG += $row->weight;
            $tableBody .='
                    <tr>
                        <td onclick="rowHighLight(this)">'.$i.'</td>
                        <td onclick="rowHighLight(this)">'.$itemName.'</td>
                        <td onclick="rowHighLight(this)">'.$row->qty.'</td>
                        <td onclick="rowHighLight(this)">'.$unit.'</td>
                        <td onclick="rowHighLight(this)">'.$row->weight.'</td>
                        <td onclick="rowHighLight(this)">'.$row->rate.'</td>                        
                        <td onclick="rowHighLight(this)">'.$row->remark.'</td>
                        <td onclick="rowHighLight(this)">'.$customerName.'</td>
                        <td onclick="rowHighLight(this)">'.$row->amount.'</td>
                        <td onclick="rowHighLight(this)">

                        <span onclick="custumerSaleEdit('.$row->id.')" class="btn btn-success"><i class="fa fa-pencil" aria-hidden="true"></i></span>

                        <span onclick="deleteRecord('.$row->id.')" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></span>

                        </td>
                    </tr>
            ';
        }

        

        $resultArray = [$tableBody, $totalQTY, $totalKG, $totalAmount];
        return $resultArray;


    }


    public function customerSaleEdit(Request $request)
    {
        $id = $request->id;
        $customer_sales = DB::table('customer_sales')
        ->where('id', $id)
        ->first();
        return json_encode($customer_sales);
    }


    public function submitCustomerSaleData(Request $request)
    {
        $userId = Auth::id();
        $myArray = array(
            'isComplete'=>1
        );
        $where = array(
            'createdById'=>$userId,
            'isComplete'=>0
        );

        DB::table('customer_sales')
        ->where($where)
        ->update($myArray);

        session()->flash('success', 'Record Submitted Successfully');
        return Redirect('/customer-sale');

    }


    public function customerSaleReport(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $companyId = $this->companyId;

        $supplier = DB::table('master_customer_suppliers')
        ->select(array('id', 'name'))
        ->where(['supplier'=>1, 'companyId'=>$companyId])
        ->orderBy('id', 'DESC')
        ->get();        

        $customer = DB::table('master_customer_suppliers')
        ->select(array('id', 'name'))
        ->where(['customer'=>1, 'companyId'=>$companyId])
        ->orderBy('id', 'DESC')
        ->get();
       
        $condition = "companyId=".$companyId." AND isComplete=1";
        $status = false;
        if(!empty($request->fromDate) && !empty($request->toDate)){
            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            $condition .= " AND date BETWEEN '$fromDate' AND '$toDate'";
            $status = true;

        }

        if(!empty($request->partyId)){
            $condition .= " AND partyId=".$request->partyId;
            $status = true;
        }

        if(!empty($request->farmerId)){
            $condition .= " AND farmerId=".$request->farmerId;
            $status = true;
        }

        if($status==false){
            $condition .= " AND date='$date'";
        }           

        
        $customer_sales = DB::select("SELECT date, partyId, SUM(qty) AS qty, unitId, SUM(amount) AS amount FROM `customer_sales` WHERE $condition GROUP BY date, partyId");      

        // dd("SELECT billDate, customerId, SUM(amount) AS amount FROM `customer_sales` WHERE $condition GROUP BY billDate, customerId");
        // return $customer_sales;
        return view('report-customer-sales', ['customer_sales'=>$customer_sales, 'supplier'=>$supplier, 'customer'=>$customer]);
        
    }


    public function customerSaleReportDetails(Request $request)
    {
        $date = $request->date;
        $customerId = $request->partyId;
        $customer_sales = DB::table('customer_sales')
        ->where(['isComplete'=>1, 'date'=>$date, 'partyId'=>$customerId])
        ->get();

            $master_customer_suppliers = DB::table('master_customer_suppliers')
            ->where('id', $request->partyId)
            ->first();
            
            if($master_customer_suppliers->customer == '1'){
            $partType = 'customerRate';
            }
            if($master_customer_suppliers->supplier == '1'){
            $partType = 'supplierRate';
            }

        return view('report-customer-sales-details', ['customer_sales'=>$customer_sales, 'partType'=>$partType]);
    }

   
    public function destroy(CustomerSale $customerSale)
    {
        //
    }


}
