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
                        <li><a href="{{URL::route('admin.user.index')}}"><i class="fa fa-users"></i> Customers</a></li>
                        <li class="active">{{$user->first_name.' '.$user->last_name}}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-user"></i> 
                                <small class="pull-right">Joined: {{$user->created_at}}</small>
                            </h2>
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <strong>{{$user->first_name.' '.$user->last_name}}</strong><br>
                                {{$user->company ? $user->company.'<br>':''}}
                                {{$user->address1}} {{$user->address2}}<br>
                                {{$user->city}}, {{$user->state}} {{$user->postal_code}}<br>
                                Phone: {{$user->phone}}<br>
                                Email: <a href="mailto:{{$user->email}}">{{$user->email}}</a><br>
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>User ID #{{$user->id}}</b><br>
                            <b>FoxyCart ID:</b> {{$user->foxycart_id}}<br>
                            <b>Subscription Ends:</b> {{$user->subscription_ends_at}}<br>
                            <b>Last 4:</b> {{$user->last_four}}
                            <b>CC Expires:</b> {{$user->exp_month}} / {{$user->exp_year}}
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">

                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table id="table-transactions" class="table table-bordered table-striped table-data">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->transactions as $transaction)        
                                    <tr>
                                        <td>{{$transaction->id}}</td>
                                        <?php
                                            $details = json_decode($transaction->details,true);
                                        ?>
                                        <td>{{$details['product_name']}}</td>
                                        <td>${{number_format($transaction->order_total,2)}}</a></td>
                                        <td>{{$transaction->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->


                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-6">
                            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                        </div>
                        <div class="col-xs-6">
                            @if($user->subscription_active)
                            <a class="btn btn-danger pull-right" href="{{route('admin.user.deactivate-subscription',['id'=>$user->id])}}">Deactivate Subscription</a>
                            @endif
                        </div>

                           

                    </div>
                </section>



            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->

@include("admin/_partials/footer")