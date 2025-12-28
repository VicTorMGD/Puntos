<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ticket de Compra</title>
  <style>
    body { font-family: monospace; }
    .ticket { width: 280px; }
    .center { text-align: center; }
  </style>
</head>
<body onload="window.print()">
  <div class="ticket">
    <div class="center">
      <strong>MI TIENDA</strong><br>
      Sistema de Puntos
    </div>
    <hr>

    Cliente: <?= esc($nombres . ' ' . $apellidos) ?><br>
    DNI: <?= esc($numero_documento) ?><br>

    <hr>
    Monto: S/ <?= number_format($monto_compra, 2) ?><br>
    Puntos generados con esta compra: <?= esc($puntos_generados) ?><br>
    
    <hr>
    <strong>TOTAL PUNTOS ACUMULADOS: <?= esc($puntos_acumulados) ?></strong><br>
    
    <hr>
    Fecha: <?= $created_at ?><br>

    <div class="center">
      ¡Gracias por su compra!
    </div>
  </div>
</body>
</html>
