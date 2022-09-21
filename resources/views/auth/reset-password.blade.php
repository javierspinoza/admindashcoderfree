<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link
        href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;500;700;800&display=swap"
        rel="stylesheet"/>
        <link
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp"
        crossorigin="anonymous"
        />
        <link rel="stylesheet" href="{{ asset('assets/libraryJavierSpinoza/resetPassword/css/main.css')}}" />
        <link rel="stylesheet" href="{{ asset('assets/libraryJavierSpinoza/resetPassword/css/normalize.css')}}" />
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/LogoPro.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/LogoPro.png') }}">
        <title>Beyond Limits</title>
    </head>
    <body>
        <x-jet-validation-errors class="mb-4" style="margin: 40px 20px 0px 55px; color: #6c1aef; font-size: 20px" />
        <main class="login-design">
            <div class="waves">
                <img src="{{ asset('assets/libraryJavierSpinoza/resetPassword/img/loginPerson.png')}}" alt="" />
            </div>
            <div class="login">
                <div class="login-data">
                    <img src="{{ asset('assets/libraryJavierSpinoza/resetPassword/img/collab.png')}}" alt="" />
                    <h1>Restablecer Contraseña</h1>
                    <form method="POST" action="{{ route('password.update') }}" class="login-form">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        
                        <div class="input-group">
                            <label class="input-fill">
                                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                                <span class="input-label">Correo Electrónico</span>
                                <i class="fas fa-envelope"></i>
                            </label>
                        </div>
                        <div class="input-group">
                            <label class="input-fill">
                                <input type="password" name="password" id="password" required autocomplete="new-password" />
                                <span class="input-label">Nueva Contraseña</span>
                                <i class="fas fa-lock"></i>
                            </label>
                        </div>
                        <div class="input-group">
                            <label class="input-fill">
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"  />
                                <span class="input-label">Confirmar Contraseña</span>
                                <i class="fas fa-lock"></i>
                            </label>
                        </div>
                        <button class="btn-login">Restablecer contraseña</button>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>
