<?php

 session_start();

$ruta = ControladorRuta::ctrRuta();
$servidor = ControladorRuta::ctrServidor();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Hotel</title>
    <base href="vistas/">
    <link rel="incon" href="img/icono.jpg">

    <!-- ==================================
        Vinculos CSS 
    =======================================-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Latest comliled and minified CSS: https://getbootstrap.com/ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- font aweson -->
    <script src="https://kit.fontawesome.com/9701adf998.js" crossorigin="anonymous"></script>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Fuente Opnes Sans y Ubuntu -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Ubuntu:wght@300&display=swap"rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Ubuntu" rel="stylesheet">

    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="css/plugins/bootstrap-datepicker.standalone.min.css">

    <!-- jquery slider
    https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html -->
    <link rel="stylesheet" href="css/plugins/jquery.jdSlider.css">

    <!--  pano -->
    <link rel="stylesheet" href="css/plugins/jquery.pano.css">

    <!--  fullCalendar 
    <link rel="stylesheet" href="css/plugins/fullcalendar.min.css"> -->
    <link href='css/plugins/fullcalendar/main.css' rel='stylesheet' />

    <!-- Hoja de estilo personalizada -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/habitaciones.css">
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/reservas.css">




    <!-- ==================================
        Vinculos JS
    =======================================-->

    <!-- JQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Bootstrap datepicker -->
    <script src="js/plugins/bootstrap-datepicker.min.js"></script>

    <!-- https://easings.net/  efecto de movimientos-->
    <script src="js/plugins/jquery.easing.1.3.js"></script>

    <!-- https://markgoodyear.com/labs/scrollup/ tipo de scrollUP -->
    <script src="js/plugins/scrollUP.js"></script>

    <!-- slider plugins 
    https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html-->
    <script src="js/plugins/jquery.jdSlider-latest.js"></script>

    <!-- pano
    https://www.jqueryscript.net/demo/360-Degree-Panoramic-Image-Viewer-with-jQuery-Pano/ -->
    <script src="js/plugins/jquery.pano.js"></script>

    <!-- fullCalendar -->
    <script src='js/plugins/fullcalendar/main.js'></script>

    <!-- Momentjs -->
    <script src="js/plugins/moment.js"></script>

    <!-- pago -->
    <script src="js/pago.js"></script>

    <!-- usuario -->
    <script src="js/usuario.js"></script>


    <!-- sweet alert -->
    <!-- https://sweetalert2.github.io/ -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <?php
    include "paginas/modulos/header.php";
    include "paginas/modulos/modales.php";

    if (isset($_GET["pagina"])) {

        //error_log("Desde plantilla _GET[pagina]: ".$_GET["pagina"], 0);

        $rutasCategorias = ControladorCategorias::ctrlMostrarCategorias();
        $validarRuta = "";

        foreach ($rutasCategorias as $key => $valor) {
            if ($_GET["pagina"] == $valor["ruta"]) {

                $validarRuta = "habitaciones";
            }
        }

        /**
         * validar correo para el login
         */
        $item = "email_encriptado";
        $valor = $_GET["pagina"];

        //error_log("Item: ".$item." valor: ".$valor, 0);

        $validarCorreo = ControladorUsuario::ctrlMostrarUsuario($item, $valor);

        //error_log("validarCorreo: ".$validarCorreo, 0);

        if (isset($validarCorreo["email_encriptado"]) && isset($_GET["pagina"])) {
            if ($validarCorreo["email_encriptado"] == $_GET["pagina"]) {

                $id = $validarCorreo["id_u"];
                $item = "verificacion";
                $varificarUsario = ControladorUsuario::ctrlActualizarUsuario($id, $item, 1);
                echo '
                        <script>
                            Swal.fire({
                                icon: "success",
                                title: "Su cuenta ha sido confirmada",
                                text: "¡Ya puede ingresar al sistema!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if(result.value){
                                    //history.back();
                                    window.location="' . $ruta . '";
                                }
                            })
                        </script>
                        ';
                return;
            }
        }

        //lista blanca de paginas internas
        if ($_GET["pagina"] == "reservas" || $_GET["pagina"] == "perfil" || $_GET["pagina"] == "salir") {
            
            //error_log("redirigue a: "."paginas/" . $_GET["pagina"] . ".php", 0);

            include "paginas/" . $_GET["pagina"] . ".php";

        } else if ($validarRuta != "") {

            //error_log("redirigue a: paginas/habitaciones.php", 0);

            include "paginas/habitaciones.php";
        } else {

            echo '<script>
                    window.location = "' . $ruta . '"
                  </script>';
        }
    } else {
        include "paginas/inicio.php";
    }

    include "paginas/modulos/contactenos.php";
    include "paginas/modulos/mapa.php";
    include "paginas/modulos/footer.php";

    ?>

    <!-- le paso por medio de un input valores a js, en este caso la URL del proyecto -->
    <!-- lo seteo en el 1er archivo de js, en este caso script.js -->
    <input type="hidden" value="<?php echo $ruta; ?>" id="urlPrincipal">
    <input type="hidden" value="<?php echo $servidor; ?>" id="urlServidor">

    <script src="js/script.js"></script>
    <script src="js/habitaciones.js"></script>
    <script src="js/reservas.js"></script>
    <script src="js/pago.js"></script>
    <script src="js/usuario.js"></script>
    <!-- <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script> -->

    <!-- facebook -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '1474179063051347',
                xfbml: true,
                version: 'v14.0'
            });
            FB.AppEvents.logPageView();
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>



</body>

</html>