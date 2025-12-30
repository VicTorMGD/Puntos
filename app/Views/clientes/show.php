<h3>Detalle del cliente</h3>

<p><strong>Nombre:</strong>
  <?= esc($cliente['nombres'] . ' ' . $cliente['apellidos']) ?>
</p>

<p><strong>DNI:</strong> <?= esc($cliente['numero_documento']) ?></p>

<p>
  <strong>Puntos acumulados:</strong>
  <?= (int) $puntos_acumulados ?>
</p>
