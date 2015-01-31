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
                        Timeline
                        <small>Customers</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Timeline</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- The time line -->
                            <ul class="timeline">
                                <!-- timeline time label -->
                                <li class="time-label">
                                    <span class="bg-aqua">
                                        10 Feb. 2014
                                    </span>
                                </li>
                                <!-- /.timeline-label -->

                                <!-- timeline item -->
                                <li>
                                    <i class="fa fa-times-circle bg-red"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                                        <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> canceled a subscription</h3>
                                    </div>
                                </li>
                                <!-- END timeline item -->

                                <!-- timeline time label -->
                                <li class="time-label">
                                    <span class="bg-aqua">
                                        3 Jan. 2014
                                    </span>
                                </li>
                                <!-- /.timeline-label -->
                               <!-- timeline item -->
                                <li>
                                    <i class="fa fa-user bg-green"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                                        <h3 class="timeline-header no-border"><a href="#">John Smith</a> began a subscription</h3>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <li>
                                    <i class="fa fa-clock-o"></i>
                                </li>
                            </ul>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

    
                </section><!-- /.content -->
            </aside>


        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->

@include("admin/_partials/footer")