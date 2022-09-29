<?php
 
 include_once "../backend/controladores/habitaciones.controlador.php";
 include_once "../backend/modelos/habitaciones.modelo.php";

 Class AjaxHabitaciones{
     public $ruta;
     public function ajaxTraerHabitacion(){
        $respuesta = ControladorHabitaciones::ctrlMostrarHabitaciones($this->ruta);
        echo json_encode($respuesta);
     }
 }

 if (isset($_POST["ruta"])){
     $ruta = new AjaxHabitaciones();
     $ruta -> ruta = $_POST["ruta"];
     $ruta -> ajaxTraerHabitacion();
 }