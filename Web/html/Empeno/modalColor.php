<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo Articulo</title>
    <script type="text/css" src="../../JavaScript/funcionesGenerales.js"></script>
</head>
<body>
<div class="modal fade " id="modalColor" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Color</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">
                    <table width="100%" >
                        <tr>
                            <td>
                                <label>Color:</label>
                            </td>
                            <td>
                                <input type="text" id="idColorAgregar" name="colorAgregar" size="20" value=""/>
                            </td>
                        </tr>
                    </table>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success " data-dismiss="modal"
                       onclick="agregarColor();"  value="Agregar Tipo">
            </div>
        </div>
    </div>
</div>
</body>
</html>