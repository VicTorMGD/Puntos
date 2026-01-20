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
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
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
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 25px;
  }

  .compras-form-label {
    font-weight: 600;
    color: #1A6BA8;
  }

  .compras-input {
    border-radius: 12px;
    border: 2px solid #4A9DD9;
    transition: all 0.2s ease;
  }

  .compras-input:focus {
    border-color: #1A6BA8;
    box-shadow: 0 0 0 4px rgba(26, 107, 168, 0.12);
  }

  .btn-buscar-cliente {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    letter-spacing: 0.5px;
  }

  .btn-buscar-cliente:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .info-cliente-box {
    background-color: #ffffff;
    border-radius: 14px;
    padding: 16px 18px 18px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid #C8E0F0;
  }

  .info-cliente-box p {
    margin-bottom: 6px;
  }

  .puntos-actuales {
    font-weight: 700;
    color: #1A6BA8;
  }

  .btn-guardar-compra {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    letter-spacing: 0.5px;
  }

  .btn-guardar-compra:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-imprimir-ticket {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .btn-imprimir-ticket:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(108, 117, 125, 0.3);
    color: #fff;
  }

  .compras-image-col {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .compras-image-col img {
    max-width: 100%;
    max-height: 320px;
    object-fit: contain;
    filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.1));
  }

  /* Responsive adjustments */
  @media (max-width: 991.98px) {
    .compras-card-header {
      padding: 14px 18px;
    }
    .compras-card-header h3 {
      font-size: 1.2rem;
    }
    .compras-image-col {
      order: -1;
      padding: 15px 20px 0;
    }
    .compras-image-col img {
      max-height: 200px;
    }
  }

  @media (max-width: 767.98px) {
    .compras-card-body {
      padding: 18px;
    }
    .compras-image-col {
      padding: 10px 15px 0;
    }
    .compras-image-col img {
      max-height: 160px;
    }
    .compras-form-label {
      font-size: 0.95rem;
    }
    .compras-input {
      font-size: 1rem;
      padding: 12px 14px;
    }
    .btn-buscar-cliente,
    .btn-guardar-compra,
    .btn-imprimir-ticket {
      width: 100%;
      margin-bottom: 10px;
    }
    .info-cliente-box {
      padding: 14px 16px;
    }
  }

  @media (max-width: 575.98px) {
    .compras-card-header h3 {
      font-size: 1.1rem;
    }
    .compras-card-body {
      padding: 15px;
    }
    .compras-image-col {
      display: none;
    }
    .mt-3 {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .btn-guardar-compra,
    .btn-imprimir-ticket {
      margin-right: 0 !important;
    }
  }
</style>

<div class="card compras-card">
  <div class="compras-card-header">
    <h3><i class="fas fa-shopping-cart mr-2"></i>Registrar compra</h3>
  </div>

  <div class="compras-card-body">
    <div class="row g-4">
      <!-- Columna del formulario -->
      <div class="col-12 col-lg-6">
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

      <!-- Columna de la imagen -->
      <div class="col-12 col-lg-6 compras-image-col d-none d-md-flex">
        <img src="<?= base_url('assets/img/registro.png') ?>" alt="Ilustración de compras">
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
