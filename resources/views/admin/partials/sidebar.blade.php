<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @php

    @endphp
    <a href="index3.html" class="brand-link">
        <img src="{{asset(config('site-settings.site_logo'))}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('site-settings.site_title')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                            <div class="image">
                                <img src="{{asset($user_name->photo)}}" class="img-circle elevation-2"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/150'"
                                    alt="User Image">
                            </div>
                            <div class="info">
                                <span href="#" class="d-block">{{$user_name->username}}</span>
                            </div>
                        </div>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.users.profile')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('logout')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sign out</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            System Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.site-settings.edit')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Site Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.stores.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change POS Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/layout/boxed.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User Roles and Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.customergroups.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customer Groups</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.warehouses.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Warehouses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.tax_rate.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tax Rates</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.brands.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.units.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Units</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Products Manage
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.products.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.categories.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            Sales Manage
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.sales.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.sale-payments.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.return-sales.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Return Sales</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.deliveries.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Delivery</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.quotations.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Quotation Manage
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Purchases Manage
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.purchases.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.purchase-payments.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Payments</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.transfers.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>
                            Transfer Manage
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Member Manage
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.users.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.customers.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.billers.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Billers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.suppliers.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-link"></i>
                        <p>
                            Mapping Categories Manage
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.google-categories.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Google Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.facebook-categories.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Facebook Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>