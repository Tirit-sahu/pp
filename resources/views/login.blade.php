


@extends('layouts.app')
@section('content')
<div class="row" style="margin-top: 8%;" id="particles-js">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="box">
            <div class="box-title">
                <h3>
                    <i class="fa fa-lock" aria-hidden="true"></i> Login</h3>
            </div>
            <div class="box-content">
                <form action="{{ url('login') }}" method="POST" class='form-horizontal'>
                    @csrf
                    <x-alert/>
                    <div class="form-group">
                        <label for="email" class="control-label col-sm-2">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label col-sm-2">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" id="password" placeholder="*********" class="form-control">
                        </div>
                    </div>  
                    
                    <div class="form-group">
                        <label for="password" class="control-label col-sm-2">Company</label>
                        <div class="col-sm-10">
                            <select name="companyId" class="js-select2" id="companyId" style="width:100%">
                                <option value="">Select Company</option>                                                
                            </select>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary form-control">LOGIN</button>
                        </div>
                    </div> 

                    
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    function getCompany(id=0){
            $.ajax({
            type:'GET',
            url:'{{ url("get-company") }}?table=master_company_settings&id=id&column=name',
            success:function(response){
                // console.log(response);
                $("#companyId").html(response);
                $("#companyId").val(id);
                $('#companyId').trigger('change'); 
            }
            });
        }
        getCompany();
</script>

