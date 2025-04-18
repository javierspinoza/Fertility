<!DOCTYPE html>
<html>

<head>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assetsDashboard/assetsHome/login/img/LogoPro.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assetsDashboard/assetsHome/login/img/LogoPro.png') }}">
    <title>FERTILITY</title>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assetsDashboard/assetsHome/login/libraryJavierSpinoza/confirmAndResetPassword/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <x-validation-errors class="mb-4" style="margin: 40px 20px 0px 55px; color: #32be8f; font-size: 20px" />
    <img class="wave" src="{{ asset('assetsDashboard/assetsHome/login/libraryJavierSpinoza/confirmAndResetPassword/img/wave.png') }}">
    <div class="container">
        <div class="img">
            <img src="{{ asset('assetsDashboard/assetsHome/login/libraryJavierSpinoza/confirmAndResetPassword/img/bg.svg') }}">
        </div>
        <div class="login-content">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <img src="{{ asset('assetsDashboard/assetsHome/login/libraryJavierSpinoza/confirmAndResetPassword/img/avatar.svg') }}">
                <h2 style="font-size: 30px" class="title">Recuperar contraseña</h2>
                <p style="max-width: 650px; margin-block-end: 30px;">
                    ¿Olvidaste tu contraseña? No hay problema. Simplemente háganos saber
                    su dirección de correo electrónico y le enviaremos un enlace de
                    restablecimiento de contraseña que le permitirá elegir una nueva.
                </p>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Email de usuario</h5>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                            class="input">
                    </div>
                </div>
                {{-- <a href="#">Forgot Password?</a> --}}
                <button class="btn">Enviar</button>
                {{-- <button class="btn">Enviar</button> --}}
                <a href="{{ route('login') }}" class="css-button-gradient--5">INICIO</a>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('assetsDashboard/assetsHome/login/libraryJavierSpinoza/confirmAndResetPassword/js/main.js') }}">
    </script>
</body>

</html>
