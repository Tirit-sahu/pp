<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class MasterUnit extends Controller
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
        return view('master-unit');
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
            'nameHindi' => 'required'
        ]);
        $data = $request->all();
        $userId = Auth::id();
        $clentIp = $request->ip();        
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;
        $data['supplierRate'] = isset($request->supplierRate)?$request->supplierRate:0;
        $data['customerRate'] = isset($request->customerRate)?$request->customerRate:0;
        
        DB::table('master_units')
        ->insert($data);
        session()->flash('success', "Unit Created Successfully.");
        return redirect::back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $master_units = DB::table('master_units')->orderBy('id', 'DESC')->get();
        return view('master-unit-datatable', ['master_units'=>$master_units]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $master_unit = DB::table('master_units')->where('id', $id)->first();
        return view('master-unit', ['master_unit'=>$master_unit]);
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
        $data = $request->all();
        
        $request->validate([
            'name' => 'required',
            'nameHindi' => 'required'
        ]);

        $data['supplierRate'] = isset($request->supplierRate)?$request->supplierRate:0;
        $data['customerRate'] = isset($request->customerRate)?$request->customerRate:0;

        DB::table('master_units')
        ->where('id', $id)
        ->update($data);
        session()->flash('success', "Unit Updated Successfully.");
        return redirect('/master-unit-datatable');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('master_units')
        ->where('id', $id)
        ->delete();
        session()->flash('success', "Unit Deleted Successfully.");
        return redirect('/master-unit-datatable');
    }
}
