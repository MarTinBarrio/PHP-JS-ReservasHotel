<?php

$categorias = ControladorCategorias::ctrlMostrarCategorias();
//ver ($categorias);

if (isset($_SESSION["validarSesion"])){
    if($_SESSION["validarSesion"] == "ok"){
        $item = "id_u";
        $valor = $_SESSION["id"];
        $usuario = ControladorUsuario::ctrlMostrarUsuario($item, $valor);
    }
}

?>

<!-- **********
        HEADER 
    **************-->
<header class="container-fluid p-0 bg-white">
    <div class="container p-0">
        <div class="grid-container py-2">
            <!-- logo -->
            <div class="grid-item">
                <a href="<?php echo $ruta; ?>">
                    <img src="img/logoPortobelo.png" class="img-fluid">
                </a>

            </div>
            <div class="grid-item d-none d-lg-block"></div>

            <!-- campana y reserva -->
            <div class="grid-item d-none d-lg-block bloqueReservas">
                <div class="py-2 campana-y-reserva mostrarBloqueReservas" modo="abajo">
                    <i class="fas fa-bell-concierge mx-2"></i>
                    <!-- <i class="fas fa-concierge-bell lead mx-2"></i -->
                    <i class="fas fa-caret-up mx-2 flechaReserva"></i>
                    <!-- <i class="fa fa-caret-up lead mx-2 flechaReserva"></i> -->
                </div>

                <!-- formulario reservas -->
                <form action="<?php echo $ruta; ?>reservas" method="post">
                    <div class="formReservas py-1 py-lg-2 px-4">

                        <div class="form-group my-4">
                            <select class="form-control form-control-lg selectTipoHabitacion" required>
                                <option value="">Tipo de habitación</option>

                                <?php foreach ($categorias as $key => $valor) { ?>

                                    <option value="<?php echo $valor["ruta"]; ?>"><?php echo $valor["tipo"]; ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group my-4">
                            <select class="form-control form-control-lg selectTemaHabitacion" name="id-habitacion" required>
                                <option value="">Temática de habitación</option>
                            </select>
                        </div>

                        <input type="hidden" id="ruta" name="ruta">

                        <div class="row">

                            <div class="col-6 input-group-lg pr-1">
                                <div class="input-group">
                                    <input type="text" class="form-control input-group datepicker entrada" autocomplete="off" placeholder="Entrada" name="fecha-ingreso" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text p-2">
                                            <i class="input-group fa-solid fa-calendar-days text-gray-dark"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 input-group-lg pl-1">
                                <div class="input-group">
                                    <input type="text" class="form-control input-group datepicker salida" autocomplete="off" readonly placeholder="Salida" name="fecha-salida" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text p-2">
                                            <i class="fa-solid fa-calendar-days text-gray-dark"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <input type="submit" class="btn btn-block btn-lg my-4 text-white" value="Ver Disponibilidad">

                    </div>
                </form>

            </div>

            <!-- ingreso de usuarios -->
            <div class="grid-item d-none d-lg-block mt-2">
                <?php if(isset($_SESSION["validarSesion"])){ 
                        if($_SESSION["validarSesion"] == "ok"){
                            //ver($_SESSION["foto"]);
                            //ver($_SESSION["modo"]);
                ?>
                            <a href="<?php echo $ruta;?>perfil">
                                <?php if($usuario["foto"] == null){ ?>
                                    <i class="fas fa-user"></i>
                                <?php }else{?>
                                    <?php if($usuario["modo"] == "directo"){ ?>
                                        <img src="<?php echo $servidor.$usuario["foto"]; ?>" class="lazy img-fluid rounded-circle" style="width:40px; height:auto">
                                    <?php } else{?>
                                        <img src="<?php echo $usuario["foto"]; ?>" class="lazy img-fluid rounded-circle" style="width:40px; height:auto">
                                    <?php } ?>
                                <?php } ?>
                            </a>
                        <?php } ?>

                <?php }else{ ?>

                        <a href="#modalIngreso" data-toggle="modal">
                            <i class="fas fa-user"></i>
                        </a>

                <?php }?>
                
            </div>

            <!-- idiomas -->
            <div class="grid-item d-none d-lg-block mt-3 idiomas">
                <span class="border border-info float-left p-2 bg-info text-white idiomaEs">ES</span>
                <span class="border border-info float-left p-2 bg-white text-dark idiomaEn">EN</span>
            </div>

            <!-- menú haburguesa -->
            <div class="grid-item mt-1 mt-sm-3 mt-md-4 mt-lg-2 botonMenu">
                <i class="fa fa-bars"></i>
            </div>

        </div>
    </div>

</header>

<!-- **********
        MENU 
    **************-->
<nav class="menu container-fluid p-0">
    <ul class="nav nav-justified py-2">
        <li class="nav-item">
            <a class="nav-link text-white" href="#planes">Planes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#habitaciones">Habitaciones</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#pueblo">El Pueblo</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#restaurante">Restaurante</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#contactenos">Contactenos</a>
        </li>
        <li class="nav-item">
            <ul class="my-2 py-1 nav-justified">
                <li>
                    <a href="#" target="_blank">

                        <i class="fab fa-facebook-f text-white float-left mx-2"></i>

                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">

                        <i class="fab fa-twitter text-white float-left mx-2"></i>

                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">

                        <i class="fab fa-youtube text-white float-left mx-2"></i>

                    </a>
                </li>
                <li>
                    <a href="#" target="_blank">

                        <i class="fab fa-instagram text-white float-left mx-2"></i>

                    </a>
                </li>
            </ul>
        </li>
    </ul>

</nav>

<!-- ******************
        MENU MOVIL 
    *************************-->
<div class="menuMovil">
    <div class="row">

        <div class="col-6">
            <a href="#modalIngreso" data-toggle="modal">
                <i class="fas fa-user lead ml-3 mt-4"></i>
            </a>
        </div>

        <div class="col-6">
            <div class="float-right mr-3 mt-3 mr-sm-5 mt-sm-4">
                <span class="border border-info float-left p-2 bg-info text-white idiomaEs">ES</span>
                <span class="border border-info float-left p-2 bg-white text-dark idiomaEn">EN</span>
            </div>
        </div>
    </div>


    <!-- formulario de reservas -->
    <form action="<?php echo $ruta; ?>reservas" method="post">
        <div class="formReservas py-1 py-lg-2 px-4">

            <div class="form-group my-4">
                <select class="form-control form-control-lg selectTipoHabitacion" required>
                    <option value="">Tipo de habitación</option>

                    <?php foreach ($categorias as $key => $valor) { ?>

                        <option value="<?php echo $valor["ruta"]; ?>"><?php echo $valor["tipo"]; ?></option>

                    <?php } ?>
                </select>
            </div>
            <div class="form-group my-4">
                <select class="form-control form-control-lg selectTemaHabitacion" name="id-habitacion" required>
                    <option value="">Temática de habitación</option>
                </select>
            </div>
            <input type="hidden" id="ruta" name="ruta">

            <div class="row">

                <div class="col-6 input-group-lg pr-1">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker entrada" placeholder="Entrada" autocomplete="off" name="fecha-ingreso" required>
                        <div class="input-group-append">
                            <span class="input-group-text p-2">
                                <i class="input-group fa-solid fa-calendar-days text-gray-dark"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-6 input-group-lg pl-1">
                    <div class="input-group">
                        <input type="text" class="form-control input-group datepicker salida" placeholder="Salida" autocomplete="off" name="fecha-salida" readonly required>
                        <div class="input-group-append">
                            <span class="input-group-text p-2">
                                <i class="fa-solid fa-calendar-days text-gray-dark"></i>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <input type="submit" class="btn btn-block btn-lg my-4 text-white" value="Ver Disponibilidad">

        </div> <!-- formulario de reservas -->
    </form>

    <ul class="nav flex-column mt-4 pl-4 mb-5">
        <li class="nav-item">
            <a class="nav-link text-white" href="#planesMovil">Planes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#habitaciones">Habitaciones</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#pueblo">El Pueblo</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#restaurante">Restaurante</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="#contactenos">Contactenos</a>
        </li>
    </ul>
</div>