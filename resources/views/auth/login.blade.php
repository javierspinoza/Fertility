<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ secure_asset('assets/img/LogoPro.png') }}">
    <link rel="icon" href="{{ secure_asset('homefertility/imagenes/logo_fertility.jpg') }}">
    <title>
        Fertility
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ secure_asset('assetsDashboard/assetsHome/login/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ secure_asset('assetsDashboard/assetsHome/login/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ secure_asset('assetsDashboard/assetsHome/login/css/material-dashboard.min.css') }}" rel="stylesheet" />
</head>

<body class="bg-gray-200">

    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('{{ secure_asset('assetsDashboard/assetsHome/login/img/imagen_login.avif') }}');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Inicia sesión</h4>
                                    <div class="row mt-3">
                                        <div class="col-2 text-center ms-auto">
                                            <a class="btn btn-link px-3" href="javascript:;">
                                                <i class="fa fa-facebook text-white text-lg"></i>
                                            </a>
                                        </div>
                                        <div class="col-2 text-center px-1">
                                            <a class="btn btn-link px-3" href="javascript:;">
                                                <i class="fa fa-github text-white text-lg"></i>
                                            </a>
                                        </div>
                                        <div class="col-2 text-center me-auto">
                                            <a class="btn btn-link px-3" href="javascript:;">
                                                <i class="fa fa-google text-white text-lg"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <x-validation-errors class="mb-4" />
                                <form method="POST" action="{{ route('login') }}" role="form" class="text-start">
                                    @csrf
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Email</label>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                                            required autofocus autocomplete="email" class="form-control">
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Password</label>
                                        <input id="password" type="password" name="password" required
                                            autocomplete="current-password" class="form-control">
                                    </div>
                                    <div class="form-check form-switch d-flex align-items-center mb-3">
                                        <input class="form-check-input" type="checkbox" id="rememberMe">
                                        <label class="form-check-label mb-0 ms-2" for="rememberMe">Recordar
                                            datos</label>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn bg-gradient-info w-100 my-4 mb-2">Iniciar</button>
                                    </div>
                                    <p class="mt-4 text-sm text-center">
                                        Olvidaste tu contraseña?
                                        <a href="{{ route('password.request') }}"
                                            class="text-info text-gradient font-weight-bold">Recuperala</a>
                                    </p>
                                </form>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('fertility.index') }}" class="btn btn-sm  bg-gradient-info  mb-0"
                                        onclick="smoothToPricing('pricing-soft-ui')">Ir al inicio</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer position-absolute bottom-2 py-2 w-100">
                <div class="container">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-12 col-md-6 my-auto">
                            <div class="copyright text-center text-sm text-white text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>,
                                Desarrollado por
                                <a href="#" class="font-weight-bold text-white">Javier Spinoza</a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                <li class="nav-item">
                                    <a href="#" class="nav-link text-white">Todos los derechos reservados</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>

    <!--   Core JS Files   -->
    <script src="{{ secure_asset('assetsDashboard/assetsHome/login/js/core/popper.min.js') }}"></script>
    <script src="{{ secure_asset('assetsDashboard/assetsHome/login/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ secure_asset('assetsDashboard/assetsHome/login/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ secure_asset('assetsDashboard/assetsHome/login/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ secure_asset('assetsDashboard/assetsHome/login/js/material-dashboard.min.js') }}"></script>
</body>

</html>
