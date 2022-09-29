<?php

$categorias = ControladorCategorias::ctrlMostrarCategorias();
//echo '<pre>'; print_r($Categorias); echo '</pre>';
//ver($categorias);

?>



<!-- habitaciones -->
<div class="habitaciones container-fluid bg-light" id="habitaciones">

    <div class="container">

        <h1 class="pt-4 text-center">Habitaciones</h1>
        <div class="row p-4 text-center">

            <?php foreach ($categorias as $key => $valor) { ?>

                <div class="col-12 col-lg-4 pb-3 px-0 px-lg-3">
                    <a href="<?php echo $ruta.$valor["ruta"]; ?>">
                        <figure class="text-center">
                            <img src="<?php echo $servidor.$valor["img"]; ?>" alt="" class="img-fluid" width="100%">
                            <p class="small py-4 px-2 px-lg-0 mb-0"><?php echo $valor["descripcion"]; ?></p>
                            <h3 class="py-2 text-gray-dark mb-0">DESDE $<?php echo number_format($valor["continental_baja"]); ?></h3>
                            <h5 class="py-2 text-gray-dark border">Ver Detalles <i class="fa-solid fa-chevron-right ml-2"></i></h5>
                            <h1 class="text-white p-3 mx-auto w-50 lead text-uppercase" style="background: <?php echo $valor["color"]; ?>;"><?php echo $valor["tipo"]; ?></h1>
                        </figure>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>