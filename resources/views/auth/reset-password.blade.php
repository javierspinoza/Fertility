<x-guest-layout>
</x-guest-layout>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="{{ secure_asset('assetsDashboard/assetsHome/resetpassword/micss.css') }}">
    <title>Fertility Colombia</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <x-validation-errors class="mb-4" />
                <form method="POST" action="{{ route('password.update') }}" class="sign-in-form">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <h2 class="title">Restablecer contraseña</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" name="email" placeholder="Username" value="{{ old('email', $request->email) }}" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                            placeholder="Password" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            autocomplete="new-password" placeholder="Confirmar contraseña" />
                    </div>
                    <button type="submit" class="btn solid">RESTABLECER CONTRASEÑA</button>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Restablece tu contraseña aquí</h3>
                    <p>
                        Ingresa tu nueva contraseña
                    </p>
                </div>
                <img src="{{ secure_asset('assetsDashboard/assetsHome/resetpassword/img/log.svg') }}" class="image"
                    alt="" />
            </div>
        </div>
    </div>

    <script src="app.js"></script>
    <script src="{{ secure_asset('assetsDashboard/assetsHome/resetpassword/mijs.js') }}"></script>
</body>

</html>
