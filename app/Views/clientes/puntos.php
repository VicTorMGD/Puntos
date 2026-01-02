<!-- <h3>
  Historial de puntos –
  <?= esc($cliente['nombres'].' '.$cliente['apellidos']) ?>
</h3>

<p>
  <strong>Puntos acumulados:</strong>
  <?= esc($cliente['puntos_acumulados']) ?>
</p>

<table border="1" cellpadding="6" cellspacing="0">
  <thead>
    <tr>
      <th>Fecha</th>
      <th>Puntos</th>
      <th>Tipo</th>
      <th>Descripción</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($movimientos)): ?>
      <tr>
        <td colspan="4">Sin movimientos</td>
      </tr>
    <?php else: ?>
      <?php foreach ($movimientos as $m): ?>
        <tr>
          <td><?= esc($m['created_at'] ?? '') ?></td>
          <td><?= esc($m['puntos']) ?></td>
          <td><?= esc($m['tipo']) ?></td>
          <td><?= esc($m['descripcion']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif ?>
  </tbody>
</table> -->

<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      Historial de puntos – <?= esc($cliente['nombres'].' '.$cliente['apellidos']) ?>
    </h3>
  </div>

  <div class="card-body">
    <p>
      <strong>Puntos acumulados:</strong>
      <?= $cliente['puntos_acumulados'] ?>
    </p>

    <table id="tablaPuntos" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Tipo</th>
          <th>Puntos</th>
          <th>Descripción</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($movimientos as $m): ?>
          <tr>
            <td><?= $m['created_at'] ?></td>
            <td><?= $m['tipo'] ?></td>
            <td><?= $m['puntos'] ?></td>
            <td><?= esc($m['descripcion']) ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
  <script src="<?= base_url('js/clientes/puntos.js') ?>"></script>
<?= $this->endSection() ?>
