<?php

namespace App\Http\Controllers;

use App\Models\SupplierCarretReturn;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class SupplierCarretReturnController extends Controller
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
        return view('supplier-carret-returns');
    }

    public function AddCarretReturn(Request $request)
    {
        $data = $request->all();
        $CarretReturnId = $request->CarretReturnId;

        $userId = Auth::id();
        $clentIp = $request->ip();        
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;
        $data['particular'] = 'DR';
        $data['discount'] = isset($request->discount)?$request->discount:0;
        $data['date'] = date('Y-m-d', strtotime($request->date));
        unset($data['CarretReturnId']);
        

        if(isset($CarretReturnId)){
            if(DB::table('supplier_carret_returns')
            ->where('id', $CarretReturnId)
            ->update($data)){
            return 1;
            }else{
            return 0;
            }
        }else{
            if(DB::table('supplier_carret_returns')
            ->insert($data)){
            return 1;
            }else{
            return 0;
            }
        }

        
    }

    public function showSupplierCarretReturn(commonController $cmn)
    {
        $userId = Auth::id();
        $companyId = $this->companyId;

        $where = array(
            'isComplete'=>0,
            'createdById'=>$userId,
            'companyId'=>$companyId
        );

        $customer_carret_receives = DB::table('supplier_carret_returns')
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
                        <td>'.$row->vehicleNumber.'</td>
                        <td>'.$row->driverMobile.'</td>                        
                        <td>
                        <span style="cursor:pointer;" onclick="CarretReturntEdit('.$row->id.')" class="label label-success"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>

                        <span style="cursor:pointer;" onclick="CarretReturnDelete('.$row->id.')" class="label label-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</span>

                        </td>
                    </tr>
            ';
        }

        $resultArray = [$html, $totalQTY];
        return $resultArray;
    }

    
    public function submitCarretReturn(Request $request)
    {
        $userId = Auth::id();
        $myArray = array(
            'isComplete'=>1
        );
        $where = array(
            'createdById'=>$userId,
            'isComplete'=>0
        );

        DB::table('supplier_carret_returns')
        ->where($where)
        ->update($myArray);

        session()->flash('success', 'Record Submitted Successfully');
        return Redirect('supplier-carret-returns');
    }

    
    public function reportSupplierCarretReturns(Request $request, SupplierCarretReturn $supplierCarretReturn)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $companyId = $this->companyId;

        $supplier = DB::table('master_customer_suppliers')
        ->select(array('id', 'name'))
        ->where(['supplier'=>1, 'companyId'=>1])
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

        
        $supplier_carret_returns = DB::select("SELECT * FROM `supplier_carret_returns` WHERE $condition");      

        // dd("SELECT * FROM `supplier_carret_returns` WHERE $condition");
        return view('report-supplier-carret-returns', ['supplier_carret_returns'=>$supplier_carret_returns, 'supplier'=>$supplier]);
    }

    
    public function CarretReturntEdit(Request $request, SupplierCarretReturn $supplierCarretReturn)
    {
        $supplier_carret_returns = DB::table('supplier_carret_returns')
        ->where('id', $request->id)
        ->first();
        return json_encode($supplier_carret_returns);
    }

    
    public function update(Request $request, SupplierCarretReturn $supplierCarretReturn)
    {
        //
    }

    
    public function destroy(SupplierCarretReturn $supplierCarretReturn)
    {
        //
    }

    
}
