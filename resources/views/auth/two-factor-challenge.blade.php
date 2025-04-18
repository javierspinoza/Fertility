<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assetsDashboard/assetsHome/login/img/LogoPro.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assetsDashboard/assetsHome/login/img/LogoSpinoza.png') }}">
    <title>
        FERTILITY
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assetsDashboard/assetsHome/login/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assetsDashboard/assetsHome/login/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assetsDashboard/assetsHome/login/css/material-dashboard.min.css') }}" rel="stylesheet" />
</head>

<body class="bg-gray-200">

    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 m-3 border-radius-lg"
            style="background-image: url('{{ asset('assetsDashboard/assetsHome/login/img/recovery.jpg') }}');">
            <span class="mask bg-gradient-dark opacity-6"></span>
        </div>
        <div class="container mb-4">
            <div class="row mt-lg-n12 mt-md-n12 mt-n12 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card mt-8">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 pe-1 text-center py-4">
                                <h3 class="font-weight-bolder text-white mb-0">Segundo Paso de Verificación</h3>
                            </div>
                        </div>
                        <div class="card-body py-4">
                            <x-validation-errors class="mb-4" />
                            <form method="POST" action="{{ route('two-factor.login') }}">
                                @csrf
                                <div class="row gx-2 gx-sm-3 mt-3 mb-3">
                                    <div class="input-group mb-3">
                                        <input type="text" placeholder="Código" name="code" autofocus
                                            class="form-control is-valid">
                                    </div>
                                </div>
                                <div class="row gx-2 gx-sm-3 mt-3 mb-3" id="recovery-code-container"
                                    style="display:none">
                                    <div class="input-group mb-3">
                                        <input type="text" placeholder="Código de recuperación" name="recovery_code" autofocus
                                            class="form-control is-valid">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100">Verificar Código</button>
                                    <span class="text-muted fw-bold text-sm" id="show-recovery-code-link"> Usa un código
                                        de
                                        recuperación</span>
                                    <span class="text-muted fw-bold text-sm" id="show-authentication-code-link"
                                        style="display:none;"> Usar un código de autenticación</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer position-absolute bottom-2 py-2 w-100">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            Desarrollado por
                            <a href="#" class="font-weight-bold">Javier Spinoza</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="#" class="nav-link text-muted"> Todos los derechos reservados</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <script>
        // Obtenemos los elementos que necesitamos
        const recoveryCodeContainer = document.getElementById('recovery-code-container');
        const showRecoveryCodeLink = document.getElementById('show-recovery-code-link');
        const showAuthenticationCodeLink = document.getElementById('show-authentication-code-link');

        // Agregamos el evento click al primer enlace
        showRecoveryCodeLink.addEventListener('click', function() {
            // Mostramos el segundo input y el segundo enlace
            recoveryCodeContainer.style.display = 'block';
            showAuthenticationCodeLink.style.display = 'inline';

            // Ocultamos el primer input y el primer enlace
            showRecoveryCodeLink.style.display = 'none';
            document.getElementsByName('code')[0].parentNode.parentNode.style.display = 'none';
        });

        // Agregamos el evento click al segundo enlace
        showAuthenticationCodeLink.addEventListener('click', function() {
            // Mostramos el primer input y el primer enlace
            showRecoveryCodeLink.style.display = 'inline';
            document.getElementsByName('code')[0].parentNode.parentNode.style.display = 'block';

            // Ocultamos el segundo input y el segundo enlace
            recoveryCodeContainer.style.display = 'none';
            showAuthenticationCodeLink.style.display = 'none';
        });
    </script>

    <!--   Core JS Files   -->
    <script src="{{ asset('assetsDashboard/assetsHome/login/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assetsDashboard/assetsHome/login/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assetsDashboard/assetsHome/login/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assetsDashboard/assetsHome/login/js/plugins/smooth-scrollbar.min.js') }}"></script>
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
    <script src="{{ asset('assetsDashboard/assetsHome/login/js/material-dashboard.min.js') }}"></script>
</body>

</html>