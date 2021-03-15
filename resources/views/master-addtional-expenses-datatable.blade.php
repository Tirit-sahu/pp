@extends('layouts.app')
@section('content')
    
    <div class="container-fluid">
                
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Addtionl Expenses Datatable   
                        </h3>
                        <a href="{{ url('/master-addtional-expenses') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ "Add New Addtionl Expenses" }}</a>
                    </div>
                    <div class="box-content">
                        <x-alert/>
                        <div class="box-content nopadding" style="overflow: scroll;">
                            <table id="myTable" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Expenses <br>Name</th>
                                        <th>Expenses Name<br>Hindi</th>
                                        <th>Type</th>
                                        <th>Proccess</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($master_addtional_expenses as $row)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->nameHindi }}</td>
                                            <td>{{ $row->type }}</td>
                                            <td>{{ $row->process }}</td>                                           
                                            <td>                                           
                                                <a href="{{ url('master-addtional-expenses-edit/'.$row->id) }}" class="btn" rel="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ url('common-destroy?table=master_addtional_expenses&key=id&value='.$row->id) }}" class="btn" rel="tooltip" title="Delete">
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