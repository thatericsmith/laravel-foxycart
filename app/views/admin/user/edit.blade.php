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
                <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> 
                                <small class="pull-right">Joined: {{$user->created_at}}</small>
                            </h2>
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <strong>{{$user->name}}</strong><br>
                                {{$user->address}}<br>
                                {{$user->city}}, {{$user->state}} {{$user->zip}}<br>
                                Phone: {{$user->phone}}<br>
                                Email: <a href="mailto:{{$user->email}}">{{$user->email}}</a><br>
                                {{$user->company}}
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>User ID #{{$user->id}}</b><br>
                            <b>FoxyCart ID:</b> {{$user->foxycart_id}}<br>
                            <b>Subscription Ends:</b> {{$user->subscription_ends_at}}<br>
                            <b>Last 4:</b> {{$user->last_four}}
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Product</th>
                                        <th>Serial #</th>
                                        <th>Description</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- TODO: TRANSACTIONS GO HERE --}}
                                </tbody>
                            </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->


                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                        </div>
                    </div>
                </section>



            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->

@include("admin/_partials/footer")