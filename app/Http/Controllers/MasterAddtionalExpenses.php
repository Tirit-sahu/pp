<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class MasterAddtionalExpenses extends Controller
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
        return view('master-addtional-expenses');
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
            'name' => 'required',
            'type' => 'required',
            'process' => 'required',
        ]);

        $count = DB::table('master_addtional_expenses')
        ->where('name', $request->name)->count();

        if($count==0){

        $data = $request->all();

        $userId = Auth::id();
        $clentIp = $request->ip();        
        
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;

        DB::table('master_addtional_expenses')
        ->insert($data);
        session()->flash('success', "Additional Expenses Created Successfully.");
        return redirect::back();
        }else{
            session()->flash('error', "".$request->name." is already in list");
            return redirect::back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $companyId = $this->companyId;

        $master_addtional_expenses = DB::table('master_addtional_expenses')
        ->where('companyId', $companyId)
        ->orderBy('id', 'DESC')
        ->get();
        // dd($master_addtional_expenses);
        return view('master-addtional-expenses-datatable', ['master_addtional_expenses'=>$master_addtional_expenses]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $master_addtional_expens = DB::table('master_addtional_expenses')
        ->where('id', $id)
        ->first();
        return view('master-addtional-expenses', ['master_addtional_expens'=>$master_addtional_expens]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'process' => 'required',
        ]);

       

        $data = $request->all();

        $userId = Auth::id();
        $clentIp = $request->ip();        
        
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;

        DB::table('master_addtional_expenses')
        ->where('id', $id)
        ->update($data);
        session()->flash('success', "Additional Expenses Updated Successfully.");
        return redirect('/master-addtional-expenses-datatable');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
