@extends('layouts.app')
@section('content')


    <div class="container-fluid">
           
        
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-color">
                    <div class="box-title">
                        <h3>
                            <i class="fa fa-list-alt" aria-hidden="true"></i> Bijak Print Name Report
                        </h3>
                        <a href="{{ url('/master-bijak-print-name') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a>
                    </div>
                    <div class="box-content">
                       
                        <x-alert/>
                        <table id="myTable2" class="table table-bordered">
                            <thead>
                              <tr>
                                <th>SNO.</th>
                                <th>Name</th>
                                <th>Hindi Name</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($master_bijak_print_names as $row)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->nameHindi }}</td>
                                        <td>
                                            <a href="{{ url('master-bijak-print-name-edit/'.$row->id) }}" class="btn" rel="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            
                                            <a href="{{ url('common-destroy') }}?table=master_bijak_print_names&key=id&value={{$row->id}}" class="btn" rel="tooltip" title="Delete">
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


@endsection
