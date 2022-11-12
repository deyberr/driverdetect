<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('admin.layouts.head-css')
    <title>Forget Password</title>
</head>
<body>
    <h2>Olvidaste tu contraseña de email?</h2>
    <hr>
   
  Tu puedes restablecer tu contraseña haciendo click en el siguiente link:
   <a href="{{ route('reset.password.get', $token) }}">Restablecer contraseña</a>

</body>
</html>
