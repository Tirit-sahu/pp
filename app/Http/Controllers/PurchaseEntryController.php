<?php

namespace App\Http\Controllers;

use App\Models\PurchaseEntry;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class PurchaseEntryController extends Controller
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
        return view('purchase-entry');
    }

   
    public function AddPurchaseEntryDetails(Request $request)
    {
        $data = $request->all();

        $purchaseEntryDetailId = $request->purchaseEntryDetailId;
        $pid = $request->pid;

        unset($data['purchaseEntryDetailId']);
        unset($data['pid']);
        $userId = Auth::id();
        $clentIp = $request->ip();       


        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;

        if(!empty($purchaseEntryDetailId)){
            if(DB::table('purchase_entry_details')
            ->where('id', $purchaseEntryDetailId)
            ->update($data)){
            return 1;
            }else{
            return 0;
            }
        }else{
            $data['purchaseEntryId'] = $pid;
            if(DB::table('purchase_entry_details')
            ->insert($data)){
            return 1;
            }else{
            return 0;
            }
        }



    }

    
    public function showPurchaseEntryDetails(commonController $cmn)
    {
        $userId = Auth::id();
        $companyId=$this->companyId;

        $where = array(
            'purchaseEntryId'=>0,
            'createdById'=>$userId,
            'companyId'=>$companyId
        );

        $purchase_entry_details = DB::table('purchase_entry_details')
        ->where($where)
        ->get();
        
        $html = '';
        $tbody = '';
        $i=0;
        $totalAmt = 0;

        foreach($purchase_entry_details as $row){
            $i++;
            $totalAmt += $row->amount; 

            $itemName = $cmn->getValue('master_items','name','id',$row->itemId);
            $unitName = $cmn->getValue('master_units','name','id',$row->unitId);

            $tbody .= '
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$row->biltyNo.'</td>
                    <td>'.$itemName.'</td>
                    <td>'.$row->rate.'</td>
                    <td>'.$unitName.'</td>
                    <td>'.$row->qty.'</td>
                    <td>'.$row->weight.'</td>
                    <td>'.$row->amount.'</td>
                    <td>
                    <span style="cursor:pointer;" onclick="purchaseDetailsEdit('.$row->id.')" class="label label-success"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>

                    <span style="cursor:pointer;" onclick="purchaseDetailsDelete('.$row->id.')" class="label label-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</span>
                    </td>
                </tr>
            ';

        }

        $tfoot = '
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>                                        
                <th></th>
                <th></th>                                        
                <th id="purchaseDetailsTotalAmt">'.$totalAmt.'</th>
                <th></th>
            </tr>
        ';


        $html = '
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SNO.</th>
                    <th>Bilty No.</th>
                    <th>Item Name</th>
                    <th>Rate</th>
                    <th>Unit</th>
                    <th>QTY</th>                                        
                    <th>KG/Unit</th>                                        
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            
            <tbody>                               
                '.$tbody.'
            </tbody>
            
            <tfoot>
                '.$tfoot.'
            </tfoot>
       
        </table>
        ';

        return $html;
        

    }

    
    public function purchaseDetailsEdit(Request $request, PurchaseEntry $purchaseEntry)
    {
        $id = $request->id;
        $purchase_entry_details = DB::table('purchase_entry_details')
        ->where('id', $id)
        ->first();
        return json_encode($purchase_entry_details);

    }

    
    public function AddPurchaseEntryExpenses(Request $request, PurchaseEntry $purchaseEntry)
    {
        $data = $request->all();

        $companyId = $this->companyId;
        $userId = Auth::id();
        $clentIp = $request->ip();       

        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $companyId;
        $data['purchaseEntryId'] = $request->pid;
        unset($data['pid']);

        if(DB::table('purchase_entry_expenses')
        ->insert($data)){
            return 1;
        }else{
            return 0;
        }

    }

    
    public function getExpensesType(Request $request, PurchaseEntry $purchaseEntry)
    {
        $master_addtional_expenses = DB::table('master_addtional_expenses')
        ->where('id', $request->id)
        ->first();
        return json_encode($master_addtional_expenses);
    }


    public function ShowPurchaseEntryExpenses(commonController $cmn)
    {
        $companyId = $this->companyId;
        $userId = Auth::id();

        $where = array(
            'companyId'=>$companyId,
            'purchaseEntryId'=>0,
            'createdById'=>$userId
        );
        
        $purchanseDetailsSum=DB::table('purchase_entry_details')
        ->where('purchaseEntryId','0')
        ->sum('amount');

       $purchase_entry_expenses = DB::table('purchase_entry_expenses')
        ->where($where)
        ->get();

        $tbody='';
        $totalAmt = 0;
        foreach($purchase_entry_expenses as $row){
            
            if($row->type=='Percentage'){
               $amount= $purchanseDetailsSum*$row->amount/100;
            }else{
                $amount= $row->amount;  
            }

             

            if($row->process=='Subtract')
            {
                $totalAmt -= $amount;

            }else if($row->process=='Add'){
                $totalAmt += $amount;
            }else{
                
                $totalAmt; 
            }

            $addExpName = $cmn->getValue('master_addtional_expenses','name','id',$row->masterAddtionalExpensesId);
            $tbody .= '
                <tr>
                    <td>'.$addExpName.'</td>
                    <td>'.$row->type.'</td>
                    <td>'.$row->process.'</td>
                    <td>'.$amount.'</td>                   
                    <td>
                    <span style="cursor:pointer;" onclick="purchaseEntryExpensesDelete('.$row->id.')" class="label label-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</span>
                    </td>
                </tr>               

            ';

        }

        $tbody .= '
        <tr>
        <th>Total:</th>
        <th></th>
        <th></th>
        <th id="TotalExpenseAmt">'.$totalAmt.'</th>                   
        <th></th>
        </tr>
        ';


        return $tbody;



    }


    public function submitPurchaseEntryForm(Request $request)
    {
        $request->validate([
            'supplierId'=>'required',
            'purchaseDate'=>'required',
            'vehicleNumber'=>'required'
        ]);


        $userId = Auth::id();
        $clentIp = $request->ip(); 

        $myArray = array(
            'partyId'=>$request->supplierId,
            'date'=>date('Y-m-d', strtotime($request->purchaseDate)),
            'vehicleNumber'=>$request->vehicleNumber,
            'billPrintName'=>$request->billPrintName,
            'narration'=>$request->narration,
            'expenseAmt'=>$request->expenseAmt,
            'otherChargesAmt'=>$request->otherChargesAmt,
            'totalAmt'=>$request->totalAmt,
            'createdById'=>$userId,
            'companyId'=>$this->companyId,
            'ipAddress'=>$clentIp,
            'particular'=>'Bijak'
        );

        if($request->pid==0){
            $insertGetId = DB::table('purchase_entries')
            ->insertGetId($myArray);

            DB::table('purchase_entry_details')
            ->where(['purchaseEntryId'=>0, 'createdById'=>$userId])
            ->update(['purchaseEntryId'=>$insertGetId]);

            DB::table('purchase_entry_expenses')
            ->where(['purchaseEntryId'=>0, 'createdById'=>$userId])
            ->update(['purchaseEntryId'=>$insertGetId]);
        }else{
            DB::table('purchase_entries')
            ->where('id', $request->pid)
            ->update($myArray);

            DB::table('purchase_entry_details')
            ->where(['purchaseEntryId'=>0, 'createdById'=>$userId])
            ->update(['purchaseEntryId'=>$request->pid]);

            DB::table('purchase_entry_expenses')
            ->where(['purchaseEntryId'=>0, 'createdById'=>$userId])
            ->update(['purchaseEntryId'=>$request->pid]);

        }

        

        session()->flash('success', 'Purchase Entry Submitted Successfully');
        return redirect('/purchase-entry');
    }


    public function reportPurchaseEntry(Request $request)
    {

        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $companyId = $this->companyId;        

        $master_customer_suppliers = DB::table('master_customer_suppliers')
        ->where('supplier', 1)
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

        if(!empty($request->billPrintName)){

            $billPrintName = $request->billPrintName;
            if($billPrintName=='Yes'){
                $condition .= " AND billPrintName IS NOT NULL";
            }else{
                $condition .= " AND billPrintName IS NULL";
            }            
            $status = true;
        }

        if($status==false){
            $condition .= " AND date='$date'";
        }

        $purchase_entries = DB::select("SELECT * FROM `purchase_entries` WHERE $condition");
        // dd("SELECT * FROM `purchase_entries` WHERE $condition");
        return view('report-purchase-entry', ['purchase_entries'=>$purchase_entries, 'master_customer_suppliers'=>$master_customer_suppliers]);
           
    }




    public function EDITshowPurchaseEntryDetails(commonController $cmn, Request $request)
    {
        $pid = $request->pid;
        
        $companyId = $this->companyId;

        $where = array(
            'companyId'=>$companyId,
            'purchaseEntryId'=>$pid
        );

       $purchase_entry_expenses = DB::table('purchase_entry_expenses')
        ->where($where)
        ->get();

        $PEE='';
        $totalAmt = 0;
        $add = 0;
        $subtract = 0;
        foreach($purchase_entry_expenses as $row){
            $totalAmt += $row->amount; 
            if($row->process=='Add'){
                $add += $row->amount; 
            }
            if($row->process=='Subtract'){
                $subtract += $row->amount; 
            }
            $totalAmt = $add - $subtract;
            $addExpName = $cmn->getValue('master_addtional_expenses','name','id',$row->masterAddtionalExpensesId);
            $PEE .= '
                <tr>
                    <td>'.$addExpName.'</td>
                    <td>'.$row->type.'</td>
                    <td>'.$row->process.'</td>
                    <td>'.$row->amount.'</td>                   
                    <td>
                    <span style="cursor:pointer;" onclick="purchaseEntryExpensesDelete('.$row->id.')" class="label label-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</span>
                    </td>
                </tr>               

            ';

        }

        $PEE .= '
        <tr>
        <th>Total:</th>
        <th></th>
        <th></th>
        <th id="TotalExpenseAmt">'.$totalAmt.'</th>                   
        <th></th>
        </tr>
        ';



        

        $purchase_entry_details = DB::table('purchase_entry_details')
        ->where($where)
        ->get();
        
        $PED = '';
        $tbody = '';
        $i=0;
        $totalAmt = 0;

        foreach($purchase_entry_details as $row){
            $i++;
            $totalAmt += $row->amount; 

            $itemName = $cmn->getValue('master_items','name','id',$row->itemId);
            $unitName = $cmn->getValue('master_units','name','id',$row->unitId);

            $tbody .= '
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$row->biltyNo.'</td>
                    <td>'.$itemName.'</td>
                    <td>'.$row->rate.'</td>
                    <td>'.$unitName.'</td>
                    <td>'.$row->qty.'</td>
                    <td>'.$row->weight.'</td>
                    <td>'.$row->amount.'</td>
                    <td>
                    <span style="cursor:pointer;" onclick="purchaseDetailsEdit('.$row->id.')" class="label label-success"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>

                    <span style="cursor:pointer;" onclick="purchaseDetailsDelete('.$row->id.')" class="label label-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</span>
                    </td>
                </tr>
            ';

        }

        $tfoot = '
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>     
                <th></th>                                   
                <th></th>                                        
                <th id="purchaseDetailsTotalAmt">'.$totalAmt.'</th>
                <th></th>
            </tr>
        ';


        $PED = '
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SNO.</th>
                    <th>Bilty No.</th>
                    <th>Item Name</th>
                    <th>Rate</th>
                    <th>Unit</th>
                    <th>QTY</th>                                        
                    <th>KG/Unit</th>                                        
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            
            <tbody>                               
                '.$tbody.'
            </tbody>
            
            <tfoot>
                '.$tfoot.'
            </tfoot>
       
        </table>
        ';


        $myArray = array(
            $PED,
            $PEE
        );

        return json_encode($myArray);

    }

    public function purchaseEntryDelete(Request $request)
    {
        DB::table('purchase_entries')
        ->where('id', $request->id)
        ->delete();

        DB::table('purchase_entry_details')
        ->where('purchaseEntryId', $request->id)
        ->delete();

        DB::table('purchase_entry_expenses')
        ->where('purchaseEntryId', $request->id)
        ->delete();

        $request->session()->flash('success', 'Purchase Entry Deleted Successfully');
        return Redirect::back();

    }






}
