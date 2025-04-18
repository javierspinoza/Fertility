<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ secure_asset('assetsDashboard/assetsHome/login/img/LogoPro.png') }}">
    <link rel="icon" type="image/png" href="{{ secure_asset('assetsDashboard/assetsHome/login/img/LogoPro.png') }}">
    <title>
        Ferlity Colombia
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
    <link id="pagestyle" href="{{ secure_asset('assetsDashboard/assetsHome/login/css/material-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                {{-- <nav class="navbar navbar-expand-lg blur border-radius-xl top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid ps-2 pe-0">
                        <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="../pages/dashboard.html">
                        Javier Spinoza
                        </a>
                        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navigation">
                            <ul class="navbar-nav mx-auto">
                                <li class="nav-item">
                                    <a class="nav-link me-2" href="{{ route('register') }}">
                                        <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                        Registrar Usuarios
                                    </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link me-2" href="{{ route('login') }}">
                                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                    Iniciar sesión
                                </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav> --}}
                <!-- End Navbar -->
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                                style="background-image: url('../assetsDashboard/assetsHome/login/img/illustrations/illustration-signup.jpg'); background-size: cover;">
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                            <div class="card card-plain">
                                <div class="card-header">
                                    <h4 class="font-weight-bolder">Registrate aquí</h4>
                                    <p class="mb-0">Escribe aqui tus credenciales de registro</p>
                                </div>
                                <div class="card-body">

                                    <x-validation-errors class="mb-4" />

                                    <form method="POST" action="{{ route('register') }}" role="form">
                                        @csrf

                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Name</label>
                                            <input id="name" type="text" name="name" :value="old('name')"
                                                required autofocus autocomplete="name" class="form-control">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Email</label>
                                            <input id="email" type="email" name="email" :value="old('email')"
                                                required class="form-control">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <input id="password" type="password" name="password" required
                                                autocomplete="new-password" class="form-control">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Confirmar Contraseña</label>
                                            <input id="password_confirmation" type="password"
                                                name="password_confirmation" required autocomplete="new-password"
                                                class="form-control">
                                        </div>
                                        {{-- <div class="form-check form-check-info text-start ps-0">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                                            </label>
                                        </div> --}}
                                        <div class="text-center">
                                            <button
                                                class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Registrar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-2 text-sm mx-auto">
                                        Ya estas registrado?
                                        <a href="{{ route('login') }}"
                                            class="text-primary text-gradient font-weight-bold">Inicia sesión</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
