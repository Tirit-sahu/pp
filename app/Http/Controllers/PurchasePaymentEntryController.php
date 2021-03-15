<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;



class PurchasePaymentEntryController extends Controller
{

    public $companyId;

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->companyId = Session::get('companyId');   
            return $next($request);
        });
    }
    

    public function purchasePaymentEntries(Request $request)
    {   
        return view('purchase-payment-entries');
    }


   
    public function AddPurchasePayment(Request $request)
    {
        $paymentId = $request->paymentId;   

        $data = $request->all();
        $userId = Auth::id();
        $clentIp = $request->ip();  
        $data['date'] = date('Y-m-d', strtotime($request->date));      
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;
        $data['particular'] = 'Payment';
        $data['discount'] = isset($data->discount)?$data->discount:0;
        unset($data['paymentId']);

        if(isset($paymentId)){
            if(DB::table('purchase_payment_entries')
            ->where('id', $paymentId)
            ->update($data)){
            return 1;
            }else{
            return 0;
            }
        }else{
            if(DB::table('purchase_payment_entries')
            ->insert($data)){
            return 1;
            }else{
            return 0;
            }
        }
        
    }


    public function purchasePaymentUpdate($id, Request $request)
    {
        $data = $request->all();
        unset($data['_token']);

        if(DB::table('purchase_payment_entries')
            ->where('id', $id)
            ->update($data)){
            $request->session()->flash('success', 'Record Updated Successfully');
            return Redirect::back();
            }else{
                $request->session()->flash('error', 'Something went wrong');
                return Redirect::back();
            }
    }

    
    public function showPaymentTableData(commonController $cmn)
    {
        $userId = Auth::id();
        $companyId = $this->companyId;

        $where = array(
            'isComplete'=>0,
            'createdById'=>$userId,
            'companyId'=>$companyId
        );

        $purchase_payment_entries = DB::table('purchase_payment_entries')
        ->where($where)
        ->get();

        $html = '';
        $totalAmount=0;
        $totalDiscount=0;
        $totalPay=0;
        $i=0;
        foreach($purchase_payment_entries as $row){
            $i++;
            $supplierName = $cmn->getValue('master_customer_suppliers','name','id',$row->partyId);
            $totalAmount += $row->amount;
            $totalDiscount += $row->discount;
            $totalPay = $totalAmount-$totalDiscount;
            $html .='
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.date('d-m-Y', strtotime($row->date)).'</td>
                        <td>'.$supplierName.'</td>
                        <td>'.$row->amount.'</td>
                        <td>'.$row->discount.'</td>
                        <td>'.$row->narration.'</td>                        
                        <td>
                        <span style="cursor:pointer;" onclick="paymentEdit('.$row->id.')" class="label label-success"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>

                        <span style="cursor:pointer;" onclick="deleteRecord('.$row->id.')" class="label label-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</span>

                        </td>
                    </tr>
            ';
        }

        $amountDetails = 'Total Amount = '.$totalAmount.' | Total Discount = '.$totalDiscount.' | Total Pay = '.$totalPay;
        $resultArray = [$html, $amountDetails];
        return $resultArray;
    }

   
    public function purchasePaymentEdit(Request $request)
    {
        $result = DB::table('purchase_payment_entries')->where('id', $request->id)->first();
        return json_encode($result);
    }

    
    public function submitPayment(Request $request)
    {
        $userId = Auth::id();
        $myArray = array(
            'isComplete'=>1
        );
        $where = array(
            'createdById'=>$userId,
            'isComplete'=>0
        );

        DB::table('purchase_payment_entries')
        ->where($where)
        ->update($myArray);

        session()->flash('success', 'Record Submitted Successfully');
        return Redirect('/purchase-payment-entries');
    }


    public function reportPurchasePaymentEntries(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $companyId = $this->companyId;

        $supplier = DB::table('master_customer_suppliers')
        ->select(array('id', 'name'))
        ->where(['supplier'=>1, 'companyId'=>$companyId])
        ->orderBy('id', 'DESC')
        ->get();
       
        $condition = "companyId=".$companyId;
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

        if($status==false){
            $condition .= " AND date='$date'";
        }

        
        $purchase_payment_entries = DB::select("SELECT date, partyId, SUM(amount) AS amount, discount FROM purchase_payment_entries WHERE $condition GROUP BY date, partyId");      

        // dd($purchase_payment_entries);

        return view('report-purchase-payment-entries', ['purchase_payment_entries'=>$purchase_payment_entries, 'supplier'=>$supplier]);
    }


    public function paymentReceiveReportDetails(Request $request)
    {
        $date = $request->date;
        $supplierId = $request->partyId;
        $purchase_payment_entries = DB::table('purchase_payment_entries')
        ->where(['isComplete'=>1, 'date'=>$date, 'partyId'=>$supplierId])
        ->get();
        return view('report-purchase-payment-entries-details', ['purchase_payment_entries'=>$purchase_payment_entries]);
    }

    
    public function destroy(PaymentReceive $paymentReceive)
    {
        //
    }



}
