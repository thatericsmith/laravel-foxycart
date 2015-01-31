@include("admin/_partials/head")
    <body class="skin-black">
        @include("admin/_partials/header")
        <div class="wrapper row-offcanvas row-offcanvas-left">
            @include("admin/_partials/sidebar")


            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Customers
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{URL::route('admin.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Customers</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">


                    <div class="row">
                        <div class="col-xs-12">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">All Customers</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-data">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Subscription</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)        
                                            <tr>
                                                <td><a href="{{$user->admin_permalink()}}">{{$user->id}}</a></td>
                                                <td>{{$user->name}}</td>
                                                <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                                <td>{{$user->subscription_active ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>'}}</td>
                                                <td><a href="{{$user->admin_permalink()}}">View Subscription</a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->

@include("admin/_partials/footer")