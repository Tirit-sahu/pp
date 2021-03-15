
<div class="row" style="margin-top: 8%;">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="box">
            <div class="box-title">
                <h3>
                    <i class="fa fa-lock" aria-hidden="true"></i> Login</h3>
            </div>
            <div class="box-content">
                <form wire:submit.prevent="submitLogin" method="POST" class='form-horizontal'>
                    @csrf
                    <x-alert/>
                    <div class="form-group">
                        <label for="email" class="control-label col-sm-2">Email</label>
                        <div class="col-sm-10">
                            <input type="text" wire:model="email" id="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label col-sm-2">Password</label>
                        <div class="col-sm-10">
                            <input type="password" wire:model="password" id="password" placeholder="*********" class="form-control">
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