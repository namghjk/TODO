<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/template/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/template/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('user_infor', Auth::user()->id) }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

       

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @hasanyrole('user')
                    <li class="nav-item menu-open">

                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Post
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('posts.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create post</p>
                                </a>
                            </li>



                            <li class="nav-item">
                                <a href="{{ route('posts.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Show all post</p>
                                </a>
                            </li>




                        </ul>
                    </li>
                @endhasanyrole

                @hasanyrole('admin')
                    <li class="nav-item menu-open">

                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Post
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('manage-post.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create post </p>
                                </a>
                            </li>



                            <li class="nav-item">
                                <a href="{{ route('manage-post.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Show all posts</p>
                                </a>
                            </li>




                        </ul>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                User
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('manage-user.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Show all users</p>
                                </a>
                            </li>




                        </ul>
                    </li>
                @endhasanyrole
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
