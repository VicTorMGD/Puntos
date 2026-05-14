<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Canje #<?= $canje['id'] ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        .puntos-canjeados {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding: 15px 0;
            border: 2px solid #000;
            margin: 10px 0;
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
            background: #000;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-print:hover {
            background: #333;
        }

        .observacion {
            background: #fff;
            border: 1px solid #000;
            padding: 8px;
            margin-top: 10px;
            font-style: italic;
            font-size: 11px;
        }

        .puntos-restantes {
            background: #fff;
            border: 2px solid #000;
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
            text-align: center;
            color: #000;
        }

        .puntos-restantes .label {
            font-size: 10px;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .puntos-restantes .valor {
            font-size: 20px;
            font-weight: bold;
            color: #000;
        }

        .puntos-restantes .icono {
            font-size: 16px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>PHARMALIVET</h1>
                <div class="img-logo mt-2" style="display:flex;justify-content:center; margin: 10px;">
                    <img src="<?= base_url('assets/img/pharmalivet.png') ?>" alt="Logo" style="width: 10%; height: 10%; ">
                </div>
            <h2>COMPROBANTE DE CANJE</h2>
            <p>N° <?= str_pad($canje['id'], 8, '0', STR_PAD_LEFT) ?></p>
        </div>

        <div class="section">
            <div class="row">
                <span class="label">Fecha:</span>
                <span class="value"><?= date('d/m/Y H:i', strtotime($canje['created_at'])) ?></span>
            </div>
            <div class="row">
                <span class="label">Atendido por:</span>
                <span class="value"><?= esc($canje['usuario_nombre']) ?></span>
            </div>
        </div>

        <div class="section">
            <div class="row">
                <span class="label">Cliente:</span>
                <span class="value"><?= esc($canje['cliente_nombres'] . ' ' . $canje['cliente_apellidos']) ?></span>
            </div>
            <div class="row">
                <span class="label">DNI:</span>
                <span class="value"><?= esc($canje['cliente_documento']) ?></span>
            </div>
        </div>

        <div class="section">
            <div class="row">
                <span class="label">Campaña:</span>
                <span class="value"><?= esc($canje['campania_nombre']) ?></span>
            </div>
        </div>

        <div class="puntos-canjeados">
            <?= number_format($canje['puntos_canjeados']) ?> PUNTOS
        </div>

        <?php if (!empty($canje['observacion'])): ?>
        <div class="observacion">
            <strong>Observación:</strong><br>
            <?= esc($canje['observacion']) ?>
        </div>
        <?php endif; ?>

        <div class="puntos-restantes">
            <div class="label">Sus puntos disponibles</div>
            <div class="valor">
                <span class="icono">⭐</span><?= number_format($puntos_restantes) ?> PUNTOS
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
            <p>de canje de puntos</p>
            <p>------------------------------</p>
            <p>Gracias por su preferencia</p>
            <p><?= date('Y') ?> - PHARMALIVET</p>
        </div>
    </div>

    <button class="btn-print no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Imprimir Comprobante
    </button>

    <script>
        // Auto-imprimir al cargar (opcional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
