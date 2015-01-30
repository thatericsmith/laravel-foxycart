@include("admin/_partials/head")
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form method="post">
                <div class="body bg-gray">
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
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign in</button>  
                    
                    {{--<p><a href="#">I forgot my password</a></p> --}}                   
                </div>
            </form>

        </div>

@include("admin/_partials/footer")