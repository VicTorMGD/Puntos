<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Registrar compra</h3>
  </div>

  <div class="card-body">
    <div class="form-group">
      <label>DNI del cliente</label>
      <input type="text" id="dni" class="form-control" placeholder="Ingrese DNI" maxlength="8">
    </div>

    <button class="btn btn-primary" id="buscarCliente">Buscar</button>

    <hr>

    <div id="infoCliente" style="display:none">
      <p><strong>Cliente:</strong> <span id="datosCliente"></span></p>
      <p><strong>Puntos actuales:</strong> <span id="puntosActuales"></span></p>

      <div class="form-group">
        <label>Monto de compra</label>
        <input type="number" id="monto" class="form-control">
      </div>

      <button class="btn btn-success" id="guardarCompra">Guardar</button>
      <button class="btn btn-secondary" id="imprimir">Imprimir</button>
    </div>
  </div>
</div>

<?= view('clientes/modal_form') ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
  <script>
    const BASE_URL = '<?= base_url() ?>';
  </script>
  <script src="<?= base_url('js/compras.js') ?>"></script>
<?= $this->endSection() ?>




