
@extends('layouts.app')
@section('content')
    <div class="container-fluid">
               
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Item Datatable    
                        </h3>
                        <a href="{{ url('/master-item') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ "Add New Item" }}</a>
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">
                            <table id="myTable2" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Item <br>Name</th>
                                        <th>Item Name<br>Hindi</th>                                                               
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($master_items as $row)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->nameHindi }}</td>
                                            <td class='hidden-480'>                                           
                                                <a href="{{ url('master-item-edit/'.$row->id) }}" class="btn" rel="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ url('common-destroy?table=master_items&key=id&value='.$row->id) }}" class="btn" rel="tooltip" title="Delete">
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

@endsection
