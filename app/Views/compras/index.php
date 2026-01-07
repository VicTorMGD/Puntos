<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .compras-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .compras-card-header {
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    color: #fff;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .compras-card-header h3 {
    margin: 0;
    font-size: 1.35rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .compras-card-body {
    background: linear-gradient(to bottom, #E0F4F8 0%, #ffffff 100%);
    padding: 20px 22px 24px;
  }

  .compras-form-label {
    font-weight: 600;
    color: #1B5E7C;
  }

  .compras-input {
    border-radius: 12px;
    border: 2px solid #B8D4E0;
    transition: all 0.2s ease;
  }

  .compras-input:focus {
    border-color: #1B5E7C;
    box-shadow: 0 0 0 4px rgba(27, 94, 124, 0.12);
  }

  .btn-buscar-cliente {
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 999px;
    padding: 8px 18px;
    box-shadow: 0 4px 10px rgba(27, 94, 124, 0.4);
    transition: all 0.2s ease;
  }

  .btn-buscar-cliente:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(27, 94, 124, 0.5);
    color: #fff;
  }

  .info-cliente-box {
    background-color: #ffffff;
    border-radius: 14px;
    padding: 16px 18px 18px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid #D4E7F0;
  }

  .info-cliente-box p {
    margin-bottom: 6px;
  }

  .puntos-actuales {
    font-weight: 700;
    color: #1B5E7C;
  }

  .btn-guardar-compra {
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 999px;
    padding: 8px 22px;
    box-shadow: 0 4px 10px rgba(27, 94, 124, 0.4);
    transition: all 0.2s ease;
  }

  .btn-guardar-compra:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(27, 94, 124, 0.5);
    color: #fff;
  }

  .btn-imprimir-ticket {
    background: linear-gradient(135deg, #3A7A9A 0%, #87CEEB 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 999px;
    padding: 8px 20px;
    box-shadow: 0 4px 10px rgba(58, 122, 154, 0.4);
    transition: all 0.2s ease;
  }

  .btn-imprimir-ticket:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(58, 122, 154, 0.5);
    color: #fff;
  }
</style>

<div class="card compras-card">
  <div class="compras-card-header">
    <h3><i class="fas fa-shopping-cart mr-2"></i>Registrar compra</h3>
  </div>

  <div class="compras-card-body">
    <div class="form-group">
      <label class="compras-form-label" for="dni">DNI del cliente</label>
      <input
        type="text"
        id="dni"
        class="form-control compras-input"
        placeholder="Ingrese DNI (8 dígitos)"
        maxlength="8"
        pattern="[0-9]{8}"
        inputmode="numeric"
      >
    </div>

    <button class="btn btn-buscar-cliente mb-3" id="buscarCliente">
      <i class="fas fa-search mr-1"></i> Buscar
    </button>

    <hr>

    <div id="infoCliente" style="display:none">
      <div class="info-cliente-box mb-3">
        <p><strong>Cliente:</strong> <span id="datosCliente"></span></p>
        <p><strong>Puntos actuales:</strong> <span class="puntos-actuales" id="puntosActuales"></span></p>
      </div>

      <div class="form-group">
        <label class="compras-form-label" for="monto">Monto de compra</label>
        <input type="number" id="monto" class="form-control compras-input" placeholder="Ingrese el monto">
      </div>

      <div class="mt-3">
        <button class="btn btn-guardar-compra mr-2" id="guardarCompra">
          <i class="fas fa-save mr-1"></i> Guardar
        </button>
        <button class="btn btn-imprimir-ticket" id="imprimir">
          <i class="fas fa-print mr-1"></i> Imprimir
        </button>
      </div>
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
