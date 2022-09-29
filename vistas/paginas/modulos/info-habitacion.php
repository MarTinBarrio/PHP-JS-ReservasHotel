<?php

$valor = $_GET["pagina"];

$habitaciones = ControladorHabitaciones::ctrlMostrarHabitaciones($valor);
//ver($habitaciones);

?>

<!-- info habitación -->
<div class="infoHabitacion container-fluid bg-white p-0 pb-5">
    <div class="container">
        <div class="row">
            <!-- info bloque izquierda -->
            <div class="col-12 col-lg-8 colIzqHabitaciones p-0">
                <!-- cabecera habitaciones -->
                <div class="pt-4 cabeceraHabitacion">
                    <a href="<?php echo $ruta; ?>" class="float-left lead text-white pt-1 px-3">
                        <h5><i class="fas fa-chevron-left"></i> Regresar</h5>
                    </a>
                    <h2 class="float-right text-white px-3 categoria text-uppercase"><?php echo $habitaciones[0]["tipo"] ?></h2>

                    <div class="clearfix"></div>
                    <ul class="nav nav-justified mt-lg-4">

                        <?php foreach ($habitaciones as $key => $valor) { ?>

                            <li class="nav-item">
                                <a href="#" class="nav-link text-white" orden="<?php echo $key; ?>" ruta="<?php echo $_GET["pagina"] ?>">
                                    <?php echo $valor["estilo"];  ?></a>
                            </li>

                        <?php } ?>
                    </ul>
                    <!-- </a> -->
                </div>
                <!-- multimedia habitaciones -->
                <!-- slide -->
                <section class="jd-slider mb-3 my-lg-3 slideHabitaciones">
                    <div class="slide-inner">
                        <ul class="slide-area">

                            <?php
                            $galeria = json_decode($habitaciones[0]["galeria"], true);
                            foreach ($galeria as $key => $valor) { ?>

                                <li>
                                    <img src="<?php echo $servidor . $valor; ?>" class="img-fluid">
                                </li>

                            <?php } ?>

                        </ul>
                    </div>
                    <a href="#" class="prev d-none d-lg-block">
                        <i class="fas fa-angle-left fa-2x"></i>
                    </a>
                    <a href="#" class="next d-none d-lg-block">
                        <i class="fas fa-angle-right fa-2x"></i>
                    </a>
                    <div class="controller d-block d-lg-none">
                        <div class="indicate-area"></div>
                    </div>
                </section>

                <!-- video -->
                <section class="mb-3 my-lg-3 videoHabitaciones d-none">
                    <iframe width="100%" height="380" src="http://www.youtube.com/embed/<?php echo $habitaciones[0]["video"] ?>" frameborder="0" allow="acelerometer, autoplay, encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                </section>
                <!-- 360° -->
                <section class="mb-3 my-lg-3 360Habitaciones d-none">
                    <div id="myPano" class="pano" back="<?php echo $servidor . $habitaciones[0]["recorrido_virtual"]; ?>">
                        <div class="controls">
                            <a href="#" class="left">&laquo;</a>
                            <a href="#" class="right">&raquo;</a>
                        </div>
                    </div>
                </section>



                <!-- descripción habitaciones -->
                <div class="descripcionHabitacion px-3">
                    <h1 class="colorTitulos float-left"><?php echo $habitaciones[0]["estilo"] . " " . $habitaciones[0]["tipo"]; ?></h1>
                    <div class="float-right pt-2">
                        <button type="button" class="btn btn-default" vista="fotos"><i class="fas fa-camera"></i>
                            FOTOS</button>
                        <button type="button" class="btn btn-default" vista="video"><i class="fa fa-youtube"></i>
                            VIDEO</button>
                        <button type="button" class="btn btn-default" vista="360"><i class="fas fa-video"></i>
                            360°</button>
                    </div>
                    <div class="clearfix mb-4"></div>
                    <div class="d-habitacion">
                        <?php echo $habitaciones[0]["descripcion_h"]; ?>
                    </div>

                    <!-- bloque de reservas -->
                    <form action="<?php echo $ruta; ?>reservas" method="post">
                        <input type="hidden" name="id-habitacion" value="<?php echo $habitaciones[0]["id_h"];?>">
                        <div class="container">
                            <input type="hidden" name="ruta" value="<?php echo $habitaciones[0]["ruta"]; ?>">

                            <div class="row py-2 w-100" style="background:#509CC3">
                                <div class="col-12 col-md-4 input-group-lg pr-1">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker entrada" autocomplete="off" placeholder="Entrada" name="fecha-ingreso" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text p-2">
                                                <i class="input-group fa-solid fa-calendar-days text-gray-dark"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 input-group-lg pl-1">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-group datepicker salida" autocomplete="off" readonly placeholder="Salida" name="fecha-salida" required>
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
            <div class="col-12 col-lg-4 colDerHabitaciones">
                <h2 class="colorTitulos text-uppercase"><?php echo $habitaciones[0]["tipo"]; ?> INCLUYE</h2>
                <ul>

                    <?php
                    $incluye = json_decode($habitaciones[0]["incluye"], true);
                    foreach ($incluye as $key => $valor) {
                    ?>
                        <li>
                            <h5>
                                <i class="<?php echo $valor["icono"]; ?> w-25 colorTitulos"></i>
                                <span class="text-dark small"><?php echo $valor["item"]; ?></span>
                            </h5>
                        </li>

                    <?php } ?>

                </ul>
                <!-- habitaciones -->
                <div class="habitaciones" id="habitaciones">

                    <div class="container">

                        <div class="row">

                            <?php
                            $categorias = ControladorCategorias::ctrlMostrarCategorias();
                            foreach ($categorias as $key => $valor) {
                                if ($_GET["pagina"] != $valor["ruta"]) :
                            ?>
                                    <div class="col-12 pb-3 px-0 px-lg-3">
                                        <a href="<?php echo $ruta . $valor["ruta"]; ?>">
                                            <figure class="text-center">
                                                <img src="<?php echo $servidor . $valor["img"]; ?>" alt="" class="img-fluid" width="100%">
                                                <p class="small py-4 px-2 px-lg-0 mb-0"><?php echo $valor["descripcion"]; ?></p>
                                                <h3 class="py-2 text-gray-dark mb-0">DESDE $<?php echo number_format($valor["continental_baja"]); ?></h3>
                                                <h5 class="py-2 text-gray-dark border">Ver Detalles <i class="fa-solid fa-chevron-right ml-2"></i></h5>
                                                <h1 class="text-white p-3 mx-auto w-50 lead text-uppercase" style="background: <?php echo $valor["color"]; ?>;"><?php echo $valor["tipo"]; ?></h1>
                                            </figure>
                                        </a>
                                    </div>
                            <?php
                                endif;
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>