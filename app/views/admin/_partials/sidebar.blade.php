<!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    {{--
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>

                    <!-- /.search form -->
                    --}}
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="">
                            <a href="{{URL::route('admin.index')}}">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{route('admin.user.index')}}">
                                <i class="fa fa-users"></i> <span>Customers</span> 
                            </a>
                        </li>
                        <li class="">
                            <a href="{{route('admin.transaction.index')}}">
                                <i class="fa fa-money"></i> <span>Transactions</span> 
                            </a>
                        </li>
                        
                        {{--
                        <li class="">
                            <a href="{{route('admin.timeline')}}">
                                <i class="fa fa-clock-o"></i> <span>Timeline</span> 
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Charts</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>
                            </ul>
                        </li>
                        --}}
      
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>