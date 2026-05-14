<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .config-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .config-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .config-card-header h3 {
    margin: 0;
    font-size: 1.35rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .config-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 25px;
  }

  .config-section-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1A6BA8;
    border-bottom: 2px solid #4A9DD9;
    padding-bottom: 8px;
    margin-bottom: 18px;
  }

  .config-form-label {
    font-weight: 600;
    color: #1A6BA8;
  }

  .config-textarea {
    border-radius: 12px;
    border: 2px solid #4A9DD9;
    transition: all 0.2s ease;
    resize: vertical;
    min-height: 100px;
  }

  .config-textarea:focus {
    border-color: #1A6BA8;
    box-shadow: 0 0 0 4px rgba(26, 107, 168, 0.12);
  }

  .config-checkbox-box {
    background: #fff;
    border: 1px solid #C8E0F0;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: box-shadow 0.2s ease;
  }

  .config-checkbox-box:hover {
    box-shadow: 0 4px 12px rgba(26, 107, 168, 0.1);
  }

  .config-checkbox-box input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: #1A6BA8;
    cursor: pointer;
    flex-shrink: 0;
  }

  .config-checkbox-box label {
    margin: 0;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    font-size: 0.95rem;
  }

  .config-checkbox-box small {
    color: #888;
    font-size: 0.8rem;
    display: block;
    margin-top: 2px;
  }

  .btn-guardar-config {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    letter-spacing: 0.5px;
  }

  .btn-guardar-config:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .alert-success-custom {
    background: #e8f5e9;
    border: 1px solid #4caf50;
    border-radius: 12px;
    color: #2e7d32;
    padding: 14px 18px;
    margin-bottom: 20px;
    font-weight: 600;
  }
</style>

<div class="card config-card">
  <div class="config-card-header">
    <h3><i class="fas fa-cog mr-2"></i>Configuración</h3>
  </div>

  <div class="config-card-body">

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert-success-custom">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('configuracion/guardar') ?>" method="POST">
      <?= csrf_field() ?>

      <!-- Sección tickets -->
      <div class="config-section-title">
        <i class="fas fa-receipt mr-2"></i>Observaciones en tickets
      </div>

      <div class="form-group">
        <label class="config-form-label" for="observacion_texto">
          Texto de observación
        </label>
        <textarea
          id="observacion_texto"
          name="observacion_texto"
          class="form-control config-textarea"
          placeholder="Escribe aquí el mensaje que aparecerá en los tickets seleccionados..."
        ><?= esc($observacion_texto) ?></textarea>
        <small class="text-muted mt-1 d-block">
          Este texto aparecerá al final de los tickets que marques a continuación.
        </small>
      </div>

      <div class="form-group mt-3">
        <label class="config-form-label mb-2 d-block">Mostrar en:</label>

        <div class="config-checkbox-box">
          <input
            type="checkbox"
            id="observacion_en_compra"
            name="observacion_en_compra"
            <?= $observacion_en_compra === '1' ? 'checked' : '' ?>
          >
          <div>
            <label for="observacion_en_compra">
              <i class="fas fa-shopping-cart mr-1"></i>Comprobante de Compra
            </label>
            <small>Ticket que se imprime al registrar una compra</small>
          </div>
        </div>

        <div class="config-checkbox-box">
          <input
            type="checkbox"
            id="observacion_en_canje"
            name="observacion_en_canje"
            <?= $observacion_en_canje === '1' ? 'checked' : '' ?>
          >
          <div>
            <label for="observacion_en_canje">
              <i class="fas fa-gift mr-1"></i>Comprobante de Canje
            </label>
            <small>Ticket que se imprime al realizar un canje de puntos</small>
          </div>
        </div>

        <div class="config-checkbox-box">
          <input
            type="checkbox"
            id="observacion_en_consulta"
            name="observacion_en_consulta"
            <?= $observacion_en_consulta === '1' ? 'checked' : '' ?>
          >
          <div>
            <label for="observacion_en_consulta">
              <i class="fas fa-search mr-1"></i>Consulta de Puntos
            </label>
            <small>Ticket que se imprime al consultar los puntos de un cliente</small>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <button type="submit" class="btn btn-guardar-config">
          <i class="fas fa-save mr-2"></i>Guardar configuración
        </button>
      </div>

    </form>
  </div>
</div>

<?= $this->endSection() ?>