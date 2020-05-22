<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .letraNormalNegrita {
            font-size: .6em;
            font-weight: bold;
        }

        .letraGrandeNegrita {
            font-size: 1em;
            font-weight: bold;
        }

        .letraChicaNegrita {
            font-size: .4em;
            font-weight: bold;
        }

        .letraNormal {
            font-size: .6em;
        }

        .letraGrande {
            font-size: 1em;
        }

        .letraChica {
            font-size: .4em;
        }

        .tituloCelda {
            background-color: #ebebe0
        }
    </style>
</head>
<body>
<form>
    <table width="50%" border="1">
        <tbody>
        <tr>
            <td>
                <table width="=40%" border="0">
                    <tr>
                        <td colspan="3" align="center">
                            <label>MIRIAM GAMA VAZQUEZ</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label ID="sucursal">SUCURSAL: '. $NombreSucursal .'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label ID="sucursalDir">'. $DirSucursal .'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label ID="sucursalTel">Tel: '. $TelSucursal .'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label ID="sucursalRfc">RFC: GAVM800428KQ3</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label> ****************** </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>COMPROBANTE DE </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>REFRENDO</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label> ****************** </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label id="idContrato">BOLETA NO: '. $idContrato.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label id="id_Recibo">RECIBO NO: '. $id_Recibo.'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label id="idFechaHoy">FECHA: '. $Fecha_Creacion.'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label id="idCliente">CLIENTE: '. $NombreCompleto.'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>PRESTAMO:</label></td>
                        <td align="right"><label>$ '.$prestamo.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>ABONO A CAPITAL:</label></td>
                        <td align="right"><label>$ '.$abonoCapital.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>INTERESES:</label></td>
                        <td align="right"><label>$ '.$intereses.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>ALMACENAJE:</label></td>
                        <td align="right"><label>$ '.$almacenaje.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>SEGURO:</label></td>
                        <td align="right"><label>$ '.$seguro.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>DESEMPEÑO EXT.:</label></td>
                        <td align="right"><label>$ '.$desempeñoExt.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>MORATORIOS:</label></td>
                        <td align="right"><label>$ '.$moratorios.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>OTROS COBROS:</label></td>
                        <td align="right"><label>$ '.$otrosCobros.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label></label></td>
                        <td align="right"><label>-------------</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>SUBTOTAL:</label></td>
                        <td align="right"><label>$ '.$subTotal.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>DESC. APLICADO:</label></td>
                        <td align="right"><label>$ '.$descuentoAplicado.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>IVA:</label></td>
                        <td align="right"><label>$ '.$iva.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label></label></td>
                        <td align="right"><label>-------------</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>TOTAL:</label></td>
                        <td align="right"><label>$ '.$Total.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>EFECTIVO:</label></td>
                        <td align="right"><label>$ '.$efectivo.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>CAMBIO:</label></td>
                        <td align="right"><label>$ '.$cambio.'</label></td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left"><label>COMERCIALIZACION :'.$Fecha_Almoneda.'</label></td>
                    </tr>
                    <tr>
                        <td><label>N. MUTUO</label></td>
                        <td><label>REFRENDO</label></td>
                        <td><label>VENCIMIENTO</label></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">____________________________________</td>
                    </tr>
                    <tr>
                        <td><label>?????</label></td>
                        <td><label>?????</label></td>
                        <td><label id="idFechaVencimiento">'.$Fecha_Vencimiento.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left"><label id="idDetalle">'.$detallePiePagina.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="3"><label id="idUsuario">Usuario: '.$NombreUsuario.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>___________________________</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>Cliente</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>___________________________</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>Usuario</label>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table width="=40%" border="0">
                    <tr>
                        <td colspan="3" align="center">
                            <label>MIRIAM GAMA VAZQUEZ</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label ID="sucursal">SUCURSAL: '. $NombreSucursal .'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label ID="sucursalDir">'. $DirSucursal .'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label ID="sucursalTel">Tel: '. $TelSucursal .'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label ID="sucursalRfc">RFC: GAVM800428KQ3</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label> ****************** </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>COMPROBANTE DE </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>REFRENDO</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label> ****************** </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label id="idContrato">BOLETA NO: '. $idContrato.' </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label id="id_Recibo">RECIBO NO: '. $id_Recibo.'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label id="idFechaHoy">FECHA: '. $Fecha_Creacion.'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label id="idCliente">CLIENTE: '. $NombreCompleto.'</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>PRESTAMO:</label></td>
                        <td align="right"><label>$ '.$prestamo.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>ABONO A CAPITAL:</label></td>
                        <td align="right"><label>$ '.$abonoCapital.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>INTERESES:</label></td>
                        <td align="right"><label>$ '.$intereses.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>ALMACENAJE:</label></td>
                        <td align="right"><label>$ '.$almacenaje.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>SEGURO:</label></td>
                        <td align="right"><label>$ '.$seguro.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>DESEMPEÑO EXT.:</label></td>
                        <td align="right"><label>$ '.$desempeñoExt.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>MORATORIOS:</label></td>
                        <td align="right"><label>$ '.$moratorios.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>OTROS COBROS:</label></td>
                        <td align="right"><label>$ '.$otrosCobros.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label></label></td>
                        <td align="right"><label>-------------</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>SUBTOTAL:</label></td>
                        <td align="right"><label>$ '.$subTotal.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>DESC. APLICADO:</label></td>
                        <td align="right"><label>$ '.$descuentoAplicado.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>IVA:</label></td>
                        <td align="right"><label>$ '.$iva.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label></label></td>
                        <td align="right"><label>-------------</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>TOTAL:</label></td>
                        <td align="right"><label>$ '.$Total.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>EFECTIVO:</label></td>
                        <td align="right"><label>$ '.$efectivo.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><label>CAMBIO:</label></td>
                        <td align="right"><label>$ '.$cambio.'</label></td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left"><label>COMERCIALIZACION :'.$Fecha_Almoneda.'</label></td>
                    </tr>
                    <tr>
                        <td><label>N. MUTUO</label></td>
                        <td><label>REFRENDO</label></td>
                        <td><label>VENCIMIENTO</label></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">____________________________________</td>
                    </tr>
                    <tr>
                        <td><label>?????</label></td>
                        <td><label>?????</label></td>
                        <td><label id="idFechaVencimiento">'.$Fecha_Vencimiento.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left"><label id="idDetalle">'.$detallePiePagina.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="3"><label id="idUsuario">Usuario: '.$NombreUsuario.'</label></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>___________________________</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>Cliente</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>___________________________</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <label>Usuario</label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</form>
</body>
</html>';