<?php

$planes = ControladorPlanes::ctrlMostrarPlanes();

//ver($planes);

?>

<!-- planes MOVIL -->
    <div class="d-block d-lg-none planesMovil jd-slider bg-white" id="planesMovil">
        <h1 class="text-center py-3">PLANES</h1>


        <div class="slide-inner">
            <ul class="slide-area">

                <?php foreach ($planes as $key => $valor) { ?>
                <li>
                    <a href="#modalPlanes" data-toggle="modal"
                        descripcion="<?php echo $valor["descripcion"]; ?>">
                        <img src="<?php echo $servidor.$valor["img"]; ?>" width="100%">
                        <h6 class="py-2 text-center text-uppercase"><?php echo $valor["tipo"]; ?></h6>
                    </a>
                </li>
                <?php } ?>
            </ul>

            <a href="#" class="prev">
                <i class="fa fa-angule-left text-muted"></i>
            </a>
            <a href="#" class="next">
                <i class="fa fa-angule-right text-muted"></i>
            </a>

        </div>

        <!-- <div class="grid-container px-5">
                <div class="grid-item">1</div>
            </div> -->
        <div class="controller">
            <div class="indicate-area"></div>
        </div>
    </div>