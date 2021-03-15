
<div id="main">
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
        <div class="breadcrumbs">
            <ul>
                <li>
                    <a href="more-login.html">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="index-2.html">Unit Master</a>                    
                </li>
            </ul>
            <div class="close-bread">
                <a href="#">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        
        
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
                            <table id="myTable" class="table table-hover table-nomargin table-bordered">
                                <thead>
                                    <tr>
                                        <th>SNO.</th>
                                        <th>Unit <br>Name</th>
                                        <th>Unit Name<br>Hindi</th>
                                        <th>Unit Name <br>Print</th>
                                        <th>Unit Name <br>Print Hindi</th>
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
                                            <td>{{ $row->namePrint }}</td>
                                            <td>{{ $row->namePrintHindi }}</td>
                                            <td>{{ $row->supplierRate }}</td>
                                            <td>{{ $row->customerRate }}</td>
                                            <td>{{ $row->isStockable }}</td>
                                            <td class='hidden-480'>
                                           
                                                <a href="{{ url('master-unit-edit/'.$row->id) }}" class="btn" rel="tooltip" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a wire:click="delete({{$row->id}})" class="btn" rel="tooltip" title="Delete">
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
</div>

