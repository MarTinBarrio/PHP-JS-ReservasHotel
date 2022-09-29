/*****
 * Select anidados */

$(".selectTipoHabitacion").change(function() {

    let ruta = $(this).val();

    if (ruta != "") {
        $(".selectTemaHabitacion").html("");
    } else {
        $(".selectTemaHabitacion").html('<option>Temática de habitación</option>');
    }

    /**preparo el ajax */
    let datos = new FormData();
    datos.append("ruta", ruta);
    //console.log(urlPrincipal + "ajax/habitaciones.ajax.php");
    //console.log(datos);
    $.ajax({
        url: urlPrincipal + "ajax/habitaciones.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            //console.log(respuesta);

            $("input[name='ruta']").val(respuesta[0]["ruta"]);

            for (let i = 0; i < respuesta.length; i++) {
                //console.log(respuesta[i]["estilo"]);
                $(".selectTemaHabitacion").append('<option value="' + respuesta[i]["id_h"] + '">' + respuesta[i]["estilo"] + '</option>');
            }
        }
    })
})



/**************
 * CALENDARIO */

if ($(".infoReservas").html() != undefined) {

    let idHabitacion = $(".infoReservas").attr("idHabitacion");
    let fechaIngreso = $(".infoReservas").attr("fechaIngreso");
    let fechaSalida = $(".infoReservas").attr("fechaSalida");
    let dias = $(".infoReservas").attr("dias");

    let datos = new FormData();
    let totalEventos = [];
    let disponible = true;

    datos.append("idHabitacion", idHabitacion);

    /**ejecuto ajax */
    $.ajax({
        url: urlPrincipal + "ajax/reservas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            //console.log(respuesta);
            if (respuesta.length == 0) {
                totalEventos.push({
                    title: 'Tu reserva',
                    start: fechaIngreso,
                    end: fechaSalida,
                    rendering: 'background',
                    color: "#FFCC29"
                });
                columnaDerReservas();
            } else {



                for (let i = 0; i < respuesta.length; i++) {
                    //console.log(respuesta[i]["fecha_ingreso"]);
                    //console.log(respuesta[i]["fecha_salida"]);

                    totalEventos.push({
                        title: 'No Disponible',
                        start: respuesta[i]["fecha_ingreso"],
                        end: respuesta[i]["fecha_salida"],
                        display: 'background',
                        color: "#847059"
                    });

                    if (respuesta[i]["fecha_ingreso"] == fechaIngreso) {
                        disponible = false;
                        $(".colDerReservas").hide();
                    }
                    if (respuesta[i]["fecha_ingreso"] < fechaIngreso && respuesta[i]["fecha_salida"] > fechaIngreso) {
                        disponible = false;
                        $(".colDerReservas").hide();
                    }
                    if (respuesta[i]["fecha_ingreso"] < fechaSalida && respuesta[i]["fecha_salida"] > fechaSalida) {
                        disponible = false;
                        $(".colDerReservas").hide();
                    }
                }


                if (disponible) {
                    totalEventos.push({
                        title: 'Tu reserva',
                        start: fechaIngreso,
                        end: fechaSalida,
                        rendering: 'background',
                        color: "#FFCC29"
                    });
                    $(".infoDisponibilidad").html('<h5 class="pb-5 float-left">Está disponible!</h5>');
                    columnaDerReservas();

                } else {
                    $(".infoDisponibilidad").html('<h5 class="pb-5 float-left">Lo sentimos, no hay disponibilidad para esa fecha!<br><br><strong>¡Vuelve a intentarlo!</strong></h5>');
                }
            }
            calendario(fechaIngreso, totalEventos);
        }
    });



    /******/

}

function calendario(fechaIngreso, totalEventos) {

    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        initialDate: fechaIngreso,
        /* initialView: 'timeGridWeek', */
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        events: totalEventos,
        /* eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
            timeText: 'false',
            display: 'false'
        }, */
        displayEventTime: false,
        locales: 'Es',
    });
    calendar.render();
}





/*========================================================================*/
/* 
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                events: [{

                        start: "2022-08-28",
                        end: "2022-08-30",
                        // rendering: 'background',
                        display: 'background',
                        color: "#847059"
                    },
                    {
                        start: '2022-08-01',
                        end: '2022-08-09T15:00:00',
                        rendering: 'background',
                        color: "#FFCC29",
                        text: ""
                    }
                ],
                locales: 'Es',
            });
            calendar.render();
        }); */

/*========================================================================*/


/**
 * Genero código aleatorio para las reservas
 */

const chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

function codigoAleatorio(chars, length) {
    codigo = "";
    for (let i = 0; i < length; i++) {
        rand = Math.floor(Math.random() * chars.length);
        codigo += chars.substr(rand, 1);
    }
    return codigo;
}

let dias = $(".infoReservas").attr("dias");

function columnaDerReservas() {


    $(".colDerReservas").show();
    const codigoReserva = codigoAleatorio(chars, 9);

    //console.log(codigoReserva);

    let datos = new FormData();
    //datos.append("codigoReserva", "9YXR0H47T");
    datos.append("codigoReserva", codigoReserva);

    /**ejecuto ajax */
    $.ajax({
        url: urlPrincipal + "ajax/reservas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            //console.log(respuesta);
            if (!respuesta) {
                $(".codigoReserva").html(codigoReserva);
                $(".pagarReserva").attr("codigoReserva", codigoReserva);
            } else {
                console.log("reintentar la reserva");

            }
            /**
             * cambio de plan
             */

            $(".elegirPlan").change(function() {
                modifcarTotal();
            })

            /**
             * cambio de cantidad de personas
             */
            $(".cantidadPersonas").change(function() {
                modifcarTotal();
            })

        }
    });
}

function modifcarTotal() {
    switch ($(".cantidadPersonas").val()) {
        case "2":

            total = Intl.NumberFormat('sp-AR', {
                style: 'currency',
                currency: 'ARS',
                minimumFractionDigits: 2
            }).format($(".elegirPlan").val().split(",")[0] * dias);

            $(".precioReserva span").html(total);

            $(".pagarReserva").attr("pagoReserva", total);
            $(".pagarReserva").attr("plan", $(".elegirPlan").val().split(",")[1]);
            $(".pagarReserva").attr("personas", $(".cantidadPersonas").val());

            break;

        case "3":

            total = Intl.NumberFormat('sp-AR', {
                style: 'currency',
                currency: 'ARS',
                minimumFractionDigits: 2
            }).format(Number($(".elegirPlan").val().split(",")[0] * 0.25) +
                Number($(".elegirPlan").val().split(",")[0] * dias));

            $(".precioReserva span").html(total);

            $(".pagarReserva").attr("pagoReserva", total);
            $(".pagarReserva").attr("plan", $(".elegirPlan").val().split(",")[1]);
            $(".pagarReserva").attr("personas", $(".cantidadPersonas").val());

            break;

        case "4":
            total = Intl.NumberFormat('sp-AR', {
                style: 'currency',
                currency: 'ARS',
                minimumFractionDigits: 2
            }).format(Number($(".elegirPlan").val().split(",")[0] * 0.5) +
                Number($(".elegirPlan").val().split(",")[0] * dias));

            $(".precioReserva span").html(total);

            $(".pagarReserva").attr("pagoReserva", total);
            $(".pagarReserva").attr("plan", $(".elegirPlan").val().split(",")[1]);
            $(".pagarReserva").attr("personas", $(".cantidadPersonas").val());

            break;

        case "5":
            total = Intl.NumberFormat('sp-AR', {
                style: 'currency',
                currency: 'ARS',
                minimumFractionDigits: 2
            }).format(Number($(".elegirPlan").val().split(",")[0] * 0.75) +
                Number($(".elegirPlan").val().split(",")[0] * dias));

            $(".precioReserva span").html(total);

            $(".pagarReserva").attr("pagoReserva", total);
            $(".pagarReserva").attr("plan", $(".elegirPlan").val().split(",")[1]);
            $(".pagarReserva").attr("personas", $(".cantidadPersonas").val());

            break;
    }
}


/**
 * captura datos de la reserva para mostrarlo en la pag perfil | uso de cookies!
 */

$(".pagarReserva").click(function() {


    const idHabitacion = $(this).attr("idHabitacion");
    const imgHabitacion = $(this).attr("imgHabitacion");
    const infoHabitacion = $(this).attr("infoHabitacion");
    const pagoReserva = $(this).attr("pagoReserva");
    const codigoReserva = $(this).attr("codigoReserva");
    const fechaIngreso = $(this).attr("fechaIngreso");
    const fechaSalida = $(this).attr("fechaSalida");
    const personas = $(this).attr("personas");
    const plan = $(this).attr("plan");

    /**
     * creación de cookie
     */
    crearCookie("idHabitacion", idHabitacion, 1);
    crearCookie("imgHabitacion", imgHabitacion, 1);
    crearCookie("infoHabitacion", infoHabitacion, 1);
    crearCookie("pagoReserva", pagoReserva, 1);
    crearCookie("codigoReserva", codigoReserva, 1);
    crearCookie("fechaIngreso", fechaIngreso, 1);
    crearCookie("fechaSalida", fechaSalida, 1);
    crearCookie("personas", personas, 1);
    crearCookie("plan", plan, 1);
    //    crearCookie("transferenciaEnviada", false, 1);

})

/**
 * Función para generar las cookies
 */
function crearCookie(nombre, valor, diasExpiracion) {
    const hoy = new Date();

    hoy.setTime(hoy.getTime() + (diasExpiracion * 24 * 60 * 60 * 1000));

    const fechaExpiracion = "expires=" + hoy.toUTCString();
    document.cookie = nombre + "=" + valor + "; " + fechaExpiracion;
}