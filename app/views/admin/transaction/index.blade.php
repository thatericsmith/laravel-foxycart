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
                        Transactions
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{URL::route('admin.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Transactions</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">


                    <div class="row">
                        <div class="col-xs-12">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">All Transactions <a class="btn btn-default" href="{{route('admin.transaction.refresh')}}">Refresh</a></h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="table-transactions" class="table table-bordered table-striped table-data">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer</th>
                                                <th>Product</th>
                                                <th>Total</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions as $transaction)        
                                            <tr>
                                                <td>{{$transaction->id}}</td>
                                                <td><a href="{{$transaction->user->admin_permalink()}}">{{$transaction->user->first_name}} {{$transaction->user->last_name}}</a></td>
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
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->

@include("admin/_partials/footer")