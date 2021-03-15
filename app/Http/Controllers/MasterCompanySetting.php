<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class MasterCompanySetting extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master-company-setting');
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

        $form = $request->all();

        $request->validate([
            'name' => 'required',
            'mobile' => 'required|digits:10|numeric'
        ]);
        
        $userId = Auth::id();
        $clentIp = $request->ip();       
        // $imageName = $this->logo->store('logo');
        $form['createdById'] = $userId;
        $form['ipAddress'] = $clentIp;
        $form['logo'] = '';
        $form['openingBalanceDate'] = date('Y-m-d', strtotime($request->openingBalanceDate));
        unset($form['_token']);

        DB::table('master_company_settings')
        ->insert($form);
        session()->flash('success', "Company Created Successfully.");
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $master_company_settings = DB::table('master_company_settings')
        ->orderBy('id', 'DESC')
        ->get();
        return view('master-company-setting-datatable', ['master_company_settings'=>$master_company_settings]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $master_company_settings = DB::table('master_company_settings')
        ->where('id', $id)
        ->first();
        return view('master-company-setting', ['master_company_settings'=>$master_company_settings]);
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
        $form = $request->all();

        $request->validate([
            'name' => 'required',
            'mobile' => 'required|digits:10|numeric'
        ]);
        
        $userId = Auth::id();
        $clentIp = $request->ip();       
        // $imageName = $this->logo->store('logo');
        $form['createdById'] = $userId;
        $form['ipAddress'] = $clentIp;
        $form['logo'] = '';
        $form['openingBalanceDate'] = date('Y-m-d', strtotime($request->openingBalanceDate));
        unset($form['_token']);

        DB::table('master_company_settings')
        ->where('id', $id)
        ->update($form);
        session()->flash('success', "Company Updated Successfully.");
        return Redirect('/master-company-setting-datatable');
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
