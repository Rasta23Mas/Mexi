<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/css" src="../../JavaScript/funcionesGenerales.js"></script>
</head>
<body>
<div class="modal fade " id="modalEditarJoyeria" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Descuento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" align="center">
                    <table width="100%" >
                        <tr>
                            <td align="center">
                                <label>Modificación Joyeria</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <label>Motivo:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="Center">
                                <p><textarea name="mensaje" id="idMotivoJoy"
                                             class="textArea" rows="3" cols="25"></textarea></p>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <label>Prestamo:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <input type="text" id="idPrestamoCalculado" name="prestamo" size="8"
                                      disabled style="text-align:center"/>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <label>Nuevo Prestamo:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <input type="text" id="idPrestamoNuevo" name="prestamo" size="8"
                                       onkeypress="return decimales(event)";
                                       style="text-align:center"/>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                              <br>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <label>Código de Autorización:</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <input type="text" id="idCodigoJoy" name="codigoAut" size="20" value=""  style="text-align: center"/>
                            </td>
                        </tr>
                    </table>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-success "
                       onclick="tokenNuevoJoyeria();"  value="Verificar">
            </div>
        </div>
    </div>
</div>
</body>
</html>
