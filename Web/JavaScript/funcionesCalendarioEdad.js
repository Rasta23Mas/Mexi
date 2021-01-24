$(document).ready(function () {
    var anioActual =  (new Date).getFullYear();
    var anioMenor = anioActual - 90;
    var anioMayor = anioActual + 1;
    $( ".calendarioMod" ).datepicker({
        showOn: "focus",
        buttonImage: "../../img/calendario3.png",
        buttonImageOnly: true,
        buttonText: "Selecciona el día",
        changeMonth: true,
        changeYear: true,
        yearRange: anioMenor +":" + anioMayor,
        dateFormat: 'yy-mm-dd'
    });
    $( ".calendarioModBoton" ).datepicker({
        showOn: "button",
        buttonImage: "../../img/calendario3.png",
        buttonImageOnly: true,
        buttonText: "Selecciona el día",
        changeMonth: true,
        changeYear: true,
        yearRange:  anioMenor +":" + anioMayor,
        dateFormat: 'yy-mm-dd'
    });


    $.datepicker.regional['es'] =
        {
            closeText: 'Cerrar',
            prevText: 'Previo',
            nextText: 'Próximo',
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
                'Jul','Ago','Sep','Oct','Nov','Dic'],
            monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
            dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
            dateFormat: 'dd/mm/yy', firstDay: 0,
            initStatus: 'Selecciona la fecha', isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $( ".calendarioMod" ).datepicker({ minDate: "-1D", maxDate: "+1M +10D" });

});
