<?php
if (isset($_POST["id-habitacion"])) {
    /*     ver($_POST["id-habitacion"]);
    ver($_POST["fecha-ingreso"]);
    ver($_POST["fecha-salida"]); */

    $reservas = ControladorReservas::ctrlMostrarReservas($_POST["id-habitacion"]);
    //ver($reservas);
    $indice = 0;

    $parametro="";

    if (!$reservas){
        $parametro = $_POST["ruta"];
        $reservas = ControladorHabitaciones::ctrlMostrarHabitaciones($parametro);
        //ver($reservas);
        foreach ($reservas as $key => $valor){
            if($valor["id_h"] == $_POST["id-habitacion"]){
                $indice = $key;
            }
        }
    }

    //ver($reservas[$indice]);

    $planes = ControladorPlanes::ctrlMostrarPlanes();
    /* ver($reservas); */

    //defino mi zona horaria:
    date_default_timezone_set("America/Argentina/Buenos_Aires"); //https://www.php.net/manual/es/timezones.php
    $hoy = getdate();
    //ver($hoy);

    /**************
     * precio por temporada
     */
    //tomo como ejemplo q la temporada alta es del 15/12 al 15/01 y del 15/06 al 15/07...
    if (
        $hoy["mon"] == 12 && $hoy["mday"] >= 15 && $hoy["mday"] <= 31 ||
        $hoy["mon"] == 1 && $hoy["mday"] >= 1 && $hoy["mday"] <= 15 ||
        $hoy["mon"] == 6 && $hoy["mday"] >= 15 && $hoy["mday"] <= 31 ||
        $hoy["mon"] == 7 && $hoy["mday"] >= 1 && $hoy["mday"] <= 15
    ) {

        $precioContinental = $reservas[$indice]["continental_alta"];
        $precioAmericano = $reservas[$indice]["americano_alta"];

        $precioRomantico = $reservas[$indice]["americano_alta"] + $planes[0]["precio_alta"];
        $precioLunaDeMiel = $reservas[$indice]["americano_alta"] + $planes[1]["precio_alta"];
        $precioAventura = $reservas[$indice]["americano_alta"] + $planes[2]["precio_alta"];
        $precioSPA = $reservas[$indice]["americano_alta"] + $planes[3]["precio_alta"];
    } else {

        $precioContinental = $reservas[$indice]["continental_baja"];
        $precioAmericano = $reservas[$indice]["americano_baja"];

        $precioRomantico = $reservas[$indice]["americano_baja"] + $planes[0]["precio_baja"];
        $precioLunaDeMiel = $reservas[$indice]["americano_baja"] + $planes[1]["precio_baja"];
        $precioAventura = $reservas[$indice]["americano_baja"] + $planes[2]["precio_baja"];
        $precioSPA = $reservas[$indice]["americano_baja"] + $planes[3]["precio_baja"];
    }


    /**************
     * cantidad de días de la reserva
     */
    $fechaIngreso = new DateTime($_POST["fecha-ingreso"]);
    $fechaSalida = new DateTime($_POST["fecha-salida"]);
    $diff = $fechaIngreso->diff($fechaSalida); //m calcula la diferencia, tomo el campo days
    //ver($diff);
    $dias = $diff->days;

    //x si un us elije el mismo día de ingreso q salida.. => es un día de estadía
    if ($dias == 0) {
        $dias = 1;
    }
} else {
    echo '<script>window.location="' . $ruta . '"</script>';
}
?>

<!-- *************
        Info Reservas
    ******************-->
<div class="infoReservas container-fluid bg-white p-0 pb-5" idHabitacion="<?php echo $_POST["id-habitacion"]; ?>" fechaIngreso="<?php echo $_POST["fecha-ingreso"]; ?>" fechaSalida="<?php echo $_POST["fecha-salida"]; ?>" dias="<?php echo $dias; ?>">
    <div class="container">
        <div class="row">
            <!-- info bloque izquierda -->
            <div class="col-12 col-lg-8 colIzqReservas p-0">
                <!-- cabecera reservas -->
                <div class="pt-4 cabeceraReservas">
                    <a href="<?php echo $ruta; ?>habitaciones" class="float-left lead text-white pt-1 px-3">
                        <h5><i class="fas fa-chevron-left"></i> Regresar</h5>
                    </a>
                    <div class="clearfix"></div>
                    <h1 class="float-left text-white p-2 pb-lg-5">Reservas</h1>
                    <h6 class="float-right px-3">
                        
                        <?php 
                            if (isset($_SESSION["validarSesion"])) {
                                if ($_SESSION["validarSesion"] == "ok") { ?>
                                    <br>
                                    <a href="<?php echo $ruta; ?>perfil" style="color: #FFCC29">Ver tus Reservas</a>
                                <?php } ?>
                        <?php } else { ?>
                            <br>
                            <a href="#modalIngreso" data-toggle="modal" style="color: #FFCC29">Ver tus Reservas</a>
                        <?php } ?>
                    </h6>
                    <div class="clearfix"></div><br>
                </div>
                <!-- CALENDARIO RESERVAS -->
                <div class="row bg-white p-4 calendarioReservas text-justify">
                    <div class="col-5 col-md-7 p-3">

                        <?php if ($parametro == $_POST["ruta"]) : ?>
                            <h1>¡Está Disponible!</h1>
                        <?php else : ?>
                            
                            <div class="infoDisponibilidad"></div>
                        <?php endif ?>
                    </div>
                    <div class="col-7 col-md-5 p-3">
                        <ul>
                            <li class="bg-white">
                                <i class="fas fa-square-full" style="color: #847059"></i> No disponible
                            </li>
                            <li class="bg-white">
                                <i class="fas fa-square-full" style="color: #eee"></i> Disponible
                            </li>
                            <li class="bg-white">
                                <i class="fas fa-square-full" style="color: #FFCC29"></i> Tu Reserva
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <div id="calendar"></div>

                    <!-- Modificar Fechas -->
                    <h6 class="lead py-4">Puede Modificar las Fechas de acuerdo a los días disponibles: </h6>

                    <form action="<?php echo $ruta; ?>reservas" method="post">
                        <input type="hidden" name="id-habitacion" value="<?php echo $_POST["id-habitacion"]; ?>">
                        <input type="hidden" name="ruta" value="<?php echo $_POST["ruta"]; ?>">

                        <div class="container mb-3">

                            <div class="row py-2 w-100" style="background:#509CC3">
                                <div class="col-12 col-md-4 input-group-lg pr-1">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker entrada" autocomplete="off" placeholder="Entrada" name="fecha-ingreso" value="<?php echo $_POST["fecha-ingreso"]; ?>" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text p-2">
                                                <i class="input-group fa-solid fa-calendar-days text-gray-dark"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 input-group-lg pl-1">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-group datepicker salida" autocomplete="off" placeholder="Salida" name="fecha-salida" value="<?php echo $_POST["fecha-salida"]; ?>" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text p-2">
                                                <i class="fa-solid fa-calendar-days text-gray-dark"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 w-auto">
                                    <input type="submit" class="btn btn-block btn-md text-white" value="Ver disponibilidad" style="background:black">
                                </div>
                            </div>
                        </div>
                    </form>



                </div>
            </div>

            <!-- info bloque derecha -->
            <div class="col-12 col-lg-4 colDerReservas" style="display:none">
                <h4 class="mt-lg-5">Código de Reserva: </h4>
                <h2 class="colorTitulos"><strong class="codigoReserva"></strong></h2>

                <div class="form-group">
                    <label>Ingreso 3:00 pm: </label>
                    <input type="date" class="form-control" value="<?php echo $_POST["fecha-ingreso"]; ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Salida 1:00 pm: </label>
                    <input type="date" class="form-control" value="<?php echo $_POST["fecha-salida"]; ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Habitación: </label>
                    <input type="text" class="form-control" value="Habitación <?php echo $reservas[$indice]["tipo"] . " " . $reservas[$indice]["estilo"] ?>" readonly>
                    <?php
                    $galeria = json_decode($reservas[$indice]["galeria"], true);
                    ?>
                    <img src="<?php echo $servidor . $galeria[0]; ?>" class="img-fluid">
                </div>

                <div class="form-group m-2 p-2">
                    <label><a href="#infoPlanes" data-toggle="modal">Escoge Tu Plan</a><small>Precio sugerido para 2 personas</small></label>
                    <select class="form-control m-2 elegirPlan">
                        <option value="<?php echo $precioContinental;?>,Plan Continenetal">Plan Continental $<?php echo number_format($precioContinental); ?> 1 día 1 noche</option>
                        <option value="<?php echo $precioAmericano;?>,Plan Americano">Plan Americano $<?php echo number_format($precioAmericano); ?> 1 día 1 noche</option>
                        <option value="<?php echo $precioRomantico;?>,Plan Romantico">Plan Romántico $<?php echo number_format($precioRomantico); ?> 1 día 1 noche</option>
                        <option value="<?php echo $precioLunaDeMiel;?>,Plan Luna De Miel">Plan Luna de Miel $<?php echo number_format($precioLunaDeMiel); ?> 1 día 1 noche</option>
                        <option value="<?php echo $precioAventura;?>,Plan Aventura">Plan Aventura $<?php echo number_format($precioAventura); ?> 1 día 1 noche</option>
                        <option value="<?php echo $precioSPA;?>,Plan SPA">Plan SPA $<?php echo number_format($precioSPA); ?> 1 día 1 noche</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Personas: </label>
                    <select class="form-control cantidadPersonas">
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>

                <div class="row py-4">
                    <div class="col-12 text-center text-lg-left">
                        <!-- col-lg-6 col-xl-7  -->
                        <h1 class="precioReserva">$<span><?php echo number_format($precioContinental * $dias); ?> ARS</span></h1>
                    </div>
                    <div class="col-12">
                        <?php if(isset($_SESSION["validarSesion"])) { 
                            if($_SESSION["validarSesion"] == "ok") { ?>

                                <!-- col-lg-6 col-xl-5 -->
                                <a href="<?php echo $ruta; ?>perfil" class="pagarReserva"
                                    idHabitacion="<?php echo $reservas[$indice]["id_h"]; ?>"
                                    imgHabitacion="<?php echo $servidor.$galeria[$indice]; ?>"
                                    infoHabitacion="Habitación <?php echo $reservas[$indice]["tipo"] . " " . $reservas[$indice]["estilo"] ?>"
                                    pagoReserva="<?php echo ($precioContinental * $dias); ?>"
                                    codigoReserva=""
                                    fechaIngreso="<?php echo $_POST["fecha-ingreso"]?>"
                                    fechaSalida="<?php echo $_POST["fecha-salida"]?>"
                                    plan="Plan Continental"
                                    personas="2"
                                    >
                                    <button class="btn btn-dark btn-lg w-100">PAGAR <br> RESERVA</button>
                                </a>
                            <?php } ?>
                        <?php } else{ ?>
                            <a href="#modalIngreso" data-toggle="modal"
                                    class="pagarReserva"
                                    idHabitacion="<?php echo $reservas[$indice]["id_h"]; ?>"
                                    imgHabitacion="<?php echo $servidor.$galeria[$indice]; ?>"
                                    infoHabitacion="Habitación <?php echo $reservas[$indice]["tipo"] . " " . $reservas[$indice]["estilo"] ?>"
                                    pagoReserva="<?php echo ($precioContinental * $dias); ?>"
                                    codigoReserva=""
                                    fechaIngreso="<?php echo $_POST["fecha-ingreso"]?>"
                                    fechaSalida="<?php echo $_POST["fecha-salida"]?>"
                                    plan="Plan Continental"
                                    personas="2"
                                    >
                                    <button class="btn btn-dark btn-lg w-100">PAGAR <br> RESERVA</button>
                                </a>

                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ventana modal planes -->
<div class="modal" id="infoPlanes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">Habitación <?php echo $reservas[$indice]["tipo"] . ' ' . $reservas[$indice]["estilo"]; ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <figure>
                    <img src="<?php echo $servidor . $galeria[0]; ?>" class="img-fluid">
                </figure>
                <p class="px-2"><?php $reservas[$indice]["descripcion_h"]; ?></p>
                <hr>
                <div class="row">
                    <?php
                    foreach ($planes as $key => $valor) {
                    ?>
                        <div class="col-12 col-md-6">
                            <h2 class="text-uppercase p-2">Plan <?php echo $valor["tipo"]; ?></h2>
                            <figure>
                                <img src="<?php echo $servidor.$valor["img"]; ?>" class="img-fluid">
                            </figure>
                            <p class="p-2"><?php echo $valor["descripcion"];?></p>
                            <h4 class="px-2">Precio Por Pareja</h4>
                            <p class="px-2">
                            Temporada Baja: Plan Americano + $<?php echo number_format($valor["precio_baja"]); ?> <br>
                            Temporada Alta: Plan Americano + $<?php echo number_format($valor["precio_alta"]); ?> <br>
                            </p>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>