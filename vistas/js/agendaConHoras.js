/***
 * date Time picker.. idem datepicker pero puedo seleccionar horas
 */

$.datetimepicker.setLocale('es'); //seteo idioma


$('.datepicker.entrada').datetimepicker({
    format: 'Y-m-d H:00:00',
    minDate: 0, //día actual, el 1er día para poder seleccionar
    nimTime: 0,
    defaultTime: (new Date().getHours() + 1) + ":00", //desde cuando puedo seleecionar: dia de hoy, una hora posterior a la actual
    allowTimes: [ //horarios permitidos para seleccionar...
        '08:00',
        '09:00',
        '10:00',
        '11:00',
        '12:00',
        '13:00',
        '14:00',
        '15:00',
        '16:00',
        '17:00',
        '18:00',
    ],
    disabledWeekDays: [0, 6], //deshabilito algunos días la semana, ej: Sab y Domingo.
    closeOnDateSelect: false

});

$('.datepicker.entrada').change(function() {

    let fechaEntrada = $(this).val().split(" "); //con split lo convierto en un array tomando separador de campor el espacio:('yyyy-mm-dd', 'hh:mm');
    //console.log(fechaEntrada);

    let horaEntrada = new Date($(this).val());

    $('.datepicker.salida').attr("readonly", true); //para q no la modifiquen.
    $('.datepicker.salida').val(fechaEntrada[0] + " " + (horaEntrada.getHours() + 1) + ":00:00"); //imprimo la salida, el mismo día una hora posterior.
});


/***** Para mostrar el calendario como una agenda: */

function calendario(totalEventos) {

    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialDate: fechaEntrada, //para q ubique el calendairo en esa fecha.
        defaultView: 'agendaFourDay',
        allDaySlot: false,
        scrollTime: fechaEntrada.getHours() + ":00:00",

        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        events: totalEventos,
        views: {
            agendaFourDay: {
                type: 'agenda',
                duration: { days: 4 }
            }
        },
        locales: 'Es',
    });
    calendar.render();
}