<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class customUnitRateController extends Controller
{
    
    public $companyId;

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->companyId = Session::get('companyId');   
            return $next($request);
        });
    }

    public function changeUnitRatePartyWise(Request $request, commonController $c)
    {
        $partyId = $request->partyId;
        $master_units = DB::table('master_units')->where('companyId', $this->companyId)->get();
        $tableBody = '';        
        $sno=0;
        foreach($master_units as $row){
            $sno++;
            $where = ['partyId'=>$partyId,'unitId'=>$row->id];
            $rate = $c->getValueByMultiWhere('custom_unit_rates','rate',$where);
            $tableBody .= '
                    <tr>
                    <td>'.$sno.'</td>
                    <td>'.$row->name.'</td>
                    <td><input name="'.$row->id.'" value="'.$rate.'" type="text" class="form-control"></td>
                    </tr>
            ';
        }

        return $tableBody;

    }


    public function postcustomUnitRate(Request $request)
    {
        $data = $request->all();

        unset($data['partyId']);
        unset($data['_token']);

        $userId = Auth::id();
        $clentIp = $request->ip();  
        
        DB::table('custom_unit_rates')
        ->where(['partyId'=>$request->partyId])
        ->delete();

            foreach($data as $key => $value){
                if($value != '' && $value != 0){
                    $myArray = array(
                        'partyId'=>$request->partyId,
                        'unitId'=>$key,
                        'rate'=>$value,
                        'createdById'=>$userId,
                        'ipAddress'=>$clentIp,
                        'companyId'=>$this->companyId
                    );
                    DB::table('custom_unit_rates')->insert($myArray);
                }
            }
            return 1;
        
        
        
    }



}
