
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .puntos-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .puntos-card-header {
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    color: #fff;
    padding: 18px 24px;
  }

  .puntos-card-header h3 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .puntos-card-body {
    background: linear-gradient(to bottom, #E0F4F8 0%, #ffffff 100%);
    padding: 18px 22px 22px;
  }

  .info-puntos {
    background-color: #ffffff;
    padding: 12px 18px;
    border-radius: 10px;
    margin-bottom: 18px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .info-puntos strong {
    color: #1B5E7C;
    font-size: 1.1rem;
  }

  #tablaPuntos {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
  }

  #tablaPuntos thead {
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    color: #fff;
  }

  #tablaPuntos thead th {
    border-color: rgba(255, 255, 255, 0.2);
    font-weight: 600;
  }

  #tablaPuntos tbody tr:nth-child(even) {
    background-color: #F5FAFC;
  }

  #tablaPuntos tbody tr:hover {
    background-color: #E3F2F9;
  }

  #tablaPuntos td,
  #tablaPuntos th {
    vertical-align: middle;
  }
</style>

<div class="card puntos-card">
  <div class="puntos-card-header">
    <h3>
      Historial de puntos – <?= esc($cliente['nombres'].' '.$cliente['apellidos']) ?>
    </h3>
  </div>

  <div class="puntos-card-body">
    <div class="info-puntos">
      <strong>Puntos acumulados:</strong>
      <?= $cliente['puntos_acumulados'] ?>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0" id="tablaPuntos">
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
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
  <script src="<?= base_url('js/clientes/puntos.js') ?>"></script>
<?= $this->endSection() ?>
