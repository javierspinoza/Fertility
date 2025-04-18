<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('farm.index') }}" class="brand-link">
        <img src="{{ secure_asset('assetsDashboard/assets/img/LogoSpinoza.png') }}" alt="Javier Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Fertility</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @canany(['permission_admin', 'role_admin'])
                    <li class="nav-item {{ request()->routeIs('permissions.*', 'roles.*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('permissions.*', 'roles.*') ? 'active1' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Roles y Permisos
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('permissions.index') }}"
                                    class="nav-link {{ request()->routeIs('permissions.*') ? 'active bg-info' : '' }}">
                                    <i class="fas fa-user-cog"></i>
                                    <p>Permisos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}"
                                    class="nav-link {{ request()->routeIs('roles.*') ? 'active bg-info' : '' }}">
                                    <i class="fas fa-user-lock"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @can('notificacion_admin')
                    <li class="nav-item">
                        <a href="{{ route('notifys.index') }}"
                            class="nav-link {{ request()->routeIs('notifys.*') ? 'active bg-info' : '' }}">
                            <i class="fas fa-sms"></i>
                            <p>
                                Notificaciones
                            </p>
                        </a>
                    </li>
                @endcan
                @can('user_show')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ request()->routeIs('users.*') ? 'active bg-info' : '' }}">
                            <i class="fas fa-user-shield"></i>
                            <p>
                                Usuarios
                            </p>
                        </a>
                    </li>
                @endcan
                @canany(['fincas_show', 'ganado_show'])
                    <li class="nav-item {{ request()->routeIs('farm.*', 'livestock.*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('farm.*', 'livestock.*') ? 'active1' : '' }}">
                            <i class="fab fa-safari" style="font-size: 21px"></i>
                            <p>
                                Fincas y Ganaderia
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('fincas_show')
                                <li class="nav-item">
                                    <a href="{{ route('farm.index') }}"
                                        class="nav-link {{ request()->routeIs('farm.*') ? 'active bg-info' : '' }}">
                                        <i class="fas fa-hat-cowboy"></i>
                                        <p>Fincas</p>
                                    </a>
                                </li>
                            @endcan
                            @can('ganado_show')
                                <li class="nav-item">
                                    <a href="{{ route('livestock.index') }}"
                                        class="nav-link {{ request()->routeIs('livestock.*') ? 'active bg-info' : '' }}">
                                        <i class="fas fa-hippo"></i>
                                        <p>Ganaderia</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @can('trabajo_show')
                    <li class="nav-item">
                        <a href="{{ route('work.index') }}"
                            class="nav-link {{ request()->routeIs('work.*') ? 'active bg-info' : '' }}">
                            <i class="fas fa-map-marked-alt"></i>
                            <p>
                                Trabajos
                            </p>
                        </a>
                    </li>
                @endcan
                @can('pagos_show')
                    <li class="nav-item">
                        <a href="{{ route('paymentHistorys.index') }}"
                            class="nav-link {{ request()->routeIs('paymentHistorys.*') ? 'active bg-info' : '' }}">
                            <i class="fas fa-dollar-sign"></i>
                            <p>
                                Pagos
                            </p>
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
