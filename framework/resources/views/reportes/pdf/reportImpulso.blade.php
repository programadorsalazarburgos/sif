<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reporte Monitoreo</title>
    <style>
        table,
        td {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

        td {
            font-size: 12px;
        }

        th {
            font-size: 12px;
        }

        caption {
            font-size: 12px;
        }

        .pie-chart {
            width: 50%;
        }
    </style>
</head>

<body>

    <table class="table_text">
        <caption>REPORTE MES {{$nombreMes}} DE {{$nombreAnio}} CREA</caption>
        <tbody>
            <tr>
                <td colspan="11" style="font-size:12px;">
                    <center>
                        <b>{{$nombrePrograma}}</b>
                    </center>
                </td>
            </tr>
            <tr>
                <td>TOTAL</td>
                @foreach ($areas as $data)
                <td>{{$data->AREA}}</td>

                @endforeach
                <td>CREADOS EN EL MES</td>
                <td>CERRADOS EN EL MES</td>
                <td>COBERTURA TOTAL</td>
            </tr>
            <tr>
                <td>{{$totalImpulso}}</td>
                @foreach ($areas as $data)
                <td>
                <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td style="text-align: center;" width="50%"> MO</td>
                                <td style="text-align: center;" width="50%"> SE</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"> {{$data->MO}}</td>
                                <td style="text-align: center;"> {{$data->SE}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            @endforeach
            <td style="text-align:center;">{{$totalCreadosMesImpulso}}</td>
            <td style="text-align:center;">{{$totalCerradosMesImpulso}}</td>
            <td style="text-align:center;">{{$coberturaTotalImpulso}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table border="1" style=???width: 100%???>
        <colgroup>
            <col style="width: 20%" />
            <col style="width: 40%" />
            <col style="width: 40%" />
        </colgroup>
        <thead>
            <tr>
                <th rowspan="2"></th>
                <th colspan="13">HIST??RICO DE COBERTURA/ASITENCIA</th>
            </tr>
            <tr>
                @foreach ($meses as $data)
                <th>{{$data['nombre']}}</th>
                @endforeach
                <th>ACUMULADO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>ATENDIDOS</th>
                @foreach ($meses as $data)
                <td style="text-align:center;">{{$data['atendidos']}}</td>
                @endforeach
                <td style="text-align:center;">{{$acumuladoBeneficiariosAtendidosAnio}}</td>
            </tr>
            <tr>
                <th>INSCRITOS</th>
                @foreach ($meses as $data)
                <td style="text-align:center;">{{$data['inscritos']}}</td>
                @endforeach
                <td style="text-align:center;">{{$acumuladoBeneficiariosInscritosAnio}}</td>
            </tr>
            <tr>
                <th>PORCENTAJE</th>
                @foreach ($meses as $data)
                <td style="text-align:center;">{{$data['porcentaje']}}%</td>
                @endforeach
                <td style="text-align:center;">{{$porcentajeAcumuladoBeneficiarios}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table border="1" style=???width: 100%???>
        <colgroup>
            <col style="width: 20%" />
            <col style="width: 40%" />
            <col style="width: 40%" />
        </colgroup>
        <thead>
            <tr>
                <th rowspan="2">??REA</th>
                <th colspan="4">POR ??REA</th>
            </tr>
            <tr>
                <th>ATENDIDOS</th>
                <th>REGISTRADOS</th>
                <th>PORCENTAJE</th>
                <th>NIVEL DE ATENCI??N</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($porAreas as $data)
            <tr>
                <th>{{$data->VC_Descripcion}}</th>
                <td style="text-align:center;">{{$data->atendidos}}</td>
                <td style="text-align:center;">{{$data->registrados}}</td>
                <td style="text-align:center;">{{$data->porcentaje}}%</td>
                <td style="text-align:center;">{{$data->nivel_atencion}}</td>
            </tr>
            @endforeach
            <tr>
                <th>TOTAL</th>
                <td style="text-align:center;">{{$sumaAtendidos}}</td>
                <td style="text-align:center;">{{$sumaRegistrados}}</td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
            </tr>
        </tbody>
    </table>
    <div class="clearfix"></div><br>
    <div class="clearfix"></div><br>
    <div class="clearfix"></div><br>
    <div class="pie-chart">
        <img src="{{$bar}}" style="width:60%" />
        <img src="{{$pie}}" style="width:60%">
    </div>

    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <table border="1" style=???width: 100%???>
    <caption>OBSERVACIONES ANALISIS REPORTE</caption>
        <colgroup>
            <col style="width: 20%" />
            <col style="width: 40%" />
            <col style="width: 40%" />
        </colgroup>
        <thead>
            <tr>
                <th>FECHA ANALISIS</th>
                <th>ANALISIS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($observacionesAll as $data)
            <tr>
                <th>{{$data->created_at}}</th>
                <td style="text-align:center;">{{$data->tx_observacion}}</td>
              
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>