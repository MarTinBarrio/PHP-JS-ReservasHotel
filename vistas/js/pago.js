/* document.addEventListener('DOMContentLoaded', function() {
    eventListeners();
}); */


if (document.querySelector(".enviarPago") != undefined) {

    const botonPago = document.querySelector(".enviarPago");
    botonPago.addEventListener('click', enviaComprobante);
}


function enviaComprobante() {

    /****tomo el valor del comrpobante */
    codComprobante = document.querySelector(".codigoPago").value;
    //console.log("comprobante: ", codComprobante);

    if (codComprobante.length < 4) {
        alert("Ingresa un código de transferencia válido!");
    } else {

        /**borro cookies
        document.cookie = "pagoReserva=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
        document.cookie = "idHabitacion=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
        document.cookie = "imgHabitacion=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
        document.cookie = "infoHabitacion=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
        document.cookie = "codigoReserva=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
        document.cookie = "fechaIngreso=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
        document.cookie = "fechaSalida=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
        document.cookie = "plan=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
        document.cookie = "personas=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
        document.cookie = "personas=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";

        */

        crearCookie("codTransferencia", codComprobante, 1);
        crearCookie("transferenciaEnviada", true, 1);

        modal = document.getElementById('infoPago');
        //        console.log("modal: ", modal);
        setTimeout(() => {
            window.location.reload();
        }, 500);

    }

}

function borrarCookies() {

    console.log("Borrando cookieas");

    document.cookie = "pagoReserva=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
    document.cookie = "idHabitacion=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
    document.cookie = "imgHabitacion=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
    document.cookie = "infoHabitacion=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
    document.cookie = "codigoReserva=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
    document.cookie = "fechaIngreso=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
    document.cookie = "fechaSalida=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
    document.cookie = "plan=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
    document.cookie = "personas=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
    document.cookie = "transferenciaEnviada=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
    document.cookie = "codTransferencia=; expires=Thuy, 01 Jan 1970 00:00:00 UTC; path=' . $ruta . ';";
}