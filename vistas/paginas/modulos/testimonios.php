<?php

$valor = $_GET["pagina"];
//error_log("_GET[pagina]: ".$_GET["pagina"], 0);

$habitaciones = ControladorHabitaciones::ctrlMostrarHabitaciones($valor);

//ver ($habitaciones);
//ver ($habitaciones[0]["id_h"]);

$testimoniosArray = array();

foreach($habitaciones as $key => $valor){
    $testimonio = ControladorReservas::ctrlMostrarTestimonios("id_hab", $habitaciones[0]["id_h"]);
    if (count($testimonio)){
        /* foreach ($testimonio as $key1 => $valor1){
            ver($valor1["testimonio"]);
        } */
        array_push($testimoniosArray, $testimonio);
    }
}

//ver ($testimoniosArray[0][1]["testimonio"]);

?>



    <!-- *************
        TESTIMONIOS
    ******************-->
    <div class="testimonios container-fluid py-5 text-white">
        <div class="container mb-3">
            <h1 class="text-center py-5">TESTIMONIOS</h1>
            <div class="row">
                <?php

                $cantidadTestimonios=0;
                $cantidadMostrar=0;
                
                for($i=0; $i<count($testimoniosArray); $i++){
                    
                    //error_log("testimoniosArray[0][i][aprobado]: ".$testimoniosArray[0][$i]["aprobado"], 0);
                    if ($testimoniosArray[0][$i]["aprobado"] != 0){    
                        $cantidadTestimonios++;
                    }
                    
                }
                
                //ver ("cantidadTestimonios: ". $cantidadTestimonios);
                //limito la cant de testimonios q quiero mostrar
                if($cantidadTestimonios){
                    for($i=0; $i<count($testimoniosArray); $i++){
                        
                        //error_log("valor[0][aprobado]".$testimoniosArray[0][$i]["aprobado"], 0);

                        if ($testimoniosArray[0][$i]["aprobado"] != 0){
                            echo '
                            <div class="col-12 col-lg-3 text-center p-4">';
                                if($testimoniosArray[0][$i]["foto"] == ""){
                                    echo '
                                    <img src="'.$servidor.'vistas/img/usuarios/default/default.png" class="img-fluid rounded-circle w-50">';
                                }else{
                                    if ($testimoniosArray[0][$i]["modo"] == "directo"){
                                        echo '
                                        <img src="'.$servidor.$testimoniosArray[0][$i]["foto"].'" class="img-fluid rounded-circle w-50">';        
                                    }else{
                                        echo '
                                    <img src="'.$testimoniosArray[0][$i]["foto"].'" class="img-fluid rounded-circle w-50">';    
                                    }
                                    
                                }
                            echo '
                                <h4 class="py-4">'.$testimoniosArray[0][$i]["nombre"].'</h4>
                                <p>'.$testimoniosArray[0][$i]["testimonio"].'</p>
                            </div>
                            ';
                        }
                    }

                }else{
                    echo '<div class="col-12 text-white text-center">¡Esta habitación aún no tiene testimonios!</div>';
                }

                
            echo '</div>';//row
            
            if($cantidadTestimonios > 4){
                echo '<button class="btn btn-default float-right px-4 verMasTestimonios">VER MAS</button>';
            }
            ?>
        </div>
    </div>
