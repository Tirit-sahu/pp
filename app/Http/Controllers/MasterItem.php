<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class MasterItem extends Controller
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
        return view('/master-item');
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
            'nameHindi' => 'required',
        ]);
        $data = $request->all();
        $userId = Auth::id();
        $clentIp = $request->ip();        
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;

        DB::table('master_items')
        ->insert($data);
        session()->flash('success', "Item Created Successfully.");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $master_items = DB::table('master_items')
        ->orderBy('id', 'DESC')
        ->get();
        return view('/master-item-datatable', ['master_items'=>$master_items]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $master_item = DB::table('master_items')
        ->where('id', $id)
        ->first();
        return view('master-item', ['master_item'=>$master_item]);
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
            'nameHindi' => 'required',
        ]);
        $data = $request->all();
        $userId = Auth::id();
        $clentIp = $request->ip();        
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;

        DB::table('master_items')
        ->where('id', $id)
        ->update($data);
        session()->flash('success', "Item Updated Successfully.");
        return redirect('/master-item-datatable');

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
