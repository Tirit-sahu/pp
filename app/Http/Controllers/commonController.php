<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class commonController extends Controller
{

    public function invoice_num ($input, $pad_len = 7, $prefix = null) {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);
    
        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
    
        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);

        // $count = DB::table('loading_payments')->count();
        // $vnumber = $this->invoice_num(++$count, 5, "PV");
    }

    public function destroy(Request $request)
    {
        $table = $request->table;
        $key = $request->key;
        $value = $request->value;

        DB::table($table)->where($key, $value)->delete();
        session()->flash('success', "Deleted Successfully.");
        return redirect::back();
        
    }
    


    public function getSelectOption(Request $request){
        $table = $request->table;       
        $id = $request->id;
        $key = $request->key;
        $value = $request->value;    
        $column = $request->column;

        $collection=DB::table($table)->where($key, $value)->get();
        $select_option='';
        // $select_option.="<option value=''>Select an Option</option>";
        foreach ($collection as $row) {
            $select_option.="<option value='".$row->$id."'>".$row->$column."</option>";
        }
        return $select_option;
    
    }

    public function getSelectOption2(Request $request){
        $table = $request->table;       
        $id = $request->id;        
        $column = $request->column;

        $companyId = 1;
            
        $collection=DB::table($table)->where('companyId', $companyId)->get();
        $select_option='';
        // $select_option.="<option value=''>Select an Option</option>";
        foreach ($collection as $row) {
            $select_option.="<option value='".$row->$id."'>".$row->$column."</option>";
        }
        return $select_option;
    
    }


    public static function getValueStatic($table,$column,$key,$value)
    {
        $result = DB::table($table)
          ->where($key, '=', $value)
          ->orderBy('id','asc')
          ->value($column);
        return $result;
    }

    public function getValueByMultiWhere($table,$column,$where)
    {
        $result = DB::table($table)
          ->where($where)
          ->value($column);
        return $result;
    }

    public static function getStaticValueByMultiWhere($table,$column,$where)
    {
        $result = DB::table($table)
          ->where($where)
          ->value($column);
        return $result;
    }



    public function getValue($table,$column,$key,$value)
    {
        $result = DB::table($table)
          ->where($key, '=', $value)
          ->orderBy('id','asc')
          ->value($column);
        return $result;
    }



    public function select_record(Request $request)
    {
        $table = $request->table;
        $key = $request->key;
        $value = $request->value;

        $result = DB::table($table)
        ->where($key, $value)
        ->first();

        return json_encode($result);

    }


    public static function LedgerItemDetails($sql)
    {
        $result = DB::select($sql);
        return $result;
    }

    public function EnDayToHiDay($day)
    {
        if ($day=='Mon') {
            return "सोम";
        }
        else if($day=='Tue'){
            return "मंगल";
        }
        else if($day=='Wed'){
            return "बुध";
        }
        else if($day=='Thu'){
            return "गुरु";
        }
        else if($day=='Fri'){
            return "शुक्र";
        }
        else if($day=='Sat'){
            return "शनि";
        }
        else if($day=='Sun'){
            return "रवि";
        }
    }

    public static function staticEnDayToHiDay($day)
    {
        if ($day=='Mon') {
            return "सोम";
        }
        else if($day=='Tue'){
            return "मंगल";
        }
        else if($day=='Wed'){
            return "बुध";
        }
        else if($day=='Thu'){
            return "गुरु";
        }
        else if($day=='Fri'){
            return "शुक्र";
        }
        else if($day=='Sat'){
            return "शनि";
        }
        else if($day=='Sun'){
            return "रवि";
        }
    }




    public function getPartyType($partyId)
    {
            $master_customer_suppliers = DB::table('master_customer_suppliers')
            ->where('id', $partyId)
            ->first();
            $partType='';
            if($master_customer_suppliers->customer == '1'){
            $partType = 'customerRate';
            }
            if($master_customer_suppliers->supplier == '1'){
            $partType = 'supplierRate';
            }
            return $partType;
    }

    public static function getPartyTypeStatic($partyId)
    {
            $master_customer_suppliers = DB::table('master_customer_suppliers')
            ->where('id', $partyId)
            ->first();
            $partType='';
            if($master_customer_suppliers->customer == '1'){
            $partType = 'customerRate';
            }
            if($master_customer_suppliers->supplier == '1'){
            $partType = 'supplierRate';
            }
            return $partType;
    }

    


}
