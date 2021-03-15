<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;



class LoadingEntryController extends Controller
{
    
    public $companyId;

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->companyId = Session::get('companyId');   
            return $next($request);
        });
    }

    public function create(Request $request)
    {
        return view('loading_entries');
    }


    public function AddLoadingEntryDetails(Request $request)
    {
        $data = $request->all();
        $companyId = $this->companyId;

        unset($data['loadingEntryDetailsId']);
        unset($data['loadingEntryId']);

        $userId = Auth::id();
        $clentIp = $request->ip();        
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $companyId;

        if(!empty($request->loadingEntryDetailsId)){

            if(DB::table('loading_entry_details')
            ->where('id', $request->loadingEntryDetailsId)
            ->update($data)){
                return 1;
            }else{
                return 0;
            }

        }else{
            $data['loadingEntryId'] = $request->loadingEntryId;
            if(DB::table('loading_entry_details')
            ->insert($data)){
                return 1;
            }else{
                return 0;
            }

        }

        

    }



    public function showLoadingEntryDetails(commonController $cmn)
    {
        $userId = Auth::id();
        $companyId = $this->companyId;

        $where = array(
            'loadingEntryId'=>0,
            'createdById'=>$userId,
            'companyId'=>$companyId
        );

        $loading_entry_details = DB::table('loading_entry_details')
        ->where($where)
        ->get();

        $html = '';
        $totalAmount=0;
        $i=0;
        foreach($loading_entry_details as $row){
            $i++;
            $itemName = $cmn->getValue('master_items','name','id',$row->itemId);
            $unitName = $cmn->getValue('master_units','name','id',$row->unitId);
            $totalAmount += $row->amount;
            $html .='
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$itemName.'</td>
                        <td>'.$row->rate.'</td>
                        <td>'.$unitName.'</td>
                        <td>'.$row->qty.'</td>                        
                        <td>'.$row->weight.'</td>                        
                        <td>'.$row->amount.'</td>
                        <td>

                        <span style="cursor:pointer;" onclick="loadingEntryDetailsEdit('.$row->id.')" class="label label-success"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>

                        <span style="cursor:pointer;" onclick="loadingEntryDetailsDelete('.$row->id.')" class="label label-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</span>

                        </td>
                    </tr>
            ';
        }

        $resultArray = [$html, $totalAmount];
        return $resultArray;


    }



    public function loadingEntryDetailsEdit(Request $request)
    {
        $id = $request->id;
        $loading_entry_details = DB::table('loading_entry_details')
        ->where('id', $id)
        ->first();
        return json_encode($loading_entry_details);

    }



    public function submitLoadingEntryData(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'partyId' => 'required',
            'vehicleNumber' => 'required',
            'farmerId' => 'required'
        ]);

        $data = $request->all();
        $loadingEntryId = $request->loadingEntryId;
        
        $companyId = $this->companyId;       

        unset($data['_token']);  
        unset($data['loadingEntryId']);    
        unset($data['loadingEntryDetailsId']);  
            // dd($data);
        $userId = Auth::id();
        $clentIp = $request->ip();        
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $companyId;
        $data['particular'] = 'Loading';
        $msg = '';
        if ($loadingEntryId != 0) {
            
            $insertGetId = DB::table('loading_entries')
            ->where('id', $loadingEntryId)
            ->update($data);
            // DB::table('loading_entry_details')
            // ->where(['companyId'=>$companyId, 'createdById'=>$userId, 'loadingEntryId'=>0])
            // ->update(['loadingEntryId'=>$insertGetId]);
            $msg = 'Data Updated Successfully';
        }else{

            $insertGetId = DB::table('loading_entries')
            ->insertGetId($data);

            DB::table('loading_entry_details')
            ->where(['companyId'=>$companyId, 'createdById'=>$userId, 'loadingEntryId'=>0])
            ->update(['loadingEntryId'=>$insertGetId]);
            $msg = 'Data Submitted Successfully';

        }     

        $request->session()->flash('success', $msg);
        return Redirect('/loading_entries');
    }



    public function loadingEntriesReport(Request $request)
    {

        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');

        $companyId = $this->companyId;

        $loader = DB::table('master_customer_suppliers')
        ->where(['companyId'=>$companyId, 'loader'=>1, 'status'=>'Active'])
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

        if(!empty($request->status)){
            if($request->status=='Pending'){
                $condition .= " AND netAmount = 0";
                $status = true;
            }
            if($request->status=='Complete'){
                $condition .= " AND netAmount != 0";
                $status = true;
            }            
        }

        if($status==false){
            $condition .= " AND date='$date'";
        }


        $loading_entries = DB::select("SELECT * FROM `loading_entries` WHERE $condition ORDER BY id DESC");
        return view('report-loading-entries', ['loading_entries'=>$loading_entries, 'loader'=>$loader]);

    }


    public function loadingEntryDelete(Request $request)
    {
        $id = $request->id;

        DB::table('loading_entries')
        ->where('id', $id)
        ->delete();

        DB::table('loading_entry_details')
        ->where('loadingEntryId', $id)
        ->delete();

        $request->session()->flash('success', 'Record Deleted Successfully');
        return Redirect::back();

    }




    public function loadingEntryEdit(commonController $cmn, Request $request)
    {
        $id = $request->id;

        $loading_entry_details = DB::table('loading_entry_details')
        ->where('loadingEntryId', $id)
        ->get();

        $html_loading_entry_details = '';
        $totalAmount=0;
        $i=0;
        foreach($loading_entry_details as $row){
            $i++;
            $itemName = $cmn->getValue('master_items','name','id',$row->itemId);
            $unitName = $cmn->getValue('master_units','name','id',$row->unitId);
            $totalAmount += $row->amount;
            $html_loading_entry_details .='
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$itemName.'</td>
                        <td>'.$row->rate.'</td>
                        <td>'.$unitName.'</td>
                        <td>'.$row->qty.'</td>                        
                        <td>'.$row->weight.'</td>                        
                        <td>'.$row->amount.'</td>
                        <td>

                        <span style="cursor:pointer;" onclick="loadingEntryDetailsEdit('.$row->id.')" class="label label-success"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>

                        <span style="cursor:pointer;" onclick="loadingEntryDetailsDelete('.$row->id.')" class="label label-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete</span>

                        </td>
                    </tr>
            ';
        }

        $resultArray = [$html_loading_entry_details, $totalAmount];
        return json_encode($resultArray);

    }



}
