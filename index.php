<?php
require_once "controladores/plantilla.controlador.php";
require_once "controladores/ruta.controlador.php";

require_once "backend/controladores/banner.controlador.php";
require_once "backend/modelos/banner.modelo.php";

require_once "backend/controladores/planes.controlador.php";
require_once "backend/modelos/planes.modelo.php";

require_once "backend/controladores/categorias.controlador.php";
require_once "backend/modelos/categorias.modelo.php";

require_once "backend/controladores/recorrido.controlador.php";
require_once "backend/modelos/recorrido.modelo.php";

require_once "backend/controladores/restaurante.controlador.php";
require_once "backend/modelos/restaurante.modelo.php";

require_once "backend/controladores/habitaciones.controlador.php";
require_once "backend/modelos/habitaciones.modelo.php";

require_once "backend/controladores/reservas.controlador.php";
require_once "backend/modelos/reservas.modelo.php";

require_once "backend/controladores/usuario.controlador.php";
require_once "backend/modelos/usuario.modelo.php";

require_once "vendor/autoload.php";

$plantilla = new controladorPlantilla();
$plantilla -> ctrPlantilla();