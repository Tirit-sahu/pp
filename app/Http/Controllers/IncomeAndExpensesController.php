<?php

namespace App\Http\Controllers;

use App\Models\IncomeAndExpenses;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;


class IncomeAndExpensesController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $this->companyId = Session::get('companyId');   
            return $next($request);
        });
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {           
        $companyId = $this->companyId;
        $where = array('companyId'=>$companyId);
        $res = DB::table('other_income_and_expenses')->where($where)->get();
        $result = DB::table('income_and_expenses')->where($where)->get();
        return view('/incomeandexpenses',['data'=>$result,'rdata'=>$res]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $request->validate([
            'name' => 'required|max:255',
            'date' => 'required',
            'Type' => 'required',
            'Amount' => 'required',
            'Remark' => 'required',
        ]);
      
        $data = $request->all();

        $data['createdById'] = Auth::id();
        $data['companyId'] =$this->companyId;
       $data['ipAddress']= $request->ip();  
     
        DB::table('income_and_expenses')->insert($data);
        session()->flash('success', 'Record Submitted Successfully');
        return redirect('incomeandexpenses');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IncomeAndExpenses  $incomeAndExpenses
     * @return \Illuminate\Http\Response
     */
    public function show(IncomeAndExpenses $incomeAndExpenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IncomeAndExpenses  $incomeAndExpenses
     * @return \Illuminate\Http\Response
     */
    public function edit(IncomeAndExpenses $incomeAndExpenses,$id)
    {
        $res = DB::table('other_income_and_expenses')->get();
        $result=  DB::table('income_and_expenses')->get();
        $editData=DB::table('income_and_expenses')->where('id',$id)->first();
        return view('incomeandexpenses', ['data'=>$result, 'editData'=>$editData,'rdata'=>$res]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomeAndExpenses  $incomeAndExpenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
      
        $request->validate([
            'name' => 'required|max:255',
            'date' => 'required',
            'Type' => 'required',
            'Amount' => 'required',
            'Remark' => 'required',
        ]);
      
        $data = $request->all();
       
        $data['createdById'] = Auth::id();
        $data['ipAddress']= $request->ip();  
     
        DB::table('income_and_expenses')->where('id',$id)->update($data);
        session()->flash('success', 'Record Updated Successfully');
        return redirect('incomeandexpenses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IncomeAndExpenses  $incomeAndExpenses
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomeAndExpenses $incomeAndExpenses,$id)
    {
        DB::table('income_and_expenses')->where('id',$id)->delete();
        session()->flash('success', 'Record Deleted Successfully');
        return redirect('incomeandexpenses');
    }
}
