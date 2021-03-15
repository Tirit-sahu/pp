<?php

namespace App\Http\Controllers;

use App\Models\MasterBijakPrintName;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class MasterBijakPrintNameController extends Controller
{

    public $companyId;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-bijak-print-name');
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
        unset($data['_token']);
        
        DB::table('master_bijak_print_names')
        ->insert($data);
        session()->flash('success', "New Record Created Successfully.");
        return redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterBijakPrintName  $masterBijakPrintName
     * @return \Illuminate\Http\Response
     */
    public function show(MasterBijakPrintName $masterBijakPrintName)
    {
        $master_bijak_print_names = DB::table('master_bijak_print_names')->orderBy('id', 'DESC')->get();
        return view('master-bijak-print-name-show', ['master_bijak_print_names'=>$master_bijak_print_names]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterBijakPrintName  $masterBijakPrintName
     * @return \Illuminate\Http\Response
     */
    public function edit($id, MasterBijakPrintName $masterBijakPrintName)
    {
        $master_bijak_print_names = DB::table('master_bijak_print_names')->where('id', $id)->first();
        return view('master-bijak-print-name', ['master_bijak_print_names'=>$master_bijak_print_names]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterBijakPrintName  $masterBijakPrintName
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, MasterBijakPrintName $masterBijakPrintName)
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
        unset($data['_token']);
        
        DB::table('master_bijak_print_names')
        ->where('id', $id)
        ->update($data);
        session()->flash('success', "Record Updated Successfully.");
        return redirect('master-bijak-print-name-show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterBijakPrintName  $masterBijakPrintName
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterBijakPrintName $masterBijakPrintName)
    {
        //
    }
}
