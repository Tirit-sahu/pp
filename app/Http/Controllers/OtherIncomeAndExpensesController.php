<?php

namespace App\Http\Controllers;

use App\Models\OtherIncomeAndExpenses;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;



class OtherIncomeAndExpensesController extends Controller
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
        $result=DB::table('other_income_and_expenses')->get(); 
        return view ('/other-income-expenses',['data'=>$result]);
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
            'nameHindi' => 'required',
            'type' => 'required',
        ]);
        $data = $request->all();

        $data['createdById'] = Auth::id();
        $data['companyId'] =$this->companyId;
       $data['ipAddress']= $request->ip();  
       
        DB::table('other_income_and_expenses')->insert($data);
        session()->flash('success', 'Record Submitted Successfully');
        return redirect('other-income-expenses');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OtherIncomeAndExpenses  $otherIncomeAndExpenses
     * @return \Illuminate\Http\Response
     */
    public function show(OtherIncomeAndExpenses $otherIncomeAndExpenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OtherIncomeAndExpenses  $otherIncomeAndExpenses
     * @return \Illuminate\Http\Response
     */
    public function edit(OtherIncomeAndExpenses $otherIncomeAndExpenses,$id)
    {
            $companyId = $this->companyId;
            $where = array('companyId'=>$companyId);

            $result=  DB::table('other_income_and_expenses')->where($where)->get();
            $editData=DB::table('other_income_and_expenses')->where('id',$id)->first();
            return view('other-income-expenses', ['data'=>$result, 'editData'=>$editData]);
            
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OtherIncomeAndExpenses  $otherIncomeAndExpenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OtherIncomeAndExpenses $otherIncomeAndExpenses,$id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'nameHindi' => 'required',
            'type' => 'required',
        ]);
        $data = $request->all();

        $data['createdById'] = Auth::id();
        $data['companyId'] =$this->companyId;
       $data['ipAddress']= $request->ip();  
       
        DB::table('other_income_and_expenses')->where('id',$id)->update($data);
        session()->flash('success', 'Record Updated Successfully');
        return redirect('other-income-expenses');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OtherIncomeAndExpenses  $otherIncomeAndExpenses
     * @return \Illuminate\Http\Response
     */
    public function destroy(OtherIncomeAndExpenses $otherIncomeAndExpenses,$id)
    {
        DB::table('other_income_and_expenses')->where('id',$id)->delete();
        session()->flash('success', 'Record Deleted Successfully');
        return redirect('other-income-expenses');
    }
}
