<?php

use Google\Service\ApigeeRegistry\Config;

 include_once "../backend/controladores/reservas.controlador.php";
 include_once "../backend/modelos/reservas.modelo.php";

 Class AjaxReservas{
     public $idHabitacion;
     public $codigoReserva;

     /**Traer reserva x id habitacion */
     public function ajaxTraerReserva(){
        $respuesta = ControladorReservas::ctrlMostrarReservas($this->idHabitacion);
        echo json_encode($respuesta);
     }
     /**Traer reserva x cod reserva */
     public function ajaxTraerCodigoReserva(){
        $respuesta = ControladorReservas::ctrlMostrarCodigoReservas($this->codigoReserva);
        echo json_encode($respuesta);
     }
     
     /***traer testimonios */
     public $id_h;
     public function ajaxTraerTestimonios(){
         $item = "id_hab";
         $valor = $this->id_h;
         $respuesta = ControladorReservas::ctrlMostrarTestimonios($item, $valor);
         echo json_encode($respuesta);
     }

 }

 //para consulta por id de habitación
 if (isset($_POST["idHabitacion"])){
     $idHabitacion = new AjaxReservas();
     $idHabitacion -> idHabitacion = $_POST["idHabitacion"];
     $idHabitacion -> ajaxTraerReserva();
 }

 //para consulta por cod de reserva
 if (isset($_POST["codigoReserva"])){
    $codigoReserva = new AjaxReservas();
    $codigoReserva -> codigoReserva = $_POST["codigoReserva"];
    $codigoReserva -> ajaxTraerCodigoReserva();
}

//para traer testimonios
if (isset($_POST["id_h"])){
    $id_h = new AjaxReservas();
    $id_h -> id_h = $_POST["id_h"];
    $id_h -> ajaxTraerTestimonios();
}