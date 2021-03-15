<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use Auth;


class MasterCustomerSupplier extends Controller
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
        $companyId = $this->companyId;
        $master_groups = DB::table('master_groups')->where('companyId', $companyId)->orderBy('id', 'DESC')->get();
        $master_units = DB::table('master_units')->where(['companyId'=>$companyId, 'isStockable'=>'Yes'])->orderBy('id', 'DESC')->get();
        return view('master-customer-supplier', ['master_groups'=>$master_groups, 'master_units'=>$master_units]);
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

        if($request->hasFile('photo')){
            $image = $request->file('photo');
            $fileName = date('Ymdhis').'.'.$image->extension();
            $image->storeAs('DOCCustomerSupplierLoader',$fileName,'public');
            $data['photo']=$fileName;
       }

        $userId = Auth::id();
        $clentIp = $request->ip();        
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;

        unset($data['unitId']);
        unset($data['openingUnit']);
        
       $insertGetId = DB::table('master_customer_suppliers')
       ->insertGetId($data);

       DB::table('custom_unit_rates')
       ->where(['partyId'=>0,'companyId'=>$this->companyId])
       ->update(['partyId'=>$insertGetId,'companyId'=>$this->companyId]);
       if (!empty($request->unitId)) {
            for ($i=0; $i < sizeof($request->unitId); $i++) { 
                $myArray = array(
                    'mCustomerSupplierId'=>$insertGetId,
                    'unitId'=>$request->unitId[$i],
                    'openingUnit'=>$request->openingUnit[$i]
                );

                DB::table('master_customer_supplier_unit_entries')
                ->insert($myArray);

            }
        }
       

       session()->flash('success', "Customer / Supplier Created Successfully.");
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
        $master_customer_suppliers = DB::table('master_customer_suppliers')
        ->where('companyId', 1)
        ->orderBy('id', 'DESC')
        ->get();
        return view('master-customer-supplier-datatable', ['master_customer_suppliers'=>$master_customer_suppliers]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companyId = $this->companyId;
        $master_groups = DB::table('master_groups')->where('companyId', $companyId)->orderBy('id', 'DESC')->get();
        $master_units = DB::table('master_units')->where(['companyId'=>$companyId, 'isStockable'=>'Yes'])->orderBy('id', 'DESC')->get();

        $master_customer_supplier = DB::table('master_customer_suppliers')
        ->where('id', $id)
        ->first();

        return view('master-customer-supplier', ['master_customer_supplier'=>$master_customer_supplier, 'master_groups'=>$master_groups, 'master_units'=>$master_units]);
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

        if($request->hasFile('photo')){
            $image = $request->file('photo');
            $fileName = date('Ymdhis').'.'.$image->extension();
            $image->storeAs('DOCCustomerSupplierLoader',$fileName,'public');
            $data['photo']=$fileName;
        }

        unset($data['unitId']);
        unset($data['openingUnit']);

        $userId = Auth::id();
        $clentIp = $request->ip();        
        $data['createdById'] = $userId;
        $data['ipAddress'] = $clentIp;
        $data['companyId'] = $this->companyId;
        $data['customer'] = $request->customer;
        $data['supplier'] = $request->supplier;
        $data['loader'] = $request->loader;

       DB::table('master_customer_suppliers')
       ->where('id', $id)
       ->update($data);

       DB::table('master_customer_supplier_unit_entries')
       ->where('mCustomerSupplierId', $id)
       ->delete();

       for ($i=0; $i < sizeof($request->unitId); $i++) { 
        $myArray = array(
            'mCustomerSupplierId'=>$id,
            'unitId'=>$request->unitId[$i],
            'openingUnit'=>$request->openingUnit[$i]
        );

        DB::table('master_customer_supplier_unit_entries')
        ->insert($myArray);

        }

       session()->flash('success', "Customer / Supplier Updated Successfully.");
       return redirect('/master-customer-supplier-datatable');
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
