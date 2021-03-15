<?php

namespace App\Http\Controllers;

use App\Models\CustomerCarretReceive;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;

class CustomerCarretReceiveController extends Controller
{
    public $companyId;

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->companyId = Session::get('companyId');   
            return $next($request);
        });
    }
    
    public function create()
    {
        return view('customer-carret-receive');
    }

    
    public function AddReceiveCarret(Request $request)
    {
        $carretReceiveId = $request->carretReceiveId;   

        $data = $request->all();
        $userId = Auth::id();
        $clentIp = $request->ip();  
        $data['date'] = date('Y-m-d', strtotime($request->date));      
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['discount'] = isset($request->discount)?$request->discount:0;
        $data['companyId'] = $this->companyId;
        $data['particular'] = 'CR';
        unset($data['carretReceiveId']);

        if(isset($carretReceiveId)){
            if(DB::table('customer_carret_receives')
            ->where('id', $carretReceiveId)
            ->update($data)){
            return 1;
            }else{
            return 0;
            }
        }else{
            if(DB::table('customer_carret_receives')
            ->insert($data)){
            return 1;
            }else{
            return 0;
            }
        }
    }

    
    public function showCustomerCarretReceive(commonController $cmn)
    {
        $userId = Auth::id();
        $companyId = $this->companyId;

        $where = array(
            'isComplete'=>0,
            'createdById'=>$userId,
            'companyId'=>$companyId
        );

        $customer_carret_receives = DB::table('customer_carret_receives')
        ->where($where)
        ->get();

        $html = '';
        $totalQTY=0;       
        $i=0;
        foreach($customer_carret_receives as $row){
            $i++;
            $customerName = $cmn->getValue('master_customer_suppliers','name','id',$row->partyId);
            $unitName = $cmn->getValue('master_units','name','id',$row->unitId);
            $totalQTY += $row->qty;
            $html .='
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.date('d-m-Y', strtotime($row->date)).'</td>
                        <td>'.$customerName.'</td>
                        <td>'.$unitName.'</td>
                        <td>'.$row->qty.'</td>
                        <td>'.$row->discount.'</td>
                        <td>'.$row->narration.'</td>                        
                        <td>
                        <span style="cursor:pointer;" onclick="ReceiveCarretEdit('.$row->id.')" class="label label-success"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>

                        <span style="cursor:pointer;" onclick="ReceiveCarretDelete('.$row->id.')" class="label label-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</span>

                        </td>
                    </tr>
            ';
        }

        $resultArray = [$html, $totalQTY];
        return $resultArray;
    }

   
    public function ReceiveCarretEdit(Request $request)
    {
        $customer_carret_receives = DB::table('customer_carret_receives')
        ->where('id', $request->id)
        ->first();
        return json_encode($customer_carret_receives);
    }

    
    public function reportCustomerCarretReceive(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $companyId = $this->companyId;

        $customer = DB::table('master_customer_suppliers')
        ->select(array('id', 'name'))
        ->where(['customer'=>1, 'companyId'=>1])
        ->orderBy('id', 'DESC')
        ->get();
    //    dd($request->all());  
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
       

        if($status==false){
            $condition .= " AND date='$date'";
        }

        
        $customer_carret_receives = DB::select("SELECT * FROM `customer_carret_receives` WHERE $condition");      

        // dd("SELECT * FROM `customer_carret_receives` WHERE $condition");
        return view('report-customer-carret-receive', ['customer_carret_receives'=>$customer_carret_receives, 'customer'=>$customer]);
    }


    public function submitCustomerCarretReceive(Request $request)
    {
        $userId = Auth::id();
        $myArray = array(
            'isComplete'=>1
        );
        $where = array(
            'createdById'=>$userId,
            'isComplete'=>0
        );

        DB::table('customer_carret_receives')
        ->where($where)
        ->update($myArray);

        session()->flash('success', 'Record Submitted Successfully');
        return Redirect('/customer-carret-receive');
    }

    
    public function destroy(CustomerCarretReceive $customerCarretReceive)
    {
        //
    }
}
