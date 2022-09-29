/*****
 * valores genericos de URL de los input hidden
 */

const urlPrincipal = $("#urlPrincipal").val();
const urlServidor = $("#urlServidor").val();


/* FECHA RESERVAS */

$('.datepicker.entrada').datepicker({
    startDate: '0d', //q empiece mostrando el día 0, o sea el día actual.
    format: 'yyyy-mm-dd', //formateo la fecha q muestra
    todayHighlight: true, //q remarque la selección.
    autoclose: true
});

$('.datepicker.entrada').change(function() {
    let fechaEntrada = $(this).val();
    //console.log(fechaEntrada);

    $('.datepicker.salida').val("") /* .datepicker("update") */ ;
    $('.datepicker.salida').attr("readonly", false);


    $('.datepicker.salida').datepicker({
        format: 'yyyy-mm-dd',
        startDate: fechaEntrada,
        datesDisabled: fechaEntrada,
        autoclose: true
    }).datepicker("update");
});


/*
BOTON Reserva
 */
document.querySelector(".mostrarBloqueReservas").addEventListener('click', function() {
    $(".formReservas").slideToggle("fast");
    $(".menu").slideUp('fast');

    if ($('.mostrarBloqueReservas').attr('modo') == "abajo") {
        /*esconde form reserva*/
        $('.mostrarBloqueReservas').attr('modo', "arriba");
        $('.flechaReserva').removeClass("fa-caret-up");
        $('.flechaReserva').addClass("fa-caret-down");
    } else {
        /*muestra form reserva*/
        $('.mostrarBloqueReservas').attr('modo', "abajo");
        $('.flechaReserva').removeClass("fa-caret-down");
        $('.flechaReserva').addClass("fa-caret-up");
    }
    posicionBloqueReservas();
})


/***********************
 * 
 * Animaciones con el scroll
 */

$(window).scroll(function() {
    let posY = window.pageYOffset;
    //console.log(posY);

    if (window.matchMedia("(min-width:768px)").matches) { //@media, sólo afecta en pantallas menores a 769px.

        if (posY > 50) {
            $(".formReservas").slideUp("fast");

            /*esconde form reserva*/
            $('.mostrarBloqueReservas').attr('modo', "arriba");
            $('.flechaReserva').removeClass("fa-caret-up");
            $('.flechaReserva').addClass("fa-caret-down");

        }
    }
    posicionBloqueReservas();
})

/***********************
 * 
 * Botones Idioma
 */

$(".idiomaEn").click(function() {
    $(this).removeClass("bg-white");
    $(this).removeClass("text-dark");

    $(this).addClass("bg-info");
    $(this).addClass("text-white");

    $(".idiomaEs").removeClass("bg-info");
    $(".idiomaEs").removeClass("text-white");

    $(".idiomaEs").addClass("bg-white");
    $(".idiomaEs").addClass("text-dark");
})

$(".idiomaEs").click(function() {
    $(this).removeClass("bg-white");
    $(this).removeClass("text-dark");

    $(this).addClass("bg-info");
    $(this).addClass("text-white");

    $(".idiomaEn").removeClass("bg-info");
    $(".idiomaEn").removeClass("text-white");

    $(".idiomaEn").addClass("bg-white");
    $(".idiomaEn").addClass("text-dark");
})

/*boton menu*/
if (window.matchMedia("(max-width:768px)").matches) { //@media, sólo afecta en pantallas menores a 769px.

    $(".botonMenu").click(function() {
        $(".menuMovil").slideToggle('fast');

        /** posisciono el menuMovil para q se vea luego del header*/
        $(".menuMovil").css({ "top": $("header").height() })
    })
    $(".menuMovil ul li a").click(function(e) {
        $(".menuMovil").slideToggle('fast');
        e.preventDefault();

        let vinculo = $(this).attr("href");
        //console.log(vinculo);
        $("html, body").animate({
            scrollTop: $(vinculo).offset().top - 62 //62 es para q la cabecera no tape el titulo -
        }, 1000, "easeInOutBack"); //1000 = q suceda en un segundo...
        //"easeInOutBack" es opcional y los efectos están en: https://easings.net/
    })

} else { //@media, sólo afecta en pantallas mayores a 769px.

    $(".botonMenu").click(function() {
        $(".menu").slideToggle('fast');
        $(".formReservas").slideUp('fast');
    })

    $(".menu ul li a").click(function(e) {
        $(".menu").slideToggle('fast');
        e.preventDefault();

        let vinculo = $(this).attr("href");
        //console.log(vinculo);
        $("html, body").animate({
            scrollTop: $(vinculo).offset().top - 62 //62 es para q la cabecera no tape el titulo -
        }, 1000, "easeInOutBack"); //1000 = q suceda en un segundo...
        //"easeInOutBack" es opcional y los efectos están en: https://easings.net/
    })

}

$(".btnModalPlan ").click(function(e) {
    e.preventDefault();
    let vinculo = $(this).attr("href");
    //console.log(vinculo);
    $("html, body").animate({
        scrollTop: $(vinculo).offset().top - 62 //62 es para q la cabecera no tape el titulo -
    }, 1000, "easeInOutBack"); //1000 = q suceda en un segundo...
    //"easeInOutBack" es opcional y los efectos están en: https://easings.net/
})

/********
 * Scroll UP
 */

$.scrollUp({
    scrollText: "",
    scrollSpeed: 2000,
    //easingType: "easeOutBounce" //los efectos están en: https://easings.net/
    easingType: "easeOutCirc"
})

/********
 * Banner - sliderr | https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html
 */

$('.fade-slider').jdSlider({
    isSliding: true,
    isAuto: true,
    isLoop: true,
    isDrag: false,
    interval: 7000,
    isCursor: false,
    speed: 3000
})

$(".verMas").click(function() {
    let vinculo = $(this).attr("vinculo");

    $("html, body").animate({
        scrollTop: $(vinculo).offset().top - 62 //62 es para q la cabecera no tape el titulo -
    }, 1000, "easeInOutBack"); //1000 = q suceda en un segundo...
    //"easeInOutBack" es opcional y los efectos están en: https://easings.net/
});

$('.banner .fade-slider').css(({ "margin-top": $('header').height() }));

/*********************
 * Interaccion Planes
 *********************/
$('.planes .grid-item').mouseover(function() {

    //efecto para bajar el sombreado de las fotos
    $(this).children("figure").css({
        "height": "25%",
        "transition": ".5s all"
    });

    //efecto para cambiar el título de la descripción según donde tenga el mouse
    $(".tituloPlan").html($(this).children("figure").children("h1").html());

    //efecto para cambiar el texto de la descripción según donde tenga el mouse
    $(".descripcionPlan").html($(this).children("figure").children("h1").attr("descripcion"));
})

$('.planes .grid-item').mouseout(function() {

    //efecto para volver a subir el sombreado de las fotos
    $(this).children("figure").css({
        "height": "100%",
        "transition": ".5s all"
    });

    //efecto para devolver el título "Bienvenidos" en la descripción
    $(".tituloPlan").html($(".tituloPlan").attr("tituloPlan"));

    //efecto para devolver el texto de "Bienvenidos" en la descripción
    $(".descripcionPlan").html($(".descripcionPlan").attr("descripcionPlan"));

})

/****************************
 * Interaccion Planes Movil *
 ****************************/
$('.planesMovil').jdSlider({
    wrap: '.slide-inner',
    slideShow: 3,
    slideToScroll: 3,
    isLoop: false
})

/*para movil*/
$(".planesMovil li").click(function() {

    $(".modal-title").html($(this).children("a").children("h6").html());

    $(".modal-body img").attr("src", $(this).children("a").children("img").attr("src"));

    $(".modal-body p").html($(this).children("a").attr("descripcion"));
})

/*para pc*/
$(".planes .grid-item").click(function() {

    $(".modal-title").html($(this).children("figure").children("h1").html());

    $(".modal-body img").attr("src", $(this).children("img").attr("src"));

    $(".modal-body p").html($(this).children("figure").children("h1").attr("descripcion"));
})


/****************************
 * Recorrido por el pueblo *
 ****************************/
$(".slidePueblo").jdSlider();


/*****************************
 * Restaurante               *
 ****************************/
$(".restaurante .carta div").hide();

if (window.matchMedia("(max-width:768px)").matches) {

    $(".restaurante .verCarta").click(function() {
        $(".restaurante .bloqueRestaurante").slideToggle("fast");
        $(".restaurante .carta div").slideToggle("fast");
        $(".restaurante .carta div").css(({
            "background": "rgba(0,0,0,0.7)"
        }));
        $(".contactenos").css(({
            "margin-top": "0px"
        }));
    });

    $(".restaurante .volverCarta").click(function() {
        $(".restaurante .bloqueRestaurante").slideToggle("fast");
        $(".restaurante .carta div").slideToggle("fast");
        /* $(".restaurante .carta div").css(({
            "background": "rgba(0,0,0,0.7)"
        })); */
        $(".contactenos").css(({
            "margin-top": "-80px"
        }));
    });

} else {

    $(".restaurante .verCarta").click(function() {
        $(".restaurante .carta div").slideToggle("fast");
        $(".restaurante .carta div").css(({
            "background": "rgba(0,0,0,0.7)"
        }));
    })

}

/***********************
 * Slide Habitaciones
 */
$(".slideHabitaciones").jdSlider({
    isSliding: true,
    isAuto: true,
    isLoop: true,
    isDrag: true,
    interval: 3000,
    isCursor: false,
    margin: 0,
    timingFunction: 'ease',
    easing: 'swing'
});

/***********************
 * 360°
 */
$("#myPano").pano({
    img: $("#myPano").attr("back")
});

/***********************
 * visualizar multimedia
 */

$(".colIzqHabitaciones button").click(function() {
    const vista = $(this).attr("vista");
    if (vista == "fotos") {
        $(".slideHabitaciones").removeClass("d-none");
        $(".slideHabitaciones").addClass("d-block");

        $(".videoHabitaciones").addClass("d-none");
        $(".videoHabitaciones").removeClass("d-block");

        $(".360Habitaciones").addClass("d-none");
        $(".360Habitaciones").removeClass("d-block");
    }

    if (vista == "video") {
        $(".slideHabitaciones").addClass("d-none");
        $(".slideHabitaciones").removeClass("d-block");

        $(".videoHabitaciones").removeClass("d-none");
        $(".videoHabitaciones").addClass("d-block");

        $(".360Habitaciones").addClass("d-none");
        $(".360Habitaciones").removeClass("d-block");
    }

    if (vista == "360") {
        $(".slideHabitaciones").addClass("d-none");
        $(".slideHabitaciones").removeClass("d-block");

        $(".videoHabitaciones").addClass("d-none");
        $(".videoHabitaciones").removeClass("d-block");

        $(".360Habitaciones").removeClass("d-none");
        $(".360Habitaciones").addClass("d-block");
    }
})


/***********************************************
 * POSICION bloque resrva en habitaciones.html *
 ***********************************************/

function posicionBloqueReservas() {
    if (window.matchMedia("(min-width:769px)").matches) {
        if ($(".mostrarBloqueReservas").attr("modo") == "abajo") {
            $(".colDerHabitaciones").css({ "margin-top": "120px" });
            $(".colDerReservas").css({ "margin-top": "120px" });
            $(".colDerPerfil").css({ "margin-top": "120px" });
        }
        if ($(".mostrarBloqueReservas").attr("modo") == "arriba") {
            $(".colDerHabitaciones").css({ "margin-top": "0px" });
            $(".colDerReservas").css({ "margin-top": "0px" });
            $(".colDerPerfil").css({ "margin-top": "0px" });
        }
    } else {
        $(".colDerHabitaciones").css({ "margin-top": "20px" });
        $(".colDerReservas").css({ "margin-top": "20px" });
        $(".colDerPerfil").css({ "margin-top": "20px" });
    }
}

posicionBloqueReservas();


if (window.matchMedia("(max-width:768px)").matches) {
    $(".infoHabitacion .colIzqHabitaciones").css({ "margin-top": $("header").height() });
    $(".infoReservas .colIzqReservas").css({ "margin-top": $("header").height() });
    $(".infoPerfil .colIzqPerfil").css({ "margin-top": ($("header").height() + 100) + "px" });
}