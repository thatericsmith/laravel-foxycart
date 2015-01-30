



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
                        Article: <strong>{{$article->title}}</strong>
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{URL::route('admin.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="{{URL::route('admin.article.index')}}">Articles</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">


                    <div class="row">
                         <div class="col-xs-6">
                            
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">                                        
                                        
                                        <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                                    </div><!-- /. tools -->

                                    <i class="fa fa-map-marker"></i>
                                    <h3 class="box-title">
                                        Article Details
                                    </h3>
                                </div>
                                <div class="box-body">
                                    <header class="article-header">
                                      <p>Topic: <a href="{{$article->topic->admin_permalink()}}">{{$article->topic->title}}</a></p>
                                      <h1 class="article-title">{{$article->title}}</h1>
                                      <p class="article-meta meta-text">{{$article->clean_date()}} : {{$article->source}}</p>
                                      <p class="article-url"><a target="_blank" href="{{$article->url}}">{{$article->url}}</a></p>
                                      @if(!empty($article->author))
                                      <p class="article-author">Written by {{$article->author}}</p>
                                      @endif
                                      <img class="img-responsive" src="{{$article->img(490,180)}}">
                                    </header>
                                    <section class="article-body">
                                      {{$article->content}}
                                    </section>

                                    
                                </div><!-- /.box-body-->
                                <div class="box-footer">
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-xs-6">                            
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">                                        
                                        
                                        <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                                    </div><!-- /. tools -->

                                    <i class="fa fa-map-marker"></i>
                                    <h3 class="box-title">
                                        Grade Details
                                    </h3>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <!-- .table - Uses sparkline charts-->
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Grade</th>
                                                <th>Grade Dist.</th>
                                                <th>Views / Grades</th>
                                                <th>+100</th>
                                            </tr>
                                            
                                            <tr>
                                                <td>{{$article->grade()}}</td>
                                                <td><div class="sparkline-bar" data-values="{{implode(',',array_values($article->grade_spectrum()))}}"></div></td>
                                                <td>{{intval($article->views)}} / {{$article->grades->count()}}</td>
                                                <td>
                                                    <select class="admin-grader" data-article="{{$article->id}}" data-qty="100">
                                                        <option value="">-</option>
                                                        <option>A</option>
                                                        <option>B</option>
                                                        <option>C</option>
                                                        <option>D</option>
                                                        <option>F</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            
                                        </table><!-- /.table -->
                                    </div>
                                </div><!-- /.box-body-->
                                <div class="box-footer">
                                </div>
                            </div>
                            <!-- /.box -->

                            

                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Admin Options</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    {{ Form::open(array('route' => array('admin.article.destroy', $article->id), 'method' => 'delete')) }}
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete Article</button>
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