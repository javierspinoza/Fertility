<!DOCTYPE html>
<html>

<head>
    <title>Trabajos Fertility</title>
    <meta charset="utf-8">
    <style>
        /* Estilos CSS para el PDF */
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 32px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #333;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }

        .table td,
        .table th {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: justify;
        }

        .table th {
            padding-top: 16px;
            padding-bottom: 16px;
            text-align: left;
            background-color: #1a73e8;
            color: white;
            font-size: 18px;
        }

        .table td:first-child,
        .table th:first-child {
            text-align: left;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tr:hover {
            background-color: #ddd;
        }

        .table .name {
            font-weight: bold;
            color: #1a73e8;
        }

        .table .phone,
        .table .address {
            font-style: italic;
        }

        .table .cooking_recipe {
            text-transform: capitalize;
        }

        .icon {
            display: inline-block;
            margin-right: 10px;
            font-size: 24px;
            color: #1a73e8;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 0;
        }

        .info .title {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #333;
            margin-bottom: 10px;
        }

        /* .watermark {
            position: fixed;
            top: 45%;
            left: 30%;
            transform: rotate(-360deg);
            opacity: 0.2;
            font-size: 7em;
            color: #CCCCCC;
            z-index: -1000;
            width: 100%;
            text-align: center;
        } */
        .watermark {
            font-size: 22px;
            opacity: 0.3;
            position: fixed;
            bottom: 2px;
            left: 20px;
            transform: rotate(-360deg);
            transform-origin: center;
            color: gray;
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="watermark">© Desarrollado por Javier Spinoza</div>
    <div class="logo">
        <img src="https://www.solucionesisavitalsas.com/imgLogosEmpresa/fertility_logo.png" alt="Logo Fertility"
            style="width: 90px; float: left;">
        <img src="https://www.solucionesisavitalsas.com/imgLogosEmpresa/fertility_logo.png" alt="Logo Fertility"
            style="width: 100px; float: right;">
        <h1 style="text-align: center;">Trabajos Agendados</h1>
    </div>

    <br>

    <div class="info">
        <p><i class="icon fas fa-info-circle"></i> Aquí encontrarás una lista de los trabajos agendados.</p>
        <p><i class="icon fas fa-clock"></i> La fecha y hora del trabajo están indicadas en la tabla.</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>N° Trabajo</th>
                <th>Finca</th>
                <th>Fecha Trabajo</th>
                <th>Valor Total</th>
                <th>Estado</th>
                <th>Notas</th>
            </tr>
        </thead>
        @if (count($works) > 0)
            <tbody>
                @foreach ($works as $work)
                    <tr>
                        <td>{{ $work->work_number }}</td>
                        <td>{{ $work->farms->name }}</td>
                        <td style="width: 100px">{{ date('Y-m-d h:i:s A', strtotime($work->date_work)) }}</td>
                        <td>$ {{ $work->price_overall }}</td>
                        <td>{{ $work->status }}</td>
                        <td>{{ $work->fast_notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        @else
            <td colspan="9">
                <p style="text-align: center;">No hay trabajos agendados para día de hoy.</p>
            </td>
        @endif
    </table>
</body>

</html>
