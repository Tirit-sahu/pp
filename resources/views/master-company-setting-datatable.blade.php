
@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="pull-left">
            <h1>Dashboard</h1>
        </div>
        <div class="pull-right">
            <ul class="minitiles">
                <li class='grey'>
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                    </a>
                </li>
                <li class='lightgrey'>
                    <a href="#">
                        <i class="fa fa-globe"></i>
                    </a>
                </li>
            </ul>
            <ul class="stats">
                <li class='satgreen'>
                    <i class="fa fa-money"></i>
                    <div class="details">
                        <span class="big">$324,12</span>
                        <span>Balance</span>
                    </div>
                </li>
                <li class='lightred'>
                    <i class="fa fa-calendar"></i>
                    <div class="details">
                        <span class="big">February 22, 2013</span>
                        <span>Wednesday, 13:56</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    
    
    
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color">
                <div class="box-title">
                    <h3>
                        <i class="fa fa-list-alt" aria-hidden="true"></i> Company Setting Datatable    
                    </h3>
                    <a href="{{ url('/master-company-setting') }}" class="btn btn-satgreen pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ "Add New Company Setting" }}</a>
                </div>
                <div class="box-content">
                    <x-alert/>
                    <div class="box-content nopadding" style="overflow: scroll;">
                        <table id="myTable" class="table table-hover table-nomargin table-bordered">
                            <thead>
                                <tr>
                                    <th>SNO.</th>
                                    <th>Company <br> Name</th>
                                    <th>Name <br> Hindi</th>
                                    <th>Logo</th>
                                    <th>Mobile</th>
                                    <th>Alternate <br> Mobile</th>
                                    <th>Address</th>
                                    <th>Address <br> Hindi</th>
                                    <th>Slog</th>
                                    <th>Slog <br> Hindi</th>
                                    <th>Email</th>
                                    <th>Term <br> Condition</th>
                                    <th>Opening <br> Balance</th>
                                    <th>Opening Balance <br> Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=0; @endphp
                                @foreach($master_company_settings as $row)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->nameHindi }}</td>
                                    <td><img src="row->logo" alt=""></td>
                                    <td>{{ $row->mobile }}</td>
                                    <td>{{ $row->mobile2 }}</td>
                                    <td>{{ $row->address }}</td>
                                    <td>{{ $row->addressHindi }}</td>
                                    <td>{{ $row->slog }}</td>
                                    <td>{{ $row->slogHindi }}</td>
                                    <td>{{ $row->emailId }}</td>
                                    <td>{{ $row->termCondition }}</td>
                                    <td>{{ $row->openingBalance }}</td>
                                    <td>{{ date('d-m-Y', strtotime($row->openingBalanceDate)) }}</td>
                                    <td class='hidden-480'>
                                       
                                        <a href="{{ url('master-company-setting-edit/'.$row->id) }}" class="btn" rel="tooltip" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ url('common-destroy?table=master_company_settings&key=id&value='.$row->id) }}" class="btn" rel="tooltip" title="Delete">
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
