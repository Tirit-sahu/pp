@extends('layouts.app')
@section('content')

    <div class="container-fluid">
            
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Unit Datatable   
                        </h3>
                        <a href="{{ url('/master-unit') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ "Add New Unit" }}</a>
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">
                            <table id="myTable2" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Unit <br>Name</th>
                                        <th>Unit Name<br>Hindi</th>
                                        <th>Supplier Rate</th>
                                        <th>Customer Rate</th>
                                        <th>Is Stockable</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach($master_units as $row)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->nameHindi }}</td>                                            
                                            <td>{{ $row->supplierRate }}</td>
                                            <td>{{ $row->customerRate }}</td>
                                            <td>{{ $row->isStockable }}</td>
                                            <td class='hidden-480'>
                                           
                                                <a href="{{ url('master-unit-edit/'.$row->id) }}" class="btn" rel="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                
                                                <a href="{{ url('master-unit-delete/'.$row->id) }}" class="btn" rel="tooltip" title="Delete">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>

    {{-- @include('master_edit_modal') --}}

@endsection