
<?php

$restaurante = ControladorRestaurante::ctrlMostrarRestaurante();

//ver($restaurante);

?>


<!-- Restaurante -->
    <div class="fondoRestaurante container-fluid bg-dark">

    </div>

    <div class="restaurante container-fluid pt-5" id="restaurante">
        <div class="container">
            <div class="grid-container">
                <div class="grid-item carta">
                    <div class="row p-1 p-lg-5">

                        <?php foreach ($restaurante as $key => $valor){ ?>

                        <div class="col-6 col-md-4 text-center p-1">
                            <img src="<?php echo $servidor.$valor["img"]; ?>" class="img-fluid w-50 rounded-circle">
                            <p class="py-2"><?php echo $valor["descripcion"]; ?></p>
                        </div>
                    
                        <?php } ?>

                        <div class="col-12 text-center d-block d-lg-none">
                            <button class="btn btn-warning text-uppercase mb-5 volverCarta">Volver</button>
                        </div>
                    </div>
                </div>
                <div class="grid-item bloqueRestaurante">
                    <h1 class="mt-4 my-lg-5">RESTAURANTE</h1>
                    <p class="p-4 my-lg-5">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugiat quas,
                        voluptatibus voluptatum necessitatibus sit laboriosam tenetur sequi culpa exercitationem quae
                        dicta soluta quibusdam omnis dolorem vero eos temporibus pariatur.</p>
                    <button class="btn btn-warning text-uppercase mb-5 verCarta">Ver La Carta</button>
                </div>
            </div>
        </div>
    </div>
