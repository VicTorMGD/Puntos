<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ticket de Puntos</title>
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
    <strong>TOTAL PUNTOS ACUMULADOS: <?= esc($puntos_acumulados) ?></strong><br>
    
    <hr>
    Fecha de consulta: <?= $fecha_consulta ?><br>

    <div class="center">
      ¡Gracias por su preferencia!
    </div>
  </div>
</body>
</html>

