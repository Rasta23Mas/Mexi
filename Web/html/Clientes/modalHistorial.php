<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial Cliente</title>
</head>
<body>
<div class="modal fade " id="modalHistorial" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Historial del cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <table class="table table-hover table-condensed table-bordered" width="100%">
                        <thead>
                        <tr>
                            <th>Contrato</th>
                            <th>Nombre Completo</th>
                            <th>Tasa Interes</th>
                            <th>Fecha Vencimiento</th>
                            <th>Fecha Creación</th>
                            <th>Observaciones</th>
                            <th>Tipo</th>
                            <th>Estatus</th>
                            <th>Detalle</th>
                        </tr>
                        </thead>
                        <tbody id="idTBodyHistorial">
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table table-hover table-condensed table-bordered" width="100%">
                        <tr>
                            <th>Empeños Activos</th>
                            <th>Desempeños</th>
                            <th>Refrendos</th>
                            <th>Almoneda</th>
                        </tr>
                        <tbody id="idTBodyHistorialCount">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-warning w-23" data-dismiss="modal"
                       value="Salir">
            </div>
        </div>
    </div>
</div>
</body>
</html>
