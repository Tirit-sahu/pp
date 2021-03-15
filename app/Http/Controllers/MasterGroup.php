<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class MasterGroup extends Controller
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
        return view('master-group');
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
            'name'=>'required'
        ]);

        $data = $request->all();

        $count = DB::table('master_groups')
        ->where('name', $request->name)->count();

        if($count==0){

        $userId = Auth::id();
        $clentIp = $request->ip();       

        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;

        DB::table('master_groups')
        ->insert($data);
            session()->flash('success', "Group Created Successfully.");
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
        $master_groups = DB::table('master_groups')
        ->orderBy('id', 'DESC')
        ->get();
        return view('master-group-datatable', ['master_groups'=>$master_groups]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $master_group = DB::table('master_groups')
        ->where('id', $id)
        ->first();
        return view('master-group', ['master_group'=>$master_group]);
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
            'name'=>'required'
        ]);

        $data = $request->all();

        $count = DB::table('master_groups')
        ->where('name', $request->name)->count();

        if($count==0){

        $userId = Auth::id();
        $clentIp = $request->ip();       

        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;

        DB::table('master_groups')
        ->where('id', $id)
        ->update($data);
            session()->flash('success', "Group Created Successfully.");
            return redirect('/master-group-datatable');
        }else{
            session()->flash('error', "".$request->name." is already in list");
            return redirect::back();
        }
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
