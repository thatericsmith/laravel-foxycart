@include('_partials/header')
<div class="main">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h1>Sign In</h1>

                    <form method="post">
                            @if(Session::get('alert'))
                            <div class="alert alert-danger">{{Session::get('alert')}}</div>
                            @endif
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" placeholder="E-mail"/>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password"/>
                            </div>          
                            <div class="form-group">
                                <input type="checkbox" name="remember"/> Remember me
                            </div>
                        <div class="footer">                                                               
                            <button type="submit" class="btn btn-primary btn-block">Sign in</button>  
                            
                            {{--<p><a href="#">I forgot my password</a></p> --}}                   
                        </div>
                    </form>
                </div>
            </div>
</div>

@include('_partials/footer')