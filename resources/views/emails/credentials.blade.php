<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Credenciales</title>
</head>
<body style="background-color: rgb(98, 95, 95) ">

<table style="background-color: #ecf0f1;max-width: 600px; padding: 15px; margin:0 auto; border-collapse: collapse;">
	<tr>
		<td style="background-color: #ecf0f1; text-align: left; padding: 0px">
			<a href="https://www.facebook.com/PokemonTrujillo/">
				<img width="20%" style="display:block;object-fit:cover; margin: 1.5% 3%" src="{{ $message->embed($pathToImage) }}">
			</a>
		</td>
	</tr>

    <tr>
        <td style="padding :10px 20px;padding-bottom:35px!important; font-size: 16px;">
            <h2 style="text-align:center;color:rgb(77, 74, 74)">Driver Detect</h2>
            <hr>
            <p style="margin-top: 10px">
                Bienvenido {{$name}} a Driver Detect, tu sistema de monitoreo personal. Por favor, guarda tus credenciales de acceso para poder iniciar sesion.
            </p>

            <h4 style="margin-top :10px;color:rgb(77, 74, 74)">Credenciales</h4>
            <p><strong>E-mail:</strong> {{$email}}</p>
            <p><strong>Contraseña:</strong> {{$tempassword}}</p>

            <p style="margin-top:20px">Puedes iniciar sesion en Driver Detect pulsando el boton</p>
            <a target="_blank" href="https://www.driverdetect.railway.app/login"
               style="margin-bottom :20px ;background: #141E30;background: -webkit-linear-gradient(to right, #243B55, #141E30);background: linear-gradient(to right, #243B55, #141E30);padding:7px 5px;color:white;font-weight: bold;text-decoration: none;">
               Iniciar sesion
            </a>
        </td>
    </tr>

</table>
</body>
</html>