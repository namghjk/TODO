<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    @hasanyrole('Admin|Admin edit')
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Post
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                    @endhasanyrole
                    <ul class="nav nav-treeview">
                        @hasanyrole('Admin')
                            <li class="nav-item">
                                <a href="{{ route('newPost') }}"
                                    class="nav-link {{ Request::route()->getName() == 'newPost' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add new post</p>
                                </a>
                            </li>
                        @endhasanyrole

                        @role('Admin edit|Admin')
                            <li class="nav-item">
                                <a href="{{ route('showAll') }}"
                                    class="nav-link {{ Request::route()->getName() == 'showAll' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All post</p>
                                </a>
                            </li>
                        @endrole



                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        <!-- Sign Out button-->
        <li class='nav-item'>
            <a href="{{ route('logout') }}" class="nav-link btn btn-danger mb-4  mt-1 d-block w-100 text-center "> Đăng
                xuất</a>
        </li>
    </div>
    <!-- /.sidebar -->
</aside>
