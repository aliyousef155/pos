<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('uploads/users_images/'.auth()->user()->image)}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p> {{auth()->user()->first_name.' '.auth()->user()->last_name}}</p>
            </div>

        </div>
        <ul class="sidebar-menu ">

            <li class=" treeview">
                <a href="{{route('dashboard.admin')}}">
                    <i class="fa fa-dashboard"></i> <span>{{__('site.dashboard')}}</span>
                </a>

            </li>
            @if(auth()->user()->hasPermission('categories_read'))
            <li class=" treeview">
                <a href="{{route('dashboard.categories.index')}}">
                    <i class="fa fa-th"></i> <span>{{__('site.categories')}}</span>
                </a>

            </li>
            @endif
            @if(auth()->user()->hasPermission('products_read'))
            <li class=" treeview">
                <a href="{{route('dashboard.products.index')}}">
                    <i class="fa fa-th"></i> <span>{{__('site.products')}}</span>
                </a>

            </li>
                @endif
            @if(auth()->user()->hasPermission('clients_read'))
            <li class=" treeview">
                <a href="{{route('dashboard.clients.index')}}">
                    <i class="fa fa-th"></i> <span>{{__('site.clients')}}</span>
                </a>

            </li>
            @endif
            @if(auth()->user()->hasPermission('orders_read'))
            <li class=" treeview">
                <a href="{{route('dashboard.orders.index')}}">
                    <i class="fa fa-th"></i> <span>{{__('site.orders')}}</span>
                </a>

            </li>
            @endif
            @if(auth()->user()->hasPermission('users_read'))
                <li class=" treeview">
                    <a href="{{route('dashboard.users.index')}}">
                        <i class="fa fa-th"></i> <span>{{__('site.users')}}</span>
                    </a>

                </li>

            @endif

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

