<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Puntos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
            background: #fff;
        }

        .ticket {
            border: 1px dashed #000;
            padding: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 14px;
            font-weight: normal;
        }

        .section {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ccc;
        }

        .section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .label {
            font-weight: bold;
        }

        .value {
            text-align: right;
        }

        .puntos-disponibles {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border: 2px solid #4caf50;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
        }

        .puntos-disponibles .label-pts {
            font-size: 10px;
            color: #2e7d32;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .puntos-disponibles .valor {
            font-size: 28px;
            font-weight: bold;
            color: #1b5e20;
        }

        .puntos-disponibles .icono {
            font-size: 20px;
            margin-right: 5px;
        }

        .mensaje-info {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
            font-size: 11px;
            text-align: center;
            color: #1565c0;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #000;
        }

        .footer p {
            margin-bottom: 3px;
        }

        @media print {
            body {
                width: 80mm;
            }
            .no-print {
                display: none;
            }
        }

        .btn-print {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-print:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>PHARMALIVET</h1>
            <div class="img-logo" style="display:flex;justify-content:center; margin: 10px;">
                <img src="<?= base_url('assets/img/pharmalivet.png') ?>" alt="Logo" style="width: 10%; height: 10%;">
            </div>
            <h2>CONSULTA DE PUNTOS</h2>
        </div>

        <div class="section">
            <div class="row">
                <span class="label">Fecha:</span>
                <span class="value"><?= date('d/m/Y H:i', strtotime($fecha_consulta)) ?></span>
            </div>
        </div>

        <div class="section">
            <div class="row">
                <span class="label">Cliente:</span>
                <span class="value"><?= esc($nombres . ' ' . $apellidos) ?></span>
            </div>
            <div class="row">
                <span class="label">DNI:</span>
                <span class="value"><?= esc($numero_documento) ?></span>
            </div>
        </div>

        <div class="puntos-disponibles">
            <div class="label-pts">Sus puntos disponibles</div>
            <div class="valor">
                <span class="icono">*</span><?= number_format($puntos_acumulados) ?> PUNTOS
            </div>
        </div>

        <div class="mensaje-info">
            Acumule puntos con cada compra y
            canjee por increibles premios!
        </div>

        <div class="footer">
            <p>Este documento es informativo</p>
            <p>------------------------------</p>
            <p>Gracias por su preferencia!</p>
            <p><?= date('Y') ?> - PHARMALIVET</p>
        </div>
    </div>

    <button class="btn-print no-print" onclick="window.print()">
        Imprimir Comprobante
    </button>
</body>
</html>
