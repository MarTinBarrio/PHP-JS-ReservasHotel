<?php

if(isset($_SESSION["validarSesion"])){
    //error_log("Desde perfil.php, validarSesion: ".$_SESSION["validarSesion"], 0);
    if($_SESSION["validarSesion"] == "ok"){
        include "modulos/banner-interior.php";
        include "modulos/info-perfil.php";        
        include "modulos/habitaciones.php"; 
        include "modulos/planes.php"; 
        include "modulos/planes-movil.php"; 
        include "modulos/recorrido-pueblo.php"; 
        include "modulos/restaurante.php"; 
        
    }
}else{
    //error_log("Desde perfil.php, redirigue a: ".$ruta.", validarSession: ".$_SESSION["validarSesion"], 0);
    echo '<script> window.location="'.$ruta.'"</script>';
}
