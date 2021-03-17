<?php

namespace App\Http\Controllers;

use App\Models\PaymentReceive;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class PaymentReceiveController extends Controller
{

    public $companyId;

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->companyId = Session::get('companyId');   
            return $next($request);
        });
    }

    
    public function index()
    {
        //
    }

    
    public function create()
    {
        
        return view('payment-receive');
    }

   
    public function AddPayment(Request $request)
    {
        $paymentId = $request->paymentId;   

        $data = $request->all();
        $userId = Auth::id();
        $clentIp = $request->ip();  
        $data['date'] = date('Y-m-d', strtotime($request->date));      
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;
        $data['particular'] = 'Recept';
        unset($data['paymentId']);

        if(isset($paymentId)){
            if(DB::table('customer_sales_payment_receives')
            ->where('id', $paymentId)
            ->update($data)){
            return 1;
            }else{
            return 0;
            }
        }else{
            if(DB::table('customer_sales_payment_receives')
            ->insert($data)){
            return 1;
            }else{
            return 0;
            }
        }
        
    }


    public function paymentUpdate($id, Request $request)
    {
        $data = $request->all();

        unset($data['_token']);

        if(DB::table('customer_sales_payment_receives')
            ->where('id', $id)
            ->update($data)){
            $request->session()->flash('success', 'Record Updated Sucessfully');
            return Redirect::back();
            }else{
            $request->session()->flash('error', 'something went wrong');
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

        $customer_sales_payment_receives = DB::table('customer_sales_payment_receives')
        ->where($where)
        ->get();

        $html = '';
        $totalAmount=0;
        $totalDiscount=0;
        $totalPay=0;
        $i=0;
        foreach($customer_sales_payment_receives as $row){
            $i++;
            $customerName = $cmn->getValue('master_customer_suppliers','name','id',$row->partyId);
            $totalAmount += $row->amount;
            $totalDiscount += $row->discount;
            $totalPay = $totalAmount-$totalDiscount;

            $printA6Hi = route("PdfPaymentA6Hindi")."?date=".$row->date."&customerId=".$row->partyId;
            $printA6En = route("PdfPaymentA6")."?date=".$row->date."&customerId=".$row->partyId;

            $html .='
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.date('d-m-Y', strtotime($row->date)).'</td>
                        <td>'.$customerName.'</td>
                        <td>'.$row->amount.'</td>
                        <td>'.$row->discount.'</td>
                        <td>'.$row->narration.'</td>                        
                        <td>
                        <a href="'.$printA6En.'" target="_blank" class="btn btn-primary" rel="tooltip" title="Delete">
                        <b>A6</b>
                        </a>

                        <a href="'.$printA6Hi.'" target="_blank" class="btn btn-warning" rel="tooltip" title="Delete">
                        <b>A6</b>
                        </a>

                        <span style="cursor:pointer;" onclick="paymentEdit('.$row->id.')" class="btn btn-success"><b>E</b></span>

                        <span style="cursor:pointer;" onclick="deleteRecord('.$row->id.')" class="btn btn-danger"><b>X</b></span>
                        </td>
                    </tr>
            ';
        }

        $amountDetails = 'Total Amount = '.$totalAmount.' | Total Discount = '.$totalDiscount.' | Total Pay = '.$totalPay;
        $resultArray = [$html, $amountDetails];
        return $resultArray;
    }

   
    public function paymentEdit(Request $request)
    {
        $result = DB::table('customer_sales_payment_receives')->where('id', $request->id)->first();
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

        DB::table('customer_sales_payment_receives')
        ->where($where)
        ->update($myArray);

        session()->flash('success', 'Record Submitted Successfully');
        return Redirect('/payment-receive');
    }


    public function reportPaymentReceive(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $companyId = $this->companyId;

        $customer = DB::table('master_customer_suppliers')
        ->select(array('id', 'name'))
        ->where(['customer'=>1, 'companyId'=>$this->companyId])
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

        
        $customer_sales_payment_receives = DB::select("SELECT date, partyId, SUM(amount) AS amount, SUM(discount) AS discount FROM customer_sales_payment_receives WHERE $condition GROUP BY date, partyId");      

        // dd("SELECT date, customerId, SUM(amount) AS amount, discount FROM customer_sales_payment_receives WHERE $condition GROUP BY date, customerId");
        return view('report-payment-receive', ['customer_sales_payment_receives'=>$customer_sales_payment_receives, 'customer'=>$customer]);
    }


    public function paymentReceiveReportDetails(Request $request)
    {
        $date = $request->date;
        $customerId = $request->customerId;
        $customer_sales_payment_receives = DB::table('customer_sales_payment_receives')
        ->where(['isComplete'=>1, 'date'=>$date, 'partyId'=>$customerId])
        ->get();
        return view('report-payment-receive-details', ['customer_sales_payment_receives'=>$customer_sales_payment_receives]);
    }

    
    public function destroy(PaymentReceive $paymentReceive)
    {
        //
    }
}
