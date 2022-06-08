<!DOCTYPE html>
<html lang="en">
<head>
    <title>Acceder</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="includes/util.css">
    <link rel="stylesheet" type="text/css" href="includes/main.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-form-title" style="background-image: url(includes/bg-01.jpg);">
                    <span class="login100-form-title-1">
                        <img src="../images/logo.svg" style="width: 100%;">
                    </span>
                </div>
                <form class="login100-form validate-form" method="POST" action="validarUsuario.php">
                    <span class="login100-form-title-1">Iniciar sesión</span><br><br><br>
                    <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                        <span class="label-input100">Usuario</span>
                        <input class="input100" type="text" name="username" placeholder="Correo electrónico corporativo">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
                        <span class="label-input100">Contraseña</span>
                        <input class="input100" type="password" name="pass" placeholder="Contraseña asignada">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="container-login100-form-btn">
                        <input type="submit" name="Acceder" value="Acceder" class="login100-form-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
