<?php
/* 
$jsonKey = [
    "web" => [
            "client_id" => "792985027927-m8iuh3cpistnl8g18qr014b85l6ni3j5.apps.googleusercontent.com",
            "project_id" => "reservas-362018",
            "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
            "token_uri" => "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
            "client_secret" => "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",
            "redirect_uris" => [
                "https://localhost/ReservaDeHotel.MVC"
            ],
        ]
        ];
 */


$jsonKey = [

    "client_id" => "792985027927-m8iuh3cpistnl8g18qr014b85l6ni3j5.apps.googleusercontent.com",
    "project_id" => "reservas-362018",
    "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
    "token_uri" => "https://oauth2.googleapis.com/token",
    "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
    "client_secret" => "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",
    "redirect_uris" => [
        "https://localhost/ReservaDeHotel.MVC"
    ],
];


/**creaobjeto de api de google */
$cliente = new Google\Client();
$cliente->setAuthConfig($jsonKey);
$cliente->setAccessType("offline");
$cliente->setScopes(['profile', 'email']);

/**ruta para el login de google */
$rutaGoogle = $cliente->createAuthUrl();

/**recibo la variable get de google llamada code */
if (isset($_GET['code'])) {
    $token = $cliente->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['id_token_google'] = $token;
    $cliente->setAccessToken($token);
    /* 
    $item = $cliente->verifyIdToken();
    ver($item);
     */
}

if ($cliente->getAccessToken()) {
    $item = $cliente->verifyIdToken();
    //ver ($item);
    $datos = array(
        "nombre" => $item["name"],
        "email" => $item["email"],
        "foto" => $item["picture"],
        "password" => null,
        "modo" => "google",
        "verificacion" => 1,
        "email_encriptado" => null
    );
    $respuesta = ControladorUsuario::ctrlRegistroRedesSociales($datos);

    if ($respuesta == "ok") {

        echo '<script>

                setTimeout(function(){
                    window.location = "' . $ruta . 'perfil";
                }, 1000)

                

             </script>';
    }
}

?>


<!-- ********************
        ventanas modal PLANES
    ************************-->
<div class="modal" id="modalPlanes">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h4 class="modal-title text-uppercase"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img src="" class="img-thumbnail">
                <p class="py-3"></p>
                <div class="text-center">
                    <a href="#habitaciones" class="btn btn-primary text-center btnModalPlan" data-dismiss="modal">Reserva tu habitación</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- ********************
        ventanas modal ingreso
    ************************-->

<div class="modal formulario" id="modalIngreso">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Ingresar</h5>
                <button type="button" class="btn-close text-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- ******
                        Ingreso con Redes Sociales
                    ******************************-->
                <div class="d-flex">
                    <div class="px-2 flex-fill">
                        <p class="p-2 bg-primary text-center text-white facebook" style="cursor:pointer">
                            <i class="fa fa-facebook"></i>
                            - Ingreso con FaceBook
                        </p>
                    </div>
                    <div class="px-2 flex-fill">
                        <!--credenciales google: https://console.cloud.google.com/apis/credentials
                                
                                 https://github.com/googleapis/google-api-php-client
                                 Descarga api google php -->

                        <a href="<?php echo $rutaGoogle; ?>">
                            <p class="p-2 bg-danger text-center text-white" style="cursor:pointer">
                                <i class="fa fa-google"></i>
                                - Ingreso con Google
                            </p>
                        </a>
                    </div>

                </div>

                <!-- ******
                        Ingreso Directo
                    ******************************-->
                <hr class="mt-0">


                <form method="POST">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-at"></i>
                        </span>
                        <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" name="ingresoEmail" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" name="ingresoPassword" required>
                    </div>

                    <div class="text-center pb-3">
                        <a href="#modalRecuperarPassword" data-toggle="modal" data-dismiss="modal">
                            ¿olvidó la password?
                        </a>
                    </div>


                    <input type="submit" class="btn btn-dark btn-block" value="Ingresar">
                    <?php

                    $ingresoUsuario = new ControladorUsuario();
                    $ingresoUsuario->ctrlIngresoUsuario();

                    ?>

                </form>


            </div>
            <div class="modal-footer">
                ¿No tienes una cuenta registrada? |
                <strong>
                    <a href="#modalRegistro" data-toggle="modal" data-dismiss="modal">
                        Registrarse
                    </a>
                </strong>
            </div>
        </div>
    </div>
</div>





<!-- ********************
        ventanas modal Registro
    ************************-->

<div class="modal formulario" id="modalRegistro">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Registrarse</h5>
                <button type="button" class="btn-close text-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- ******
                        Ingreso con Redes Sociales
                    ******************************-->
                <div class="d-flex">
                    <div class="px-2 flex-fill">
                        <p class="p-2 bg-primary text-center text-white facebook" style="cursor:pointer">
                            <i class="fa fa-facebook"></i>
                            - Ingreso con FaceBook
                        </p>
                    </div>
                    <div class="px-2 flex-fill">
                        <!--credenciales google: https://console.cloud.google.com/apis/credentials 
                                
                                https://github.com/googleapis/google-api-php-client
                                 Descarga api google php -->

                        <a href="<?php echo $rutaGoogle; ?>">
                            <p class="p-2 bg-danger text-center text-white" style="cursor:pointer">
                                <i class="fa fa-google"></i>
                                - Ingreso con Google
                            </p>
                        </a>
                    </div>

                </div>

                <!-- ******
                        Registro Directo
                    ******************************-->
                <hr class="mt-0">


                <form method="POST">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Nombre" name="registroNombre" aria-label="Nombre" aria-describedby="basic-addon1" required>
                    </div>


                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-at"></i>
                        </span>
                        <input type="email" class="form-control" placeholder="Email" name="registroEmail" aria-label="Email" aria-describedby="basic-addon1" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <input type="password" class="form-control" placeholder="Password" name="registroPassword" aria-label="Password" aria-describedby="basic-addon1" required>
                    </div>

                    <input type="submit" class="btn btn-dark btn-block" value="Registrarse">
                    <?php
                    $regsitroUsuario = new ControladorUsuario();
                    $regsitroUsuario->ctrRegistroUsuario();
                    ?>

                </form>


            </div>
            <div class="modal-footer">
                ¿Ya tienes una cuenta registrada? |
                <strong>
                    <a href="#modalIngreso" data-toggle="modal" data-dismiss="modal">
                        Ingresar
                    </a>
                </strong>
            </div>
        </div>
    </div>
</div>

<!-- Recuperar Password -->
<div class="modal formulario" id="modalRecuperarPassword">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Recuperar Password</h5>
                <button type="button" class="btn-close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <p class="text-muted">Escriba si correo electrónico con el q está registrado y alli le enviaremos una nueva password</p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-envelope"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" placeholder="Email" name="emailRecuperarPassword" required>
                    </div>
                    <input type="submit" class="btn btn-dark btn-block" value="Enviar">
                    <?php
                        $recuperarPassword = new ControladorUsuario();
                        $recuperarPassword -> ctrRecuperarPassword();
                    ?>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>