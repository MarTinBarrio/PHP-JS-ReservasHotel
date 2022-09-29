<?php

use Google\Service\ApigeeRegistry\Config;

$item = "id_u";
$valor = $_SESSION["id"];

$usuario = ControladorUsuario::ctrlMostrarUsuario($item, $valor);
$reservas = ControladorReservas::ctrlMostrarReservasUsuario($valor);

//error_log("reservas.count: ".count($reservas), 0);
//error_log("usuario: ".$usuario, 0);
/* 
foreach ($usuario as $key => $valor){
    error_log("Key: ".$key." Valor: ".$valor, 0);
}
  */
$hoy = date("Y-m-d");
$noVencidas = 0;
$vencidas = 0;

if (count($reservas)) {
    foreach ($reservas as $key => $valor) {
        if ($hoy >= $valor["fecha_ingreso"]) {
            ++$vencidas;
        } else {
            ++$noVencidas;
        }
    }
}

?>




<!-- *************
        Info Perfil
    ******************-->
<div class="infoPerfil container-fluid bg-white p-0 pb-5 pb-5">
    <div class="container">
        <div class="row">
            <!-- info bloque izquierda 
        *****************************************
    *********************************************
*****************************************************-->
            <div class="col-12 col-lg-4 colIzqPerfil p-0 px-lg-3 py-lg-3">
                <div class="cabeceraPerfil pt-4">
                    <?php if ($usuario["modo"] == "facebook") { ?>
                        <a href="#" class="float-left lead text-white pt-1 px-3 mb-4 salir">
                            <h5><i class="fas fa-chevron-left"></i>Salir</h5>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo $ruta; ?>salir" class="float-left lead text-white pt-1 px-3 mb-4">
                            <h5><i class="fas fa-chevron-left"></i>Salir</h5>
                        </a>
                    <?php } ?>

                    <div class="clearfix"></div>
                    <h1 class="text-white p-2 pb-lg-5 text-center text-lg-left">Mi Perfil</h1>
                </div>

                <!-- bloque perfil -->
                <div class="descripcionPerfil">
                    <figure class="text-center">
                        <?php if ($usuario["foto"] == "") { ?>
                            <img src="<?php echo $servidor; ?>vistas/img/usuarios/default.png" class="lazy img-fluid w-50">
                        <?php } else { ?>
                            <?php if ($usuario["modo"] == "directo") { ?>
                                <img src="<?php echo $servidor . $usuario["foto"]; ?>" class="lazy img-fluid w-50">
                            <?php } else { //google & facebook
                            ?>
                                <img src="<?php echo $usuario["foto"]; ?>" class="lazy img-fluid w-50">
                            <?php } ?>
                        <?php } ?>
                    </figure>

                    <div id="accordion" class="p-2">
                        <div class="card p-2">

                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Mis Reservas
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <ul class="card-body p-0">
                                    <li class="px-2 misReservas" style="background: #FFFDF4;"><?php echo $noVencidas; ?> Por vencerse</li>
                                    <li class="px-2 text-white misReservas" style="background: #CEC5B6;"><?php echo $vencidas; ?> Vencidas</li>
                                </ul>

                                <!-- Tabla reserva móvil -->
                                <?php

                                if (!count($reservas)) {


                                    echo '<div class="d-lg-none d-flex py-2">
                                                <div class="p-2 flex-grow-1">
                                                    <h5 style="color:black">Aún no tiene reservas realizadas</h5>
                                                </div>
                                        </div>';
                                    //return;
                                } else {

                                    foreach ($reservas as $key => $valor) { //<td></td>
                                        $habitacion = ControladorHabitaciones::ctrlMostrarHabitacion($valor["id_habitacion"]);
                                        $categoria = ControladorCategorias::ctrlMostrarCategoria($habitacion["tipo_h"]);
                                        echo '
                                                <div class="d-lg-none d-flex py-2">
                                                    <div class="p-2 flex-grow-1">
                                                        <h5>' . $categoria["tipo"] . " " . $habitacion["estilo"] . '</h5>
                                                        <h5 class="small text-gray-dark">Del ' . $valor["fecha_ingreso"] . ' al ' . $valor["fecha_salida"] . ' </h5>
                                                    </div>
                                                    <div class="p-2">
                                                        <button type="button" class="btn btn-dark btn-sm text-white">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-dark btn-sm text-white">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <hr class="my-0">
                                                ';
                                    }
                                }
                                ?>


                            </div>
                        </div>
                        <div class="card p-2">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Mis Datos
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                <div class="card-body p-0">
                                    <ul class="list-group">
                                        <li class="list-group-item small"><?php echo $usuario["nombre"]; ?></li>
                                        <li class="list-group-item small"><?php echo $usuario["email"]; ?></li>

                                        <?php if ($usuario["modo"] == "directo") { ?>

                                            <li class="list-group-item small">
                                                <button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#cambiarPassword">Cambiar PSW</button>
                                            </li>

                                            <!-- modal para cambiar password -->
                                            <div class="modal formulario" id="cambiarPassword">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Cambiar Password</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="idUsuarioPassword" value="<?php echo $_SESSION["id"]; ?>">
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control" placeholder="Nuevo Password" name="editarPassword" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-between">
                                                                <div>
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                                </div>
                                                                <div>
                                                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                                                </div>
                                                            </div>
                                                            <?php

                                                            $cambiaPassword = new ControladorUsuario();
                                                            $cambiaPassword->ctrCambiarPassword();

                                                            ?>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <li class="list-group-item small">
                                                <button class="btn btn-dark btn-lg" data-toggle="modal" data-target="#cambiarFotoPerfil">Cambiar Imagen</button>
                                            </li>

                                            <!-- modal para cambiar foto perfil -->
                                            <div class="modal formulario" id="cambiarFotoPerfil">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" enctype="multipart/form-data">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Cambiar Imagen</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="idUsuarioFoto" value="<?php echo $_SESSION["id"]; ?>">
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control-file border" name="cambiarImagen" required>
                                                                    <input type="hidden" value="<?php echo $usuario["foto"]; ?>" name="fotoActual" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-between">
                                                                <div>
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                                </div>
                                                                <div>

                                                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            $cambiaImagen = new ControladorUsuario();
                                                            $cambiaImagen->ctrCambiarFotoPerfil();

                                                            ?>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        } ?>

                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!--*****************************************
    *********************************************
*****************************************************-->

            <!-- info bloque derecha -->
            <div class="col-12 col-lg-8 colDerPerfil">
                <div class="row">
                    <div class="col-6 d-none d-lg-block">
                        <h4 class="d-inline">Hola <?php echo $usuario["nombre"]; ?></h4>
                        <h4 class="d-inline"> |
                            <?php if ($usuario["modo"] == "facebook") { ?>
                                <a href="#" class="salir"><span class="colorTitulos text-right">Salir</span></a>
                            <?php } else { ?>
                                <a href="<?php echo $ruta; ?>salir"><span class="colorTitulos text-right">Salir</span></a>
                            <?php } ?>
                        </h4>

                    </div>

                    <!-- bloque de pago de reserva -->
                    <?php

                    $hoy = date("Y-m-d");
                    $disponible = true;

                    //error_log("COOKIE[idHabitacion]: " . $_COOKIE["idHabitacion"], 0);

                    if (isset($_COOKIE["idHabitacion"])) {

                        $reservasEnDB = ControladorReservas::ctrlMostrarReservas($_COOKIE["idHabitacion"]);
                        if (!count($reservasEnDB)) {
                            $disponible = true;
                        } else {


                            foreach ($reservasEnDB as $key => $reservaEnDB) {

                                if ($reservaEnDB["fecha_ingreso"] == $_COOKIE["fechaIngreso"]) {
                                    $disponible = false;
                                }
                                if ($reservaEnDB["fecha_ingreso"] < $_COOKIE["fechaIngreso"] && $reservaEnDB["fecha_salida"] > $_COOKIE["fechaIngreso"]) {
                                    $disponible = false;
                                }
                                if ($reservaEnDB["fecha_ingreso"] < $_COOKIE["fechaSalida"] && $reservaEnDB["fecha_salida"] > $_COOKIE["fechaSalida"]) {
                                    $disponible = false;
                                }
                            }
                        }
                    }

                    if (isset($_COOKIE["codigoReserva"]) && !isset($_COOKIE["transferenciaEnviada"])) {


                        if ($hoy >= $_COOKIE["fechaIngreso"] || $hoy >= $_COOKIE["fechaSalida"]) {
                            echo '<div class="alert alert-danger">Lo sentimos, las fechas de reserva no pueden ser igual o inferior al día de hoy,
                                <a href=' . $ruta . ' class="btn btn-danger">vuelve a intentarlo</a></div>';
                            echo "<script>borrarCookies();</script>";
                        } else if ($disponible) {

                    ?>

                            <div class="card">
                                <div class="card-header">
                                    <h4>Tienes una reserva pediente por pagar</h4>
                                </div>
                                <div class="card-body text-center">
                                    <figure>
                                        <img src="<?php echo $_COOKIE["imgHabitacion"]; ?>" class="img-thumbnail w-50">
                                    </figure>
                                    <h3><strong><?php
                                                echo $_COOKIE["infoHabitacion"];
                                                echo $_COOKIE["personas"]; ?> Personas</strong></h3>
                                    <h4>Fechas: <?php echo $_COOKIE["fechaIngreso"] . " - " . $_COOKIE["fechaSalida"]; ?></h4>
                                    <h4>$ <?php echo $_COOKIE["pagoReserva"]; ?></h4>
                                </div>
                                <div class="card-footer d-flex">
                                    <!-- <button type="button" class="pagoMP btn btn-danger m-2"></button> -->
                                    <a href="#infoPago" data-toggle="modal" style="color:red;">Realizar Pago de Reserva</a>
                                </div>

                            </div>

                    <?php
                        } else {
                            echo '<div class="alert alert-danger">Lo sentimos, las fechas de reserva ya fueron ocupadas antes de su pago,
                                <a href=' . $ruta . ' class="btn btn-danger">vuelve a intentarlo</a></div>';
                            echo "<script>borrarCookies();</script>";
                        }
                    }


                    if (isset($_COOKIE["transferenciaEnviada"])) {
                        echo '
                        <script>
                            Swal.fire({
                                type:"success",
                                icon: "success",
                                title: "CORRECTO!",
                                text: "La Reserva ha sido exitosa.",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if(result.value){
                                    //history.back();
                                    window.location.reload();
                                }
                            })
                        </script>
                        ';
                        $descripción_reserva = $_COOKIE["infoHabitacion"] . " - " . $_COOKIE["plan"] . " - " . $_COOKIE["personas"] . " personas";
                        $datos = array(
                            "id_habitacion" => $_COOKIE["idHabitacion"],
                            "id_usuario" => $usuario["id_u"],
                            "cod_transferencia" => $_COOKIE["codTransferencia"],
                            "descripcion_reserva" => $descripción_reserva,
                            "pagoReserva" => intval(str_replace(".", "", $_COOKIE["pagoReserva"])),
                            //"pagoReserva" => $_COOKIE["pagoReserva"],
                            "codigoReserva" => $_COOKIE["codigoReserva"],
                            "fechaIngreso" => $_COOKIE["fechaIngreso"],
                            "fechaSalida" => $_COOKIE["fechaSalida"],
                        );


                        $respuesta = ControladorReservas::ctrlGuardarReserva($datos);
                        //ver ($respuesta);
                        echo "<script>borrarCookies();</script>";
                    }

                    ?>
                    <div class="col-6 d-none d-lg-block"></div>
                    <div class="col-12 mt-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Habitación</th>
                                    <th>Fecha de Ingreso</th>
                                    <th>Fecha de Salida</th>
                                    <th>Testimonios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (!count($reservas)) {
                                    echo '<tr><td colspan="5">Aún no tiene reservas realizadas</td></tr>';
                                    //return;
                                } else {

                                    foreach ($reservas as $key => $valor) { //<td></td>

                                        $habitacion = ControladorHabitaciones::ctrlMostrarHabitacion($valor["id_habitacion"]);
                                        $categoria = ControladorCategorias::ctrlMostrarCategoria($habitacion["tipo_h"]);
                                        $testimonio = ControladorReservas::ctrlMostrarTestimonios("id_res", $valor["id_reserva"]);

                                        echo '
                                                <tr>
                                                    <td>' . ($key + 1) . '</td>
                                                    <td class="text-uppercase">' . $categoria["tipo"] . " " . $habitacion["estilo"] . '</td>
                                                    <td>' . $valor["fecha_ingreso"] . '</td>
                                                    <td>' . $valor["fecha_salida"] . '</td>
                                                    <td>
                                                    
                                                    <button type="button" class="btn btn-dark text-white actualizarTestimonio"
                                                    data-toggle="modal" data-target="#actualizarTestimonio"
                                                    idTestimonio="' . $testimonio[0]["id_testimonio"] . '"
                                                    verTestimonio="' . $testimonio[0]["testimonio"] . '">
                                                        <i class="fas fa-pencil-alt" aria-hidden="true">
                                                        </i>
                                                    </button>
                                                    
                                                    <button type="button" class="btn btn-warning text-white verTestimonio"
                                                    data-toggle="modal" data-target="#verTestimonio"
                                                    verTestimonio="' . $testimonio[0]["testimonio"] . '">
                                                        <i class="fas fa-eye" aria-hidden="true">
                                                        </i>
                                                    </button>
                                                    
                                                    </td>

                                                </tr>
                                                ';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




<!-- ventana modal pago -->
<div class="modal" id="infoPago">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">Datos para realizar la transferencia</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4>CBU: 45645645646546</h4>
                <h4>ALIAS: monitor.teclado.mouse</h4>
                <h4>BANCO: Montaje</h4>
                <h4>CIUT: 20343443451</h4>
                <h4>Monto: $<?php if (isset($_COOKIE["pagoReserva"])) {
                                echo  $_COOKIE["pagoReserva"];
                            } ?></h4>
                <label for="codigoPago">Ingresar código de tranferencia (sujeto a revisión para confirmar la reserva)</label>
                <input name="codigoPago" type="text" class="codigoPago">
                <div class="text-center mt-5">
                    <button class="btn btn-success enviarPago">Enviar comprobante</button>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<!-- ventana modelo modal verTestimonio -->
<div class="modal" id="verTestimonio">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">TESTIMONIOS</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body visorTestimonio">

                <script>
                    $(".verTestimonio").click(function() {
                        const testimonio = $(this).attr("verTestimonio");

                        if (testimonio != "") {

                            $(".modal-body.visorTestimonio").html('<p>' + testimonio + '</p>');
                        } else {

                            $(".modal-body.visorTestimonio").html('<p>Aún no tiene testimonios de esta reserva</p>');
                        }
                    })
                </script>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- ventana modelo modal editarTestimonio -->
<div class="modal" id="actualizarTestimonio">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">TESTIMONIOS</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <script>
                    $(".actualizarTestimonio").click(function() {
                        const testimonio = $(this).attr("verTestimonio");
                        const idTestimonio = $(this).attr("idTestimonio");
                        if (testimonio != "") {
                            $(".modal-body textarea").val(testimonio);
                        } else {
                            $(".modal-body textarea").val("");
                        }
                        $("input[name='idTestimonio']").val(idTestimonio);
                    })
                </script>

                <form method="post">
                    <input type="hidden" value="" name="idTestimonio">
                    <textarea class="form-control" name="actualizarTestimonio" rows="3" required></textarea>
                    <input type="submit" class="btn btn-primary my-3 float-right" value="Guardar Testimonio">

                    <?php
                    $actualizarTestimonio = new ControladorReservas();
                    $actualizarTestimonio->ctrlActualizarTestimonio();
                    ?>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>





<!-- 
    //ventana modelo modal
    <div class="modal" id="verTestimonio">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase">TITULO</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    -->