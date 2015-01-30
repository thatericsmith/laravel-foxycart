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
                        Articles
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{URL::route('admin.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Articles</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">


                    <div class="row">
                        <div class="col-xs-12">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">All Articles</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-data">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Topic</th>
                                                <th>Article</th>
                                                <th>Source</th>
                                                <th>Grade</th>
                                                <th>URL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($articles as $article)        
                                            <tr>
                                                <td>{{$article->created_at}}</td>
                                                <td><a href="{{$article->topic->admin_permalink()}}">{{$article->topic->title}}</a></td>
                                                <td><a href="{{$article->admin_permalink()}}">{{$article->title}}</a></td>
                                                <td>{{strtoupper($article->source)}}</td>
                                                <td>{{$article->grade()}}</td>
                                                <td>{{$article->url}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date</th>
                                                <th>Topic</th>
                                                <th>Article</th>
                                                <th>Source</th>
                                                <th>Grade</th>
                                                <th>URL</th>
                                            </tr>
                                        </tfoot>
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