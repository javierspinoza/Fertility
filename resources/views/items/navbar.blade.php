<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        @if (request()->is('notifys*') ||
                request()->is('permissions*') ||
                request()->is('roles*') ||
                request()->is('users*') ||
                request()->is('fincas*') ||
                request()->is('ganaderia*') ||
                request()->is('trabajos*') ||
                request()->is('pagos*'))
            <!-- Mostrar el primer elemento de navegación -->
            <li wire:ignore class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        @endif

        @if (request()->is('notifys*'))
            <!-- Mostrar elementos de notificaciones -->
            <li class="nav-item">
                <!-- Elemento de notificaciones -->
                <a href="#" class="nav-link">Notificaciones</a>
            </li>
        @elseif(request()->is('permissions*'))
            <!-- Mostrar elementos de permisos -->
            <li class="nav-item">
                <!-- Elemento de permisos -->
                <a href="#" class="nav-link">Permisos</a>
            </li>
        @elseif(request()->is('roles*'))
            <!-- Mostrar elementos de roles -->
            <li class="nav-item">
                <!-- Elemento de roles -->
                <a href="#" class="nav-link">Roles</a>
            </li>
        @elseif(request()->is('users*'))
            <!-- Mostrar elementos de usuarios -->
            <li class="nav-item">
                <!-- Elemento de usuarios -->
                <a href="#" class="nav-link">Usuarios</a>
            </li>
        @elseif(request()->is('fincas*'))
            <!-- Mostrar elementos de fincas -->
            <li class="nav-item">
                <!-- Elemento de fincas -->
                <a href="#" class="nav-link">Fincas</a>
            </li>
        @elseif(request()->is('ganaderia*'))
            <!-- Mostrar elementos de ganadería -->
            <li class="nav-item">
                <!-- Elemento de ganadería -->
                <a href="#" class="nav-link">Ganadería</a>
            </li>
        @elseif(request()->is('trabajos*'))
            <!-- Mostrar elementos de trabajos -->
            <li class="nav-item">
                <!-- Elemento de trabajos -->
                <a href="#" class="nav-link">Trabajos</a>
            </li>
        @elseif(request()->is('pagos*'))
            <!-- Mostrar elementos de pagos -->
            <li class="nav-item">
                <!-- Elemento de pagos -->
                <a href="#" class="nav-link">Pagos</a>
            </li>
        @endif
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        {{-- cerrar sesion de usuario --}}
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-sign-out-alt"></i>
                <span class="badge badge-danger navbar-badge"></span>
                <span class="d-none d-sm-inline"><strong>{{ Auth::user()->name }}</strong></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ Auth::user()->profile_photo_url ?: asset('assets/img/default-user-image.jpg') }}"
                            alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                <strong>{{ Auth::user()->name }}</strong>
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm"></p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>
                                {{ Carbon\Carbon::parse(Auth::user()->last_seen)->diffForHumans() }}</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('profile.show') }}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <button type="button" class="btn btn-sm btn-outline-info btn-lg btn-block">Ver perfil</button>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <!-- Message Start -->
                    <div class="media">
                        <button type="button" class="btn btn-sm btn-outline-info btn-lg btn-block">Cerrar sesión</button>
                    </div>
                    <!-- Message End -->
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <div class="dropdown-divider"></div>
            </div>
        </li>
        <!-- Messages Dropdown Menu -->
        {{-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ secure_asset('assetsDashboard/dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ secure_asset('assetsDashboard/dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ secure_asset('assetsDashboard/dist/img/user3-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li> --}}
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell" style="font-size: 25px"></i>
                @if (count(auth()->user()->unreadNotifications))
                    @php
                        $unreadNotifications = auth()->user()->unreadNotifications;
                        $unreadNotificationsCount = 0;
                        $elevenHoursAgo = now()->subHours(11);
                        $elevenHoursLater = now()->addHours(36);
                        foreach ($unreadNotifications as $notification) {
                            $data = is_array($notification->data)
                                ? json_decode(json_encode($notification->data))
                                : json_decode($notification->data);
                            $notificationDate = Carbon\Carbon::parse($data->date_work);
                            if ($notificationDate->between($elevenHoursAgo, $elevenHoursLater)) {
                                $unreadNotificationsCount++;
                            }
                        }
                    @endphp
                    @if ($unreadNotificationsCount > 0)
                        <span class="badge badge-danger navbar-badge"
                            style="font-size: 12px">{{ $unreadNotificationsCount }}</span>
                    @endif
                @endif
            </a>
            {{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div> --}}
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
