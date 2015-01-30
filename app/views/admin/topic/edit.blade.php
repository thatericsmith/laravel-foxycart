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
                        Topic: <strong>{{$topic->title}}</strong>
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{URL::route('admin.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="{{URL::route('admin.topic.index')}}">Topics</a></li>
                        <li class="active">{{$topic->title}}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">


                    <div class="row">
                         <div class="col-xs-6">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Articles for this Topic</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-data">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Article</th>
                                                <th>Source</th>
                                                <th>Grade</th>
                                                <th>+100</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topic->articles as $article)        
                                            <tr>
                                                <td>{{$article->created_at}}</td>
                                                <td><a href="{{$article->admin_permalink()}}">{{$article->title}}</a></td>
                                                <td>{{strtoupper($article->source)}}</td>
                                                <td>{{$article->grade()}}</td>
                                                <td><select class="admin-grader" data-article="{{$article->id}}" data-qty="100">
                                                        <option value="">-</option>
                                                        <option>A</option>
                                                        <option>B</option>
                                                        <option>C</option>
                                                        <option>D</option>
                                                        <option>F</option>
                                                    </select></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Date</th>
                                                <th>Article</th>
                                                <th>Source</th>
                                                <th>Grade</th>
                                                <th>+100</th>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <div class="col-xs-6">

                            <div class="small-box bg-green">

                                <div class="inner">
                                <h4 class="box-title">Add more articles</h4>                                    
                                   {{View::make('admin.article.create')->with('topic',$topic)}}
                                </div>
                            </div>

                            

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Admin Options</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    {{ Form::open(array('route' => array('admin.topic.destroy', $topic->id), 'method' => 'delete')) }}
                                        <button type="submit" class="btn btn-danger">Delete Topic</button>
                                    {{ Form::close() }}

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div>

                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->

@include("admin/_partials/footer")