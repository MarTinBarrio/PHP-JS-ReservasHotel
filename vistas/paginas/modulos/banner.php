<?php

$banner = ControladorBanner::ctrlMostrarBanner();
//echo '<pre>'; print_r($banner); echo '</pre>';
//ver($banner);

?>


<!-- BANNER -->
<div class="banner container-fluid p-0">
    <div class="jd-slider fade-slider">
        <div class="slide-inner">
            <ul class="slide-area">

                <?php foreach ($banner as $key => $value) : ?>
                <!-- lo va a ejecutar para todas las img q tenga en la tabla -->
                    <li>
                        <img src="<?php echo $servidor.$value["img"]; ?>" width="100%">
                    </li>
                   
                <?php endforeach ?>
            </ul>
        </div>

        <div class="controller d-none">

            <a class="auto" href="#">
                <i class="fa fa-play fa-xs"></i>
                <i class="fa fa-pause fa-xs"></i>
            </a>

            <div class="indicate-area"></div>
        </div>

        <div class="verMas text-center bg-white rounded-circle d-none d-lg-block" vinculo="#planes">
            <i class="fa fa-chevron-down"></i>
        </div>

    </div>

</div>