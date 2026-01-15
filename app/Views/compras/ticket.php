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

        .monto-compra {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            padding: 10px 0;
            background: #f0f0f0;
            margin: 8px 0;
        }

        .puntos-generados {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            padding: 12px 0;
            border: 2px solid #28a745;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            margin: 10px 0;
            color: #1b5e20;
        }

        .campania-info {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            border-radius: 5px;
            padding: 8px;
            margin: 10px 0;
            font-size: 11px;
        }

        .campania-info .titulo {
            font-weight: bold;
            color: #1565c0;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .campania-info .regla {
            color: #1976d2;
            margin-bottom: 3px;
        }

        .desglose {
            background: #fff8e1;
            border: 1px solid #ffcc80;
            border-radius: 5px;
            padding: 8px;
            margin: 10px 0;
            font-size: 11px;
        }

        .desglose .titulo {
            font-weight: bold;
            color: #e65100;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .desglose .item {
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .desglose .item::before {
            content: ">";
            margin-right: 5px;
            color: #ff9800;
        }

        .potenciador {
            background: #fce4ec;
            border: 1px solid #f48fb1;
            border-radius: 5px;
            padding: 8px;
            margin: 8px 0;
            font-size: 11px;
        }

        .potenciador .titulo {
            font-weight: bold;
            color: #c2185b;
            margin-bottom: 3px;
        }

        .potenciador .detalle {
            color: #ad1457;
        }

        .puntos-acumulados {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border: 2px solid #4caf50;
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
            text-align: center;
        }

        .puntos-acumulados .label {
            font-size: 10px;
            color: #2e7d32;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .puntos-acumulados .valor {
            font-size: 20px;
            font-weight: bold;
            color: #1b5e20;
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
            <div class="titulo">Campana: <?= esc($campania_nombre) ?></div>
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
