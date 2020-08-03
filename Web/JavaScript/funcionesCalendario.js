$(document).ready(function () {
    var anioActual =  (new Date).getFullYear();
    var anioMenor = anioActual - 18;
    var anioMayor = anioActual + 1;
    $( ".calendarioMod" ).datepicker({
        showOn: "focus",
        buttonImage: "../../img/calendario3.png",
        buttonImageOnly: true,
        buttonText: "Selecciona el día",
        changeMonth: true,
        changeYear: true,
        yearRange: anioMenor +":" + anioMayor,
        dateFormat: 'dd-mm-yy'
    });
    $( ".calendarioModBoton" ).datepicker({
        showOn: "button",
        buttonImage: "../../img/calendario3.png",
        buttonImageOnly: true,
        buttonText: "Selecciona el día",
        changeMonth: true,
        changeYear: true,
        yearRange:  anioMenor +":" + anioMayor,
        dateFormat: 'dd-mm-yy'
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

/*
$(document).ready(function () {
    var dateFormat = "dd-mm-yy",
        from = $("#idFechaInicial")
            .datepicker({
                showOn: "focus",
                buttonImage: "../../img/calendario3.png",
                buttonImageOnly: true,
                buttonText: "Selecciona el día",
                changeMonth: true,
                changeYear: true,
                yearRange: "1960:-18",
                dateFormat: 'dd-mm-yy'
            })
            .on("change", function () {
                to.datepicker("option", "minDate", getDate(this));
            }),
        to = $("#idFechaFinal").datepicker({
            showOn: "focus",
            buttonImage: "../../img/calendario3.png",
            buttonImageOnly: true,
            buttonText: "Selecciona el día",
            changeMonth: true,
            changeYear: true,
            yearRange: "1960:+1",
            dateFormat: 'dd-mm-yy'
        })
            .on("change", function () {
                from.datepicker("option", "maxDate", getDate(this));
            });

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }
});*/
