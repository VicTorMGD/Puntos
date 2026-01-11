<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .clientes-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .clientes-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .clientes-card-header h2 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .clientes-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 18px 22px 22px;
  }

  #tablaClientes {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
  }

  #tablaClientes thead {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
  }

  #tablaClientes thead th {
    border-color: rgba(255, 255, 255, 0.2);
    font-weight: 600;
  }

  #tablaClientes tbody tr:nth-child(even) {
    background-color: #F0F7FB;
  }

  #tablaClientes tbody tr:hover {
    background-color: #C8E0F0;
  }

  #tablaClientes td,
  #tablaClientes th {
    vertical-align: middle;
  }
</style>

<div class="card clientes-card">
  <div class="clientes-card-header">
    <h2><i class="fas fa-users mr-2"></i>Módulo de Clientes</h2>
  </div>

  <div class="clientes-card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0" id="tablaClientes">
        <thead>
          <tr>
            <th>DNI</th>
            <th>Cliente</th>
            <th>Puntos</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($clientes as $c): ?>
            <tr>
              <td><?= esc($c['numero_documento']) ?></td>
              <td><?= esc($c['nombres'] . ' ' . $c['apellidos']) ?></td>
              <td><?= $c['puntos'] ?></td>
              <td>
                <a href="<?= site_url('clientes/'.$c['id'].'/puntos') ?>"
                  class="btn btn-sm btn-info">
                    <i class="fas fa-coins"></i>
                </a>

                <a href="<?= site_url('clientes/'.$c['id'].'/edit') ?>"
                  class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                </a>

                <button class="btn btn-sm btn-danger btnEliminar"
                        data-id="<?= $c['id'] ?>">
                    <i class="fas fa-trash"></i>
                </button>
              </td>

            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/clientes/index.js') ?>"></script>
<?= $this->endSection() ?>

