<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Compra</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /*
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
            background: #fff;
        }
        */
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            font-weight: 600;
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
            font-size: 16px;
            font-weight: bold;
        }

        .section {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
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

        .monto-compra {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            padding: 10px 0;
            background: #fff;
            border: 1px solid #000;
            margin: 8px 0;
            color: #000;
        }

        .puntos-generados {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            padding: 12px 0;
            border: 2px solid #000;
            background: #fff;
            margin: 10px 0;
            color: #000;
        }

        .campania-info {
            background: #fff;
            border: 1px solid #000;
            border-radius: 5px;
            padding: 8px;
            margin: 10px 0;
            font-size: 11px;
            color: #000;
        }

        .campania-info .titulo {
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .campania-info .regla {
            color: #000;
            margin-bottom: 3px;
        }

        .desglose {
            background: #fff;
            border: 1px solid #000;
            border-radius: 5px;
            padding: 8px;
            margin: 10px 0;
            font-size: 11px;
            color: #000;
        }

        .desglose .titulo {
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .desglose .item {
            margin-bottom: 5px;
            padding-left: 10px;
            color: #000;
        }

        .desglose .item::before {
            content: ">";
            margin-right: 5px;
            color: #000;
        }

        .potenciador {
            background: #fff;
            border: 1px solid #000;
            border-radius: 5px;
            padding: 8px;
            margin: 8px 0;
            font-size: 11px;
            color: #000;
        }

        .potenciador .titulo {
            font-weight: bold;
            color: #000;
            margin-bottom: 3px;
        }

        .potenciador .detalle {
            color: #000;
        }

        .puntos-acumulados {
            background: #fff;
            border: 2px solid #000;
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
            text-align: center;
            color: #000;
        }

        .puntos-acumulados .label {
            font-size: 10px;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .puntos-acumulados .valor {
            font-size: 20px;
            font-weight: bold;
            color: #000;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            color: #000;
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
            background: #000;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-print:hover {
            background: #333;
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
            <h2>COMPROBANTE DE COMPRA</h2>
            <p>N° <?= str_pad($id, 8, '0', STR_PAD_LEFT) ?></p>
        </div>

        <div class="section">
            <div class="row">
                <span class="label">Fecha:</span>
                <span class="value"><?= date('d/m/Y H:i', strtotime($created_at)) ?></span>
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

        <div class="monto-compra">
            MONTO: S/ <?= number_format($monto_compra, 2) ?>
        </div>

        <?php if (!empty($campania_nombre)): ?>
        <div class="campania-info">
            <div class="titulo">Campaña: <?= esc($campania_nombre) ?></div>
            <?php if (!empty($desglose['regla_base'])): ?>
            <div class="regla"><?= $desglose['regla_base'] ?></div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($desglose) && $desglose['puntos_base'] > 0): ?>
        <div class="desglose">
            <div class="titulo">Calculo de puntos:</div>
            <div class="item">
                Puntos base: <?= number_format($desglose['puntos_base']) ?> pts
            </div>
            <?php if (empty($desglose['potenciadores'])): ?>
            <div class="item">
                Sin potenciadores aplicados
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($desglose['potenciadores'])): ?>
        <?php foreach ($desglose['potenciadores'] as $pot): ?>
        <div class="potenciador">
            <div class="titulo"><?= esc($pot['nombre']) ?></div>
            <div class="detalle">
                <?= number_format($pot['puntos_antes']) ?> pts x <?= $pot['multiplicador'] ?> = <?= number_format($pot['puntos_despues']) ?> pts
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <div class="puntos-generados">
            + <?= number_format($puntos_generados) ?> PUNTOS
        </div>

        <div class="puntos-acumulados">
            <div class="label">Sus puntos disponibles</div>
            <div class="valor">
                <?= number_format($puntos_acumulados) ?> PUNTOS
            </div>
        </div>

        <?php if (!empty($observacion_texto)): ?>
        <div style="border: 1px solid #000; border-radius: 5px; padding: 8px; margin: 10px 0; font-size: 11px; color: #000;">
            <strong>Observación:</strong><br>
            <?= esc($observacion_texto) ?>
        </div>
        <?php endif; ?>

        <div class="footer">
            <p>Este documento es un comprobante</p>
            <p>de acumulacion de puntos</p>
            <p>------------------------------</p>
            <p>Gracias por su compra!</p>
            <p><?= date('Y') ?> - PHARMALIVET</p>
        </div>
    </div>

    <button class="btn-print no-print" onclick="window.print()">
        Imprimir Comprobante
    </button>
</body>
</html>