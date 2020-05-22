var contador = 1;
function myFunction(x){
    if(contador%2!==0){
        x.classList.toggle("change");
        var a = document.getElementById('menu');
        a.style.display="block";
        contador+=1;
    }
    else{
        if(contador%2===0){
            x.classList.toggle("change");
            var a = document.getElementById('menu');
            a.style.display="none";
            contador+=1;
        }
    }
}
var cont = 1;
function menu(x, opc){

        x.classList.toggle("change");
        var a;
        switch (opc) {
            case 1:
                a = document.getElementById('empeño');
                break;
            case 2:
                a = document.getElementById('cierre');
                break;
            case 3:
                a = document.getElementById('ventas');
                break;
            case 4:
                a = document.getElementById('inventario');
                break;
            case 5:
                a = document.getElementById('reportes');
                break;
            case 6:
                a = document.getElementById('movimientos');
                break;
            case 7:
                a = document.getElementById('antilavado');
                break;
            case 8:
                a = document.getElementById('utilerias');
                break;
            case 9:
                a = document.getElementById('cuenta');
                break;
        }
        if(cont%2 !== 0){
            x.classList.toggle("change");
            a.style.display="block";
        }
        else{
            if(cont%2===0){
                x.classList.toggle("change");
                a.style.display="none";
            }
        }
        cont += 1;
}

function closeMenu(x) {
    x.classList.toggle("change");
    var wid = document.getElementById('menu');
    wid.style.display="none";
}

/***********************************************************Se llenan combobox's*****************************************************************************/

$( function() {
    var paises = [
        "Afganistán",
        "Albania",
        "Alemania",
        "Andorra",
        "Angola",
        "Antigua y Barbuda",
        "Arabia Saudita",
        "Argelia",
        "Argentina",
        "Armenia",
        "Australia",
        "Austria",
        "Azerbaiyán",
        "Bahamas",
        "Bangladés",
        "Barbados",
        "Baréin",
        "Bélgica",
        "Belice",
        "Benín",
        "Bielorrusia",
        "Birmania",
        "Bolivia",
        "Bosnia y Herzegovina",
        "Botsuana",
        "Brasil",
        "Brunéi",
        "Bulgaria",
        "Burkina Faso",
        "Burundi",
        "Bután",
        "Cabo Verde",
        "Camboya",
        "Camerún",
        "Canadá",
        "Catar",
        "Chad",
        "Chile",
        "China",
        "Chipre",
        "Ciudad del Vaticano",
        "Colombia",
        "Comoras",
        "Corea del Norte",
        "Corea del Sur",
        "Costa de Marfil",
        "Costa Rica",
        "Croacia",
        "Cuba",
        "Dinamarca",
        "Dominica",
        "Ecuador",
        "Egipto",
        "El Salvador",
        "Emiratos Árabes Unidos",
        "Eritrea",
        "Eslovaquia",
        "Eslovenia",
        "España",
        "Estados Unidos",
        "Estonia",
        "Etiopía",
        "Filipinas",
        "Finlandia",
        "Fiyi",
        "Francia",
        "Gabón",
        "Gambia",
        "Georgia",
        "Ghana",
        "Granada",
        "Grecia",
        "Guatemala",
        "Guyana",
        "Guinea",
        "Guinea ecuatorial",
        "Guinea-Bisáu",
        "Haití",
        "Honduras",
        "Hungría",
        "India",
        "Indonesia",
        "Irak",
        "Irán",
        "Irlanda",
        "Islandia",
        "Islas Marshall",
        "Islas Salomón",
        "Israel",
        "Italia",
        "Jamaica",
        "Japón",
        "Jordania",
        "Kazajistán",
        "Kenia",
        "Kirguistán",
        "Kiribati",
        "Kuwait",
        "Laos",
        "Lesoto",
        "Letonia",
        "Líbano",
        "Liberia",
        "Libia",
        "Liechtenstein",
        "Lituania",
        "Luxemburgo",
        "Macedonia del Norte",
        "Madagascar",
        "Malasia",
        "Malaui",
        "Maldivas",
        "Malí",
        "Malta",
        "Marruecos",
        "Mauricio",
        "Mauritania",
        "México",
        "Micronesia",
        "Moldavia",
        "Mónaco",
        "Mongolia",
        "Montenegro",
        "Mozambique",
        "Namibia",
        "Nauru",
        "Nepal",
        "Nicaragua",
        "Níger",
        "Nigeria",
        "Noruega",
        "Nueva Zelanda",
        "Omán",
        "Países Bajos",
        "Pakistán",
        "Palaos",
        "Panamá",
        "Papúa Nueva Guinea",
        "Paraguay",
        "Perú",
        "Polonia",
        "Portugal",
        "Reino Unido",
        "República Centroafricana",
        "República Checa",
        "República del Congo",
        "República Democrática del Congo",
        "República Dominicana",
        "República Sudafricana",
        "Ruanda",
        "Rumanía",
        "Rusia",
        "Samoa",
        "San Cristóbal y Nieves",
        "San Marino",
        "San Vicente y las Granadinas",
        "Santa Lucía",
        "Santo Tomé y Príncipe",
        "Senegal",
        "Serbia",
        "Seychelles",
        "Sierra Leona",
        "Singapur",
        "Siria",
        "Somalia",
        "Sri Lanka",
        "Suazilandia",
        "Sudán",
        "Sudán del Sur",
        "Suecia",
        "Suiza",
        "Surinam",
        "Tailandia",
        "Tanzania",
        "Tayikistán",
        "Timor Oriental",
        "Togo",
        "Tonga",
        "Trinidad y Tobago",
        "Túnez",
        "Turkmenistán",
        "Turquía",
        "Tuvalu",
        "Ucrania",
        "Uganda",
        "Uruguay",
        "Uzbekistán",
        "Vanuatu",
        "Venezuela",
        "Vietnam",
        "Yemen",
        "Yibuti",
        "Zambia",
        "Zimbabue",
    ];
    var estados = [
        "Aguascalientes",
        "Baja California Norte",
        "Baja California Sur",
        "Campeche",
        "Chiapas",
        "Chihuahua",
        "Coahuila",
        "Colima",
        "Distrito Federal",
        "Durango",
        "Estado de México",
        "Guanajuato",
        "Guerrero",
        "Hidalgo",
        "Jalisco",
        "Michoacán",
        "Morelos",
        "Nayarit",
        "Nuevo León",
        "Oaxaca",
        "Puebla",
        "Querétaro",
        "Quintana Roo",
        "San Luis Potosí",
        "Sinaloa",
        "Sonora",
        "Tabasco",
        "Tamaulipas",
        "Tlaxcala",
        "Veracruz",
        "Yucatán",
        "Zacatecas",
    ];
    var alcaldias = [
        "Álvaro Obregón",
        "Benito Juárez",
        "Coyoacán",
        "Cuajimalpa",
        "Cuauhtémoc",
        "Gustavo A. Madero",
        "Iztacalco",
        "Iztapalapa",
        "Magdalena Contreras",
        "Miguel Hidalgo",
        "Milpa Alta",
        "Tláhuac",
        "Tlalpan",
        "Venustiano Carranza",
        "Xochimilco",
    ];
    var tasaInteres = [
        'tasa 1',
        'tasa 2',
        'tasa 3',
        'tasa 4'
    ];
    var tipoInteres = [
      'tipo 1',
      'tipo 2',
      'tipo 3'
    ];

    $( "#inPaises" ).autocomplete({
        source: paises
    });
    $( "#inEstados" ).autocomplete({
        source: estados
    });

    $( "#inAlcaldia" ).autocomplete({
        source: alcaldias
    });
    $( "#inEstadoActual" ).autocomplete({
        source: estados
    });
    $( "#boxTasaInteres" ).autocomplete({
        source: tasaInteres
    });
    $( "#boxTipoInteres" ).autocomplete({
        source: tipoInteres
    });
} );

/************************************************Pagina Principal*************************************************/

$(function () {
    $('.contenidoInicio .contChild').hide();
    $('.home').show();
    $('.navInicio a').on('click', function () {

        $('.contenidoInicio .contChild:first').show();

        var link = $(this).attr('id');
        $(link).fadeIn(1000);
        switch (link) {
            case 'home':
                $('.contenidoInicio .contChild').hide();
                $('.contenidoInicio .contChild:nth-child(1)').show();
                break;
            case 'nosotros':
                $('.contenidoInicio .contChild').hide();
                $('.contenidoInicio .contChild:nth-child(2)').show();
                break;
            case 'comoEmpeño':
                $('.contenidoInicio .contChild').hide();
                $('.contenidoInicio .contChild:nth-child(3)').show();
                break;
            case 'contacto':
                $('.contenidoInicio .contChild').hide();
                $('.contenidoInicio .contChild:nth-child(4)').show();
                break;
            case 'login':
                $('.contenidoInicio .contChild').hide();
                $('.contenidoInicio .contChild:nth-child(5)').show();
                $('#htmlLogin').style.overflowY = "hidden";
                break;
        }
    })
})


/*****************************************************Canvas******************************************************************/

$(function () {
    const ALTURA_CANVAS = 500,
        ANCHURA_CANVAS = 1536;

// Obtener el elemento del DOM
    const canvas = document.querySelector("#canvas");
    canvas.width = ANCHURA_CANVAS;
    canvas.height = ALTURA_CANVAS;
// Del canvas, obtener el contexto para poder dibujar
    const contexto = canvas.getContext("2d");

// Mover a donde comienza la curva
    let inicioX = 1200, inicioY = -5;
    contexto.moveTo(inicioX, inicioY);
// Coordenadas del primer punto
    let puntoX1 = 1600,
        puntoY1 = 250;
// Coordenadas del segundo punto
    let puntoX2 = 1250,
        puntoY2 = 400;
// Coordenadas en donde termina la curva
    let x = 1540, y = 450;

    var my_gradient = contexto.createLinearGradient(0, 0, 170, 0);
    my_gradient.addColorStop(0, "#8942a8");
    my_gradient.addColorStop(1, "#ba382f");

    contexto.lineWidth = 20;
    contexto.bezierCurveTo(puntoX1, puntoY1, puntoX2, puntoY2, x, y);
    contexto.strokeStyle = my_gradient;
    contexto.stroke();
/**************************************************************************************************/
    // Obtener el elemento del DOM
    const canvas2 = document.querySelector("#canvas2");
    canvas2.width = ANCHURA_CANVAS;
    canvas2.height = ALTURA_CANVAS;
// Del canvas, obtener el contexto para poder dibujar
    const contexto2 = canvas2.getContext("2d");

// Mover a donde comienza la curva
    let inicioXX = 336, inicioYY = -5;
    contexto2.moveTo(inicioXX, inicioYY);
// Coordenadas del primer punto
    let puntoX11 = -64,
        puntoY11 = 250;
// Coordenadas del segundo punto
    let puntoX22 = 286,
        puntoY22 = 400;
// Coordenadas en donde termina la curva
    let xx = -4, yy = 450;

    var my_gradient2 = contexto2.createLinearGradient(0, 0, 170, 0);
    my_gradient2.addColorStop(0, "#8942a8");
    my_gradient2.addColorStop(1, "#ba382f");

    contexto2.lineWidth = 20;
    contexto2.bezierCurveTo(puntoX11, puntoY11, puntoX22, puntoY22, xx, yy);
    contexto2.strokeStyle = my_gradient2;
    contexto2.stroke();

});

function __ajax(url, data) {

    var ajax = $.ajax({
        "method": "POST",
        "url": url,
        "data": data
    })
    return ajax;

}

function datos() {
    var data = [];
    /*data.push(

       "nombre": $('#inNombre'),
        "apellido_Pat" :  $('#inApPat'),
        "apellido_Mat" :  $('#inApMat'),
        "sexo" :  $('#boxSexo'),
        "fecha_Nacimiento" :  $('#inFechaNac'),
        "curp" :  $('#inCurp'),
        "ocupacion" :  $('#boxOcupacion'),
        "tipo_Identificacion" :  $('#boxIdentificacion'),
        "num_Identificacion" :  $('#inNoIdentificacion'),
        "celular" :  $('#$inCelular'),
        "rfc" :  $('#$inRfc'),

        "telefono" : $('#$inTelefono'),
        "correo" : $('#$inCorreo'),
        "estado" : $('#$inEstadoActual'),
        "codigo_Postal" : $('#inNombre'),

        "municipio" : $('#inNombre'),
        "colonia" : $('#inNombre'),
        "calle" : $('#inNombre'),
        "num_exterior" : $('#inNombre'),
        "num_interior" : $('#inNombre'),

        "mensaje" :  $('#inNombre'),
        "promocion" : $('#inNombre')

    );*/
}

function guardar() {
    var json = JSON.stringify(datos());
}

function tablaClientes(x) {

    var valores = [];

    $(x).parents("tr").find("td").each(function(){
        valores.push($(this).html());
    });
    document.getElementById("Nombres").value = valores[0];
    document.getElementById("inDireccion").value = valores[7];
    document.getElementById('inCelular').value =valores[3];
    document.getElementById('inCiudad').value =valores[8];

    document.getElementById('tablaExtras').style.display="none";

}

function mostrarTablaExtras() {
    document.getElementById('tablaExtras').style.display="block";

    var txtNombre = document.getElementById('Nombres').value;

    var param = {
        "Nombres" : txtNombre
    };

    $.ajax({
        data: param,
        url: "../../../com.Mexicash/Controlador/cConsultas.php",
        type: "POST",
        success: function (response) {
            $("#tablaExtras").html(response);
        }
    });
}


function cerrarVentana() {
    window.close();
}

function buscarContrato() {
    var contrato = document.getElementById('inContrato').value;
    var nombre = 0;
    var celular = 0;

    var params = {
        "contrato": contrato,
        "nombre": nombre,
        "celular": celular
    };

    document.getElementById('Nombres').value = "";
    document.getElementById('inDireccion').value = "";
    document.getElementById('inCiudad').value = "";
    document.getElementById('inCelular').value = "";

    $.get("../../../com.Mexicash/Controlador/cConsultaContrato.php", params, function (response) {
        var json = JSON.parse(response);
        var tbl = ``;
        var tbl2 = ``;

        $('#tblArticulo tbody').remove();
        $('#tblContratos tbody').remove();


        for(var i = 0; i < json.length; i++){
            tbl += `<tbody>
            <tr>
            <td style="border: 1px solid black">`+ json[i]['id_Contrato'] + `</td>
            <td style="border: 1px solid black">`+ json[i]['folio'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['total_prestamo'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['abono'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['id_Interes'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['pago'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['fecha_alm'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['fecha_movimiento'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['id_Estatus'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['fecha_vencimiento'] +`</td>
            </tr></tbody>`;

            tbl2 += `<tr>
            <td style="border: 1px solid black">` + json[i]['cantidad'] +`</td>
            <td style="border: 1px solid black">`+json[i]['detalle']+`</td>
            <td style="border: 1px solid black">`+json[i]['observaciones']+`</td>
            </tr>`;
        }
        $('#tblArticulo').append(tbl2);
        $('#tblContratos').append(tbl);
    });


}

function buscarContratoPorNombre() {
    var nombre = document.getElementById('Nombres').value;
    var contrato = 0;
    var celular = document.getElementById('inCelular').value;
    var params = {
        "contrato": contrato,
        "nombre": nombre,
        "celular": celular
    };

    document.getElementById("inContrato").value = "";

    $.get("../../../com.Mexicash/Controlador/cConsultaContrato.php", params, function (response) {
        var json = JSON.parse(response);
        var tbl = ``;
        var tbl2 = ``;

        $('#tblArticulo tbody').remove();
        $('#tblContratos tbody').remove();

        for(var i = 0; i < json.length; i++){
            tbl += `<tbody><tr>
            <td style="border: 1px solid black">`+ json[i]['id_Contrato'] + `</td>
            <td style="border: 1px solid black">`+ json[i]['folio'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['total_prestamo'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['abono'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['id_Interes'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['pago'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['fecha_alm'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['fecha_movimiento'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['id_Estatus'] +`</td>
            <td style="border: 1px solid black">`+ json[i]['fecha_vencimiento'] +`</td>
            </tr>`;

            tbl2 += `<tr>
            <td style="border: 1px solid black">` + json[i]['cantidad'] +`</td>
            <td style="border: 1px solid black">`+json[i]['detalle']+`</td>
            <td style="border: 1px solid black">`+json[i]['observaciones']+`</td>
            </tr></tbody>`;
        }
        $('#tblArticulo').append(tbl2);
        $('#tblContratos').append(tbl);

    });
}

function ventanaInvFisico(opc) {
    switch (opc) {
        case 1:
            window.open("../../html/Reportes/vInventarioFisico.php" , "Inventario Fisico" , "width=500,height=210,scrollbars=NO");
            break;
        case 2:
            window.open("../../html/Reportes/vReporteAlmoneda.php" , "Inventario Fisico" , "width=500,height=210,scrollbars=NO");
            break;
    }

}

function validarFormatoFecha(campo) {
    var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
    if ((campo.match(RegExPattern)) && (campo!='')) {
        return true;
    } else {
        return false;
    }
}

function existeFecha(fecha){
    var fechaf = fecha.split("/");
    var day = fechaf[0];
    var month = fechaf[1];
    var year = fechaf[2];
    var date = new Date(year,month,'0');
    if((day-0)>(date.getDate()-0)){
        return false;
    }
    return true;
}

function fecha() {
    if(validarFormatoFecha(document.getElementById('inFechaIn').value) && existeFecha(document.getElementById('inFechaFi').value)){
        if(existeFecha(document.getElementById('inFechaIn').value) && existeFecha(document.getElementById('inFechaFi').value)){
            alert("La fecha introducida es correcta.");
            cerrarVentana();
        }else{
            alert("La fecha introducida no existe.");
        }
    }else{
        alert("El formato de la fecha es incorrecto.");
    }
}

function traerContratos() {
    var fechaIn = document.getElementById('inFechaInicial').value;
    var fechaFi = document.getElementById('inFechaFinal').value;
    var params = {
        "fechaInicial": fechaIn,
        "fechaFinal": fechaFi
    };

    $.get("cConsultaContratoVencido.php", params, function (response) {
        var json = JSON.parse(response);
        var tbl = ``;

        for (var i = 0; i < json.length; i++){
            tbl += `<tbody><tr>
                <td style="border: 1px solid black">`+ json[i]['id_Contrato'] + `</td>
                <td style="border: 1px solid black">`+ json[i]['fecha_creacion'] + `</td>
                <td style="border: 1px solid black">`+ json[i]['fecha_Vencimiento'] + `</td>
                <td style="border: 1px solid black">`+ json[i]['nombreCompleto'] + `</td>
                <td style="border: 1px solid black">`+ json[i]['celular'] + `</td>
                <td style="border: 1px solid black">`+ json[i]['telefono'] + `</td>
                <td style="border: 1px solid black">`+ json[i]['total_Avaluo'] + `</td>
                <td style="border: 1px solid black">`+ json[i]['total_Prestamo'] + `</td>
                <td style="border: 1px solid black">`+ 0 + `</td>
                <td style="border: 1px solid black">`+ json[i]['id_Interes'] + `</td>
            </tr></tbody>`;
        }

        $('#tblContratosVencidos').append(tbl);
        console.log(json);

    });
}


/*
function ambos() {
    var pdf = document.getElementById('PDF').checked;
    var e = document.getElementById('Excel').checked;
    if(pdf && e){
        alert('checkbox esta seleccionado');
    }else {
        $("#formInvFis").submit();
    }
}*/