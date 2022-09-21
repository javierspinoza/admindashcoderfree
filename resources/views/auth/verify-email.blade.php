<!DOCTYPE html>
<html>
<head>
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/LogoPro.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/LogoPro.png') }}">
	<title>Beyond Limits</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/libraryJavierSpinoza/confirmAndResetPassword/css/style.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    @if (session('status') == 'verification-link-sent')
        <div style="margin: 30px 0px 0 50px; color: #32be8f; font-size: 20px" class="mb-4 font-medium text-sm text-success">
            {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionó durante el registro.') }}
        </div>
    @endif
	<img class="wave" src="{{ asset('assets/libraryJavierSpinoza/confirmAndResetPassword/img/wave.png') }}">
	<div class="container">
		<div class="img">
			<img src="{{ asset('assets/libraryJavierSpinoza/confirmAndResetPassword/img/bg.svg') }}">
		</div>
		<div class="login-content">
			<div class="miForm">
                <img src="{{ asset('assets/libraryJavierSpinoza/confirmAndResetPassword/img/avatar.svg') }}">
				<h2 class="title">verificación</h2>
                <div class="input-div one text-center mb-0">
                    <h6 class="text-center mb-0"></h6>
                    <span style="font-size: 15px" class="ms-2 me-2">Gracias por registrarte! Antes de comenzar, ¿podría verificar su dirección 
                        de correo electrónico haciendo clic en el enlace que le acabamos de enviar a tu correo? Si no 
                        recibiste el correo electrónico, con gusto te enviaremos otro.
                    </span>
                </div>
                <div class="pass">
                    <form method="POST" class="miForm margin-div" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btnVery btn-primary">Reenviar email de verificación</button>
                    </form><br><br>
        
                    <form method="POST" class="miForm" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('assets/libraryJavierSpinoza/confirmAndResetPassword/js/main.js')}}"></script>
</body>
</html>
