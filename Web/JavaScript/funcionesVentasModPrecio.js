var paginadorGlb;
var totalPaginasGlb;
var itemsPorPaginaGlb = 20;
var numerosPorPaginaGlb = 4;
var idCodigoMostradorGlb = 0;


var errorToken = 0;
//VENTA 6


var precioAnteriorGlb = 0;
var precioModGlb = 0;
var idArticuloGlb = 0;
var idTokenGLb = 0;


function busquedaCodigoMostradorModP(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) {
        return true;
    }
    var patron;
    patron = /[0-9.]/
    var te;
    te = String.fromCharCode(tecla);
    if (e.keyCode == 13 && !e.shiftKey) {
        fnLlenaReportMostradorModP();
    }
}

//LLenar Reportes
function fnLlenaReportMostradorModP() {
    var idCodigo = $("#idCodigoMostrador").val();
    idCodigoMostradorGlb = idCodigo;
    var dataEnviar = {
        "idCodigo": idCodigoMostradorGlb,
        "tipo": 1,
        "limit": 0,
        "offset": 0,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaCodigo.php',
        data: dataEnviar,
        dataType: "json"
    }).done(function (data, textStatus, jqXHR) {
        var total = data.totalCount;
        if(total==0){
            alert("Sin resultados en la busqueda.")
        }else{
            fnCreaPaginador(total);
        }
    }).fail(function (jqXHR, textStatus, textError) {
        alert("Error al realizar la peticion cuantos".textError);

    });
}


function fnCreaPaginador(totalItems) {
    $("#paginador").html("");
    paginadorGlb = $(".pagination");
    totalPaginasGlb = Math.ceil(totalItems/itemsPorPaginaGlb);

    $('<li><a href="#" class="first_link"><</a></li>').appendTo(paginadorGlb);
    $('<li><a href="#" class="prev_link">«</a></li>').appendTo(paginadorGlb);

    var pag = 0;
    while(totalPaginasGlb > pag)
    {
        $('<li><a href="#" class="page_link">'+(pag+1)+'</a></li>').appendTo(paginadorGlb);
        pag++;
    }

    if(numerosPorPaginaGlb > 1)
    {
        $(".page_link").hide();
        $(".page_link").slice(0,numerosPorPaginaGlb).show();
    }

    $('<li><a href="#" class="next_link">»</a></li>').appendTo(paginadorGlb);
    $('<li><a href="#" class="last_link">></a></li>').appendTo(paginadorGlb);

    paginadorGlb.find(".page_link:first").addClass("active");
    paginadorGlb.find(".page_link:first").parents("li").addClass("active");

    paginadorGlb.find(".prev_link").hide();

    paginadorGlb.find("li .page_link").click(function()
    {
        var irpagina =$(this).html().valueOf()-1;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .first_link").click(function()
    {
        var irpagina =0;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .prev_link").click(function()
    {
        var irpagina =parseInt(paginadorGlb.data("pag")) -1;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .next_link").click(function()
    {
        var irpagina =parseInt(paginadorGlb.data("pag")) +1;
        fnCargaPagina(irpagina);
        return false;
    });

    paginadorGlb.find("li .last_link").click(function()
    {
        var irpagina =totalPaginasGlb -1;
        fnCargaPagina(irpagina);
        return false;
    });

    fnCargaPagina(0);

}

function fnCargaPagina(pagina){
    var desde = pagina * itemsPorPaginaGlb;
    var idCodigo = $("#idCodigoMostrador").val();
    var dataEnviar = {
        "idCodigo": idCodigo,
        "tipo": 2,
        "limit": itemsPorPaginaGlb,
        "offset": desde,
    };
    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Ventas/busquedaCodigo.php',
        data: dataEnviar,
        dataType: "json"
    }).done(function (data, textStatus, jqXHR) {
        var lista = data.lista;
        $("#idTBodyMetalesModPre").html("");
        $.each(lista, function(ind, elem){
            var prestamoCon = elem.prestamo;
            var avaluoCon = elem.avaluo;
            var vitrinaVentaCon = elem.vitrinaVenta;

            var id_ArticuloBazar = elem.id_ArticuloBazar;
            var empeno = prestamoCon;
            var precio_Actual =vitrinaVentaCon;
            prestamoCon = formatoMoneda(prestamoCon);
            avaluoCon = formatoMoneda(avaluoCon);
            vitrinaVentaCon = formatoMoneda(vitrinaVentaCon);
            var desc = elem.descripcionCorta;
            var obs = elem.observaciones;
            var descripcion = desc + " " + obs;


            $("<tr>"+
                "<td>"+elem.id_Contrato+"</td>"+
                "<td>"+id_ArticuloBazar+"</td>"+
                "<td>"+elem.id_serie+"</td>"+
                "<td>"+elem.Adquisicion+"</td>"+
                "<td align='right'>"+prestamoCon+"</td>"+
                "<td align='right'>"+avaluoCon+"</td>"+
                "<td align='right'>"+vitrinaVentaCon+"</td>"+
                "<td>"+descripcion+"</td>"+
                '<td align="center">' +
                '<img src="../../style/Img/editarNor.jpg" alt="Seleccionar" ' +
                ' onclick="fnModalPrecioNew(' + id_ArticuloBazar + ',' + precio_Actual + ')">' +
                '</td>'+
                "</tr>").appendTo($("#idTBodyMetalesModPre"));
        });

    }).fail(function (jqXHR, textStatus, textError) {
        alert("Error al realizar la peticion cuantos".textError);
    });

    if(pagina >= 1)
    {
        paginadorGlb.find(".prev_link").show();

    }
    else
    {
        paginadorGlb.find(".prev_link").hide();
    }


    if(pagina <(totalPaginasGlb- numerosPorPaginaGlb))
    {
        paginadorGlb.find(".next_link").show();
    }else
    {
        paginadorGlb.find(".next_link").hide();
    }

    paginadorGlb.data("pag",pagina);

    if(numerosPorPaginaGlb>1)
    {
        $(".page_link").hide();
        if(pagina < (totalPaginasGlb- numerosPorPaginaGlb))
        {
            $(".page_link").slice(pagina,numerosPorPaginaGlb + pagina).show();
        }
        else{
            if(totalPaginasGlb > numerosPorPaginaGlb)
                $(".page_link").slice(totalPaginasGlb- numerosPorPaginaGlb).show();
            else
                $(".page_link").slice(0).show();

        }
    }

    paginadorGlb.children().removeClass("active");
    paginadorGlb.children().eq(pagina+2).addClass("active");


}

function fnModalPrecioNew(id_ArticuloBazar, precio_Actual) {
    precioAnteriorGlb = precio_Actual;
    precio_Actual = formatoMoneda(precio_Actual);
    $("#idPrecioActualNew").val(precio_Actual);
    $("#idPrecioModNew").val('');
    $("#idArticuloNew").val(id_ArticuloBazar);
    $("#idPrecioModNew").prop('disabled', false);
    $("#idCodigoAutModNew").prop('disabled', false);
    $("#EditarPre").prop('disabled', false);

}

function editarPrecioNew() {
    var idPrecioMod = $("#idPrecioModNew").val();
    var idArticulo = $("#idArticuloNew").val();
    var idCodigoAutMod = $("#idCodigoAutModNew").val();

     precioModGlb = idPrecioMod;
     idArticuloGlb = idArticulo;
     idTokenGLb = idCodigoAutMod;
    var dataEnviar = {
        "idPrecioMod": idPrecioMod,
        "idArticulo": idArticulo,
        "idCodigoAutMod": idCodigoAutMod,
    };
    $.ajax({
        data: dataEnviar,
        url: '../../../com.Mexicash/Controlador/Ventas/TokenVentaModPrecio.php',
        type: 'post',
        success: function (respuesta) {
            if (respuesta != 0) {
                alert("Se modifico correctamente el precio.");
                fnBitPrecioMod();
            } else {
                alertify.error("Error al modificar el precio de venta.");
            }
        },
    })

}


function fnBitPrecioMod() {
    var dataEnviar = {
        "precioAnteriorGlb": precioAnteriorGlb,
        "precioModGlb": precioModGlb,
        "idArticuloGlb": idArticuloGlb,
        "idTokenGLb": idTokenGLb,
    };

    $.ajax({
        type: "POST",
        url: '../../../com.Mexicash/Controlador/Bitacora/ConBitPrecioMod.php',
        data: dataEnviar,
        success: function (response) {
            if (response > 0) {
                fnLlenaReportMostradorModP();
                $("#idPrecioActualNew").val('');
                $("#idPrecioModNew").val('');
                $("#idArticuloNew").val('');
                $("#idCodigoAutModNew").val('');
                $("#idPrecioModNew").prop('disabled', true);
                $("#idCodigoAutModNew").prop('disabled', true);
                $("#EditarPre").prop('disabled', true);
            } else {
                alertify.error("Error en al conectar con el servidor.FnError04")
            }
        }
    });
}