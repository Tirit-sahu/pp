<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use DB;
use Session;


class Login extends Controller
{

    public function Login(){
        return view('login');
    }

    
    public function submitLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'companyId' => 'required'
        ]);        
        $companyId = $request->companyId;
        if(\Auth::attempt(array('email' => $request->email, 'password' => $request->password, 'companyId' => $companyId))){
            Session::put('companyId', $companyId);
            return redirect('/');
        }else{
            session()->flash('error', 'Email and password was incorect.');
            return redirect('/login');
        }
    }


    public function logout(Request $request){
        Auth::logout();
        return Redirect::to('login');
    }



    public function getSelectOption2(Request $request){
        $table = $request->table;       
        $id = $request->id;        
        $column = $request->column;
            
        $collection=DB::table($table)->orderBy('id', 'DESC')->get();
        $select_option='';
        $select_option.="<option value=''>Select an Option</option>";
        foreach ($collection as $row) {
            $select_option.="<option value='".$row->$id."'>".$row->$column."</option>";
        }
        return $select_option;
    
    }


}
