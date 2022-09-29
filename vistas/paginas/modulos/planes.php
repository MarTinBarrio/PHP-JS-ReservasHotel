<?php

$planes = ControladorPlanes::ctrlMostrarPlanes();

//ver($planes);

?>


<!-- PLANES -->
<div class="planes container-fluid bg-white p-0" id="planes">
    <div class="container p-0"></div>
    <div class="grid-container">
        <div class="grid-item">
            <h1 class="text-center py-2 py-lg-5 tituloPlan text-uppercase" tituloPlan="BIENVENIDO">BIENVENIDO</h1>
            <p class="text-muted text-left px-4 descripcionPlan" descripcionPlan="Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam molestias cumque earum, unde dolorem nobis autem aliquam fugit iure magnam quibusdam officia reprehenderit natus, quas odit aspernatur, quod vero iusto!">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam molestias cumque earum, unde dolorem
                nobis autem aliquam fugit iure magnam quibusdam officia reprehenderit natus, quas odit aspernatur,
                quod vero iusto!</p>
        </div>

        <?php foreach ($planes as $key => $valor) { ?>
            <div class="grid-item d-none d-lg-block" data-toggle="modal" data-target="#modalPlanes">
                <figure class="text-center">
                    <h1 descripcion="<?php echo $valor["descripcion"]; ?>" class="text-uppercase">
                    PLAN <?php echo $valor["tipo"]; ?></h1>
                </figure>
                <img src="<?php echo $servidor.$valor["img"]; ?>" class="img-fluid" width="100%">
            </div>
        <?php } ?>

    </div>

</div>