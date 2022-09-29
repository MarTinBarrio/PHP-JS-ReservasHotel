<?php
 
 include_once "../backend/controladores/usuario.controlador.php";
 include_once "../backend/modelos/usuario.modelo.php";

 Class AjaxUsuario{
     public $validarEmail;

     public function ajaxValidarEmail(){
        $valor = $this->validarEmail;
        $respuesta = ControladorUsuario::ctrlMostrarUsuario('email', $valor);
        echo json_encode($respuesta);
     }

     //validación de ingreso con Facebook
     public $email;
     public $nombre;
     public $foto;

    public function ajaxRegistroFacebook(){
        $datos = array(
            "nombre" => $this->nombre,
            "email" => $this->email,
            "foto" => $this->foto,
            "password" => null,
            "modo" => "facebook",
            "verificacion" => 1,
            "email_encriptado" => null,
        );
        $respuesta = ControladorUsuario::ctrlRegistroRedesSociales($datos);
        
        echo $respuesta;
    }
 }

//validar mail existente
if (isset($_POST["validarEmail"])){
     $valEmail = new AjaxUsuario();
     $valEmail -> validarEmail = $_POST["validarEmail"];
     $valEmail -> ajaxValidarEmail();
}

/**Registor con FaceBook */
if(isset($_POST["email"])){
    $regFaceBook = new AjaxUsuario();
    $regFaceBook -> email = $_POST["email"];
    $regFaceBook -> nombre = $_POST["nombre"];
    $regFaceBook -> foto = $_POST["foto"];
    $regFaceBook -> ajaxRegistroFacebook();
}