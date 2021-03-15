
@extends('layouts.app')
@section('content')

    <div class="container-fluid">
          
        
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Group Datatable    
                        </h3>
                        <a href="{{ url('/master-group') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ "Add New Group" }}</a>
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">
                            <table id="myTable" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Group Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($master_groups as $row)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td class='hidden-480'>
                                           
                                                <a href="{{ url('master-group-edit/'.$row->id) }}" class="btn" rel="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ url('common-destroy?table=master_groups&key=id&value='.$row->id) }}" class="btn" rel="tooltip" title="Delete">
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