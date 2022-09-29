/****************
 * colocar activo el 1er boton
 */

let enlacesHabitaciones = $(".cabeceraHabitacion ul.nav li.nav-item a");
let tituloBtn = [];

for (let i = 0; i < enlacesHabitaciones.length; i++) {

    $(enlacesHabitaciones[i]).removeClass("active");
    $(enlacesHabitaciones[i]).children("i").remove();
    tituloBtn[i] = $(enlacesHabitaciones[i]).html();
}

$(enlacesHabitaciones[0]).addClass("active");
$(enlacesHabitaciones[0]).html('<i class="fas fa-chevron-right"></i>' + tituloBtn[0]);

/* quito el útlimo borde d los enlaces */
$(enlacesHabitaciones[enlacesHabitaciones.length - 1]).css({ "border-right": 0 });

/**********************
 * Enlaces habitaciones
 */

$(".cabeceraHabitacion ul.nav li.nav-item a").click(function(e) {
    e.preventDefault();

    let orden = $(this).attr("orden");
    let ruta = $(this).attr("ruta");

    for (let i = 0; i < enlacesHabitaciones.length; i++) {

        $(enlacesHabitaciones[i]).removeClass("active");
        $(enlacesHabitaciones[i]).children("i").remove();
        tituloBtn[i] = $(enlacesHabitaciones[i]).html();
    }

    $(enlacesHabitaciones[orden]).addClass("active");
    $(enlacesHabitaciones[orden]).html('<i class="fas fa-chevron-right"></i>' + tituloBtn[orden]);


    /******
     * conexión con ajax habitaciones
     */

    /*creo lista con los li para la img */
    const listaSlide = $(".slideHabitaciones .slide-inner .slide-area li");
    const alturaSlide = $(".slideHabitaciones .slide-inner .slide-area").height();

    /*limpio todos los elementos de la lista de la galeria de la imagenes */
    for (let i = 0; i < listaSlide.length; i++) {
        $(".slideHabitaciones .slide-inner .slide-area").css({ "height": alturaSlide + "px" });
        $(listaSlide[i]).html('');

    }



    /**armo el "datos" q le paso a ajax */
    let datos = new FormData();
    datos.append("ruta", ruta);
    //console.log("rurlPrincipaluta: ", urlPrincipal+"ajax/habitaciones.ajax.php");

    /**ejecuto ajax */
    $.ajax({
        url: urlPrincipal + "ajax/habitaciones.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
            /**
            console.log("respuesta", respuesta);
              *m devuelve un jason con todos los tipos, entonces con [orden] m posiciono en el boton seleccionado
            console.log("respuesta", respuesta[orden]);
            */

            let galeria = JSON.parse(respuesta[orden]["galeria"]);
            //console.log(galeria);
            //seteando las fotos de la galeria de la habitación
            /*El plugin jslider tiene seteada la opción de loop infinito, y para eso requiere..
            en este caso con 4 fotos, q se muestre la ultima (en este caso la 4ta), luego de la
            primera a la última, y luego otra vez la 1era*/

            for (let i = 0; i < galeria.length; i++) {
                $(listaSlide[0]).html('<img class="img-fluid" src="' + urlServidor + galeria[galeria.length - 1] + '">'); //la ultima img
                $(listaSlide[i + 1]).html('<img class="img-fluid" src="' + urlServidor + galeria[i] + '">');
                $(listaSlide[galeria.length + 1]).html('<img class="img-fluid" src="' + urlServidor + galeria[0] + '">'); //la primer img
            }

            $(".videoHabitaciones iframe").attr("scr", "http://www.youtube.com/embed/" + respuesta[orden]["video"]);
            $("#myPano").attr("back", urlServidor + respuesta[orden]["recorrido_virtual"]);
            $(".descripcionHabitacion h1").html(respuesta[orden]["estilo"] + " " + respuesta[orden]["tipo"]);
            $(".d-habitacion").html(respuesta[orden]["descripcion_h"]);
            $('input[name="id-habitacion"]').val(respuesta[orden]["id_h"]);

            /***
             * traer testimonios */

            const datosTestimonios = new FormData();
            datosTestimonios.append("id_h", respuesta[orden]["id_h"]);
            /**ejecuto ajax */
            $.ajax({
                url: urlPrincipal + "ajax/reservas.ajax.php",
                method: "POST",
                data: datosTestimonios,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta) {
                    //console.log(respuesta);
                    let cantidadTestimonios = 0;
                    let idTestimonios = [];

                    $(".testimonios .row").html(""); //vacio los testimonios
                    $(".verMasTestimonios").remove();
                    $(".verMenosTestimonios").remove();
                    $(".testimonios .row").css({ 'height': "auto" });

                    for (let i = 0; i < respuesta.length; i++) {
                        if (respuesta[i]["aprobado"] != 0) {
                            cantidadTestimonios++;
                            idTestimonios.push(respuesta[i]["id_testimonio"]);
                        }
                    }

                    if (cantidadTestimonios >= 4) {
                        let foto = [];

                        for (let i = 0; i < idTestimonios.length; i++) {

                            if (respuesta[i]["foto"] == "") {
                                foto[i] = urlServidor + "vistas/img/usuarios/default/default.png";
                            } else {
                                if (respuesta[i]["modo"] == "directo") {
                                    foto[i] = urlServidor + respuesta[i]["foto"];
                                } else {
                                    foto[i] = respuesta[i]["foto"];
                                }

                            }

                            $(".testimonios .row").append(`
                                <div class="col-12 col-lg-3 text-center p-4">
                                    <img src="` + foto[i] + `" class="img-fluid rounded-circle w-50">
                                    <h4 class="py-4">` + respuesta[i]["nombre"] + `</h4>
                                    <p>` + respuesta[i]["testimonio"] + `</p>
                                </div>
                            
                            `);
                            $("testimonios .row").css({ 'height': $(".testimonios .row div").height() + 50 + "px", 'overflow': 'hidden' });
                        }
                    } else {
                        $(".testimonios .row").html('<div class="col-12 text-white text-center">¡Esta habitación aún no tiene testimonios!</div>');
                    }

                    if (cantidadTestimonios > 4) {
                        $(".testimonios .row").after(`
                            <button class="btn btn-default px-4 float-right verMasTestimonios">VER MAS</button>
                        `);
                    }


                }
            });
        }
    });
});

/***
 * Bloque ver, mas testimonios
 */

const alturaTestimonios = $(".testimonios .row").height();
//console.log("alturaTestimonios: ", alturaTestimonios);
const alturaTestimoniosCorta = $(".testimonios .row div").height() + 50;
$(".testimonios .row").css({
    'height': alturaTestimoniosCorta + "px",
    'overflow': 'hidden'
});

$(document).on("click", ".verMasTestimonios", function() {
    $(".testimonios .row").css({
        'height': alturaTestimonios + "px",
        'overflow': 'hidden'
    });
    $(this).removeClass("verMasTestimonios");
    $(this).addClass("verMenosTestimonios");
    $(this).html("Ver menos");
});

$(document).on("click", ".verMenosTestimonios", function() {
    $(".testimonios .row").css({
        'height': alturaTestimoniosCorta + "px",
        'overflow': 'hidden'
    });
    $(this).removeClass("verMenosTestimonios");
    $(this).addClass("verMasTestimonios");
    $(this).html("Ver mas");
});