<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
  .campania-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .campania-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .campania-card-header h3 {
    margin: 0;
    font-size: 1.35rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .campania-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 25px;
  }

  .campania-form-label {
    color: #1A6BA8;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .campania-input {
    border-radius: 12px;
    border: 2px solid #4A9DD9;
    transition: all 0.2s ease;
  }

  .campania-input:focus {
    border-color: #1A6BA8;
    box-shadow: 0 0 0 4px rgba(26, 107, 168, 0.12);
  }

  .btn-crear-campania {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    letter-spacing: 0.5px;
  }

  .btn-crear-campania:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-volver-campania {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .btn-volver-campania:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(108, 117, 125, 0.3);
    color: #fff;
  }

  .alert-warning-custom {
    background: linear-gradient(135deg, #fff3cd 0%, #ffffff 100%);
    border-left: 4px solid #ffc107;
    border-radius: 10px;
    color: #856404;
    padding: 15px 20px;
  }

  .alert-info-custom {
    background: linear-gradient(135deg, #D4E8F5 0%, #ffffff 100%);
    border-left: 4px solid #1A6BA8;
    border-radius: 10px;
    color: #1A6BA8;
    padding: 15px 20px;
  }

  .section-title {
    color: #1A6BA8;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #C8E0F0;
  }

  .ayuda-box {
    background-color: #ffffff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border-left: 4px solid #17a2b8;
  }

  .ayuda-box h5 {
    color: #17a2b8;
    font-weight: 700;
    margin-bottom: 15px;
  }

  .ayuda-box h6 {
    color: #1A6BA8;
    font-weight: 600;
    margin-top: 12px;
  }

  .multiplicador-box {
    background-color: #F0F7FB;
    border-radius: 12px;
    padding: 15px;
    margin-top: 10px;
  }

  .footer-actions {
    background: #ffffff;
    border-top: 1px solid #D4E8F5;
    padding: 20px 25px;
    border-radius: 0 0 18px 18px;
  }
</style>

<div class="card campania-card">
  <div class="campania-card-header">
    <h3><i class="fas fa-plus-circle mr-2"></i>Nueva Campaña</h3>
    <a href="<?= base_url('campanias') ?>" class="btn btn-volver-campania">
      <i class="fas fa-arrow-left mr-1"></i> Volver
    </a>
  </div>

  <form action="<?= base_url('campanias/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="campania-card-body">
      <?php if ($campaniaActiva): ?>
      <div class="alert alert-warning-custom mb-4">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        <strong>Atención:</strong> Ya existe una campaña activa (<strong><?= esc($campaniaActiva['nombre']) ?></strong>).
        Al crear una nueva campaña, la campaña actual se cerrará automáticamente.
      </div>
      <?php endif; ?>

      <?php if (session('errors')): ?>
      <div class="alert alert-danger mb-4" style="border-radius: 10px; border-left: 4px solid #dc3545;">
        <ul class="mb-0">
          <?php foreach (session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-8">
          <!-- Datos básicos -->
          <div class="form-group">
            <label class="campania-form-label" for="nombre">Nombre de la campaña <span class="text-danger">*</span></label>
            <input type="text" class="form-control campania-input" id="nombre" name="nombre"
                   value="<?= old('nombre') ?>" required
                   placeholder="Ej: Campaña Día del Padre, Campaña Verano 2024">
          </div>

          <div class="form-group">
            <label class="campania-form-label" for="descripcion">Descripción</label>
            <textarea class="form-control campania-input" id="descripcion" name="descripcion" rows="2"
                      placeholder="Descripción opcional de la campaña"><?= old('descripcion') ?></textarea>
          </div>

          <h5 class="section-title mt-4"><i class="fas fa-calculator mr-2"></i>Regla Base de Puntos</h5>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="campania-form-label" for="puntos_por_monto">Puntos a otorgar <span class="text-danger">*</span></label>
                <input type="number" class="form-control campania-input" id="puntos_por_monto" name="puntos_por_monto"
                       value="<?= old('puntos_por_monto', 1) ?>" min="1" required>
                <small class="form-text text-muted">Cantidad de puntos que se otorgan</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="campania-form-label" for="monto_base">Por cada S/ <span class="text-danger">*</span></label>
                <input type="number" class="form-control campania-input" id="monto_base" name="monto_base"
                       value="<?= old('monto_base', 2.00) ?>" min="0.01" step="0.01" required>
                <small class="form-text text-muted">Monto en soles para obtener los puntos</small>
              </div>
            </div>
          </div>

          <div class="alert alert-info-custom">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Ejemplo:</strong> Con la configuración actual, por una compra de <strong>S/ 100</strong>
            el cliente obtendrá <strong id="ejemploPuntos">50</strong> puntos.
            <small class="d-block mt-1">(Solo se considera la parte entera de la división)</small>
          </div>

          <h5 class="section-title mt-4"><i class="fas fa-magic mr-2"></i>Reglas Especiales (Opcionales)</h5>

          <!-- Puntos dobles fin de semana -->
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="puntos_dobles_finsemana"
                     name="puntos_dobles_finsemana" value="1" <?= old('puntos_dobles_finsemana') ? 'checked' : '' ?>>
              <label class="custom-control-label" for="puntos_dobles_finsemana">
                <i class="fas fa-calendar-week text-info"></i> Puntos dobles los fines de semana
              </label>
            </div>
            <small class="form-text text-muted">Los puntos se duplicarán los sábados y domingos</small>
          </div>

          <!-- Multiplicador por monto mínimo -->
          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="activar_multiplicador"
                     name="activar_multiplicador" value="1">
              <label class="custom-control-label" for="activar_multiplicador">
                <i class="fas fa-times text-warning"></i> Activar multiplicador por monto mínimo
              </label>
            </div>
          </div>

          <div id="multiplicador_campos" style="display: none;" class="multiplicador-box">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-0">
                  <label class="campania-form-label" for="multiplicador_monto_minimo">Monto mínimo de compra (S/)</label>
                  <input type="number" class="form-control campania-input" id="multiplicador_monto_minimo"
                         name="multiplicador_monto_minimo" value="<?= old('multiplicador_monto_minimo', 100) ?>"
                         min="1" step="0.01">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-0">
                  <label class="campania-form-label" for="multiplicador_valor">Multiplicador</label>
                  <select class="form-control campania-input" id="multiplicador_valor" name="multiplicador_valor">
                    <option value="2" <?= old('multiplicador_valor') == 2 ? 'selected' : '' ?>>x2 (Doble)</option>
                    <option value="3" <?= old('multiplicador_valor') == 3 ? 'selected' : '' ?>>x3 (Triple)</option>
                    <option value="4" <?= old('multiplicador_valor') == 4 ? 'selected' : '' ?>>x4 (Cuádruple)</option>
                    <option value="5" <?= old('multiplicador_valor') == 5 ? 'selected' : '' ?>>x5 (Quíntuple)</option>
                  </select>
                </div>
              </div>
            </div>
            <small class="text-muted d-block mt-2">
              Los puntos se multiplicarán cuando la compra supere el monto mínimo establecido
            </small>
          </div>
        </div>

        <div class="col-md-4">
          <div class="ayuda-box">
            <h5><i class="fas fa-lightbulb mr-2"></i>Ayuda</h5>

            <h6>Regla Base</h6>
            <p class="small mb-2">Define cuántos puntos se otorgan por cada cierto monto de compra. Solo se considera la parte entera.</p>

            <h6>Puntos Dobles Fin de Semana</h6>
            <p class="small mb-2">Si está activo, los puntos se duplican los sábados y domingos.</p>

            <h6>Multiplicador por Monto</h6>
            <p class="small mb-2">Si la compra supera un monto mínimo, los puntos se multiplican por el factor seleccionado.</p>

            <hr>
            <p class="small text-muted mb-0">
              <i class="fas fa-info-circle"></i> Las reglas especiales se pueden combinar.
              Por ejemplo, una compra de S/ 150 un sábado con puntos dobles y multiplicador x2
              obtendría: puntos base x2 (fin de semana) x2 (multiplicador) = x4 puntos.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-actions">
      <button type="submit" class="btn btn-crear-campania mr-2">
        <i class="fas fa-save mr-1"></i> Crear Campaña
      </button>
      <a href="<?= base_url('campanias') ?>" class="btn btn-volver-campania">
        <i class="fas fa-times mr-1"></i> Cancelar
      </a>
    </div>
  </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
  // Calcular ejemplo de puntos
  function calcularEjemplo() {
    const puntosBase = parseInt($('#puntos_por_monto').val()) || 1;
    const montoBase = parseFloat($('#monto_base').val()) || 1;
    const compraEjemplo = 100;

    let puntos = Math.floor(compraEjemplo / montoBase) * puntosBase;
    $('#ejemploPuntos').text(puntos);
  }

  $('#puntos_por_monto, #monto_base').on('input', calcularEjemplo);
  calcularEjemplo();

  // Toggle multiplicador campos
  $('#activar_multiplicador').on('change', function() {
    if ($(this).is(':checked')) {
      $('#multiplicador_campos').slideDown();
    } else {
      $('#multiplicador_campos').slideUp();
      $('#multiplicador_monto_minimo').val('');
      $('#multiplicador_valor').val('2');
    }
  });

  // Si hay valor previo, mostrar campos
  <?php if (old('multiplicador_monto_minimo')): ?>
  $('#activar_multiplicador').prop('checked', true);
  $('#multiplicador_campos').show();
  <?php endif; ?>
});
</script>
<?= $this->endSection() ?>
