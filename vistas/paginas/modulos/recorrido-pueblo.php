<?php

$recorrido = ControladorRecorrido::ctrlMostrarRecorrido();

//ver($recorrido);

?>




<!-- Recorrido por el pueblo -->
<div class="recorridoPueblo container-fluid bg-white pb-5" id="pueblo">
    <div class="container">
        <h1 class="pt-5 text-center">RECORRIDO POR EL PUEBLO</h1>

        <div class="jd-slider slidePueblo">
            <div class="slide-inner">

                <ul class="slide-area">

                    <?php foreach ($recorrido as $key => $valor) { ?>

                        <li>
                            <div class="grid-container pt-4 pb-1 pb-lg-3 px-0 px-lg-5">
                                <div class="grid-item">
                                    <img src="<?php echo $servidor.$valor["foto_peq"]; ?>" class="img-fluid" width="100%">
                                </div>
                                <div class="grid-item">
                                    <h1 class="mt-4 mb-0 my-lg-2 text-uppercase"><?php echo $valor["titulo"]; ?></h1>
                                    <p class="small p-3"><?php echo $valor["descripcion"]; ?></p>
                                </div>
                                <div class="grid-item d-none d-lg-block">
                                    <img src="<?php echo $servidor.$valor["foto_gra"]; ?>" class="img-fluid" width="100%">
                                </div>
                            </div>
                        </li>

                    <?php } ?>


                </ul>

            </div>

            <a href="#" class="d-none d-md-block prev">
                <i class="fas fa-angle-left fa-2x" style="color: #3E92BD;"></i>
            </a>
            <a href="#" class="d-none d-md-block next">
                <i class="fas fa-angle-right fa-2x" style="color: #3E92BD;"></i>
            </a>
            <div class="controller">
                <div class="indicate-area"></div>
            </div>

        </div>
    </div>
</div>