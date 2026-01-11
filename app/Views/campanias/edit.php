<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
  .campania-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    margin-bottom: 20px;
  }

  .campania-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
  }

  .campania-card-header .card-title {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .campania-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 25px;
  }

  .campania-card .form-group label {
    color: #1A6BA8;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .campania-card .form-control,
  .campania-card .form-select {
    border-radius: 8px;
    border: 1px solid #4A9DD9;
  }

  .campania-card .form-control:focus,
  .campania-card .form-select:focus {
    border-color: #1A6BA8;
    box-shadow: 0 0 0 0.2rem rgba(26, 107, 168, 0.25);
  }

  .campania-card-footer {
    background: #ffffff;
    border-top: 1px solid #D4E8F5;
    padding: 20px;
  }

  .btn-guardar-campania {
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

  .btn-guardar-campania:hover {
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
    padding: 12px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .btn-volver-campania:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(108, 117, 125, 0.3);
    color: #fff;
  }

  .info-card {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
  }

  .info-card .card-header {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    color: #fff;
  }

  .alert-info-custom {
    background: linear-gradient(135deg, #D4E8F5 0%, #ffffff 100%);
    border-left: 4px solid #1A6BA8;
    border-radius: 10px;
    color: #1A6BA8;
  }

  .form-title {
    color: #1A6BA8;
    font-weight: 600;
    margin-bottom: 15px;
  }
</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="campania-card">
        <div class="campania-card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h2 class="card-title"><i class="fas fa-edit mr-2"></i>Editar Campaña</h2>
            <a href="<?= base_url('campanias') ?>" class="btn btn-volver-campania">
              <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if (session('errors')): ?>
  <div class="alert alert-danger" style="border-radius: 10px; border-left: 4px solid #dc3545;">
    <ul class="mb-0">
      <?php foreach (session('errors') as $error): ?>
        <li><?= esc($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>

  <div class="row">
    <div class="col-md-8">
      <div class="card campania-card">
        <div class="campania-card-header">
          <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Editar: <?= esc($campania['nombre']) ?></h3>
        </div>
        <form action="<?= base_url('campanias/update/' . $campania['id']) ?>" method="post">
          <?= csrf_field() ?>
          <div class="campania-card-body">
                        <!-- Datos básicos -->
                        <div class="form-group">
                            <label for="nombre">Nombre de la campaña <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                   value="<?= old('nombre', $campania['nombre']) ?>" required
                                   placeholder="Ej: Campaña Día del Padre, Campaña Verano 2024">
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="2"
                                      placeholder="Descripción opcional de la campaña"><?= old('descripcion', $campania['descripcion']) ?></textarea>
                        </div>

            <hr>
            <h5 class="form-title"><i class="fas fa-calculator mr-2"></i>Regla Base de Puntos</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="puntos_por_monto">Puntos a otorgar <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="puntos_por_monto" name="puntos_por_monto"
                                           value="<?= old('puntos_por_monto', $campania['puntos_por_monto']) ?>" min="1" required>
                                    <small class="form-text text-muted">Cantidad de puntos que se otorgan</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="monto_base">Por cada S/ <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="monto_base" name="monto_base"
                                           value="<?= old('monto_base', $campania['monto_base']) ?>" min="0.01" step="0.01" required>
                                    <small class="form-text text-muted">Monto en soles para obtener los puntos</small>
                                </div>
                            </div>
                        </div>

            <div class="alert alert-info-custom">
              <i class="fas fa-info-circle"></i>
              <strong>Ejemplo:</strong> Con la configuración actual, por una compra de <strong>S/ 100</strong>
              el cliente obtendrá <strong id="ejemploPuntos">50</strong> puntos.
              <small class="d-block mt-1">(Solo se considera la parte entera de la división)</small>
            </div>

            <hr>
            <h5 class="form-title"><i class="fas fa-magic mr-2"></i>Reglas Especiales (Opcionales)</h5>

                        <!-- Puntos dobles fin de semana -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="puntos_dobles_finsemana"
                                       name="puntos_dobles_finsemana" value="1"
                                       <?= old('puntos_dobles_finsemana', $campania['puntos_dobles_finsemana']) ? 'checked' : '' ?>>
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
                                       name="activar_multiplicador" value="1"
                                       <?= $campania['multiplicador_monto_minimo'] ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="activar_multiplicador">
                                    <i class="fas fa-times text-warning"></i> Activar multiplicador por monto mínimo
                                </label>
                            </div>
                        </div>

                        <div id="multiplicador_campos" style="<?= $campania['multiplicador_monto_minimo'] ? '' : 'display: none;' ?>" class="ml-4 p-3 bg-light rounded">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="multiplicador_monto_minimo">Monto mínimo de compra (S/)</label>
                                        <input type="number" class="form-control" id="multiplicador_monto_minimo"
                                               name="multiplicador_monto_minimo"
                                               value="<?= old('multiplicador_monto_minimo', $campania['multiplicador_monto_minimo']) ?>"
                                               min="1" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="multiplicador_valor">Multiplicador</label>
                                        <select class="form-control" id="multiplicador_valor" name="multiplicador_valor">
                                            <option value="2" <?= old('multiplicador_valor', $campania['multiplicador_valor']) == 2 ? 'selected' : '' ?>>x2 (Doble)</option>
                                            <option value="3" <?= old('multiplicador_valor', $campania['multiplicador_valor']) == 3 ? 'selected' : '' ?>>x3 (Triple)</option>
                                            <option value="4" <?= old('multiplicador_valor', $campania['multiplicador_valor']) == 4 ? 'selected' : '' ?>>x4 (Cuádruple)</option>
                                            <option value="5" <?= old('multiplicador_valor', $campania['multiplicador_valor']) == 5 ? 'selected' : '' ?>>x5 (Quíntuple)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">
                                Los puntos se multiplicarán cuando la compra supere el monto mínimo establecido
                            </small>
                        </div>
                    </div>

          </div>
          <div class="campania-card-footer">
            <button type="submit" class="btn btn-guardar-campania">
              <i class="fas fa-save mr-1"></i> Guardar Cambios
            </button>
            <a href="<?= base_url('campanias') ?>" class="btn btn-volver-campania">
              <i class="fas fa-times mr-1"></i> Cancelar
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card campania-card info-card">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Información</h3>
        </div>
        <div class="card-body" style="background: #ffffff;">
                    <p><strong>Creada:</strong> <?= date('d/m/Y H:i', strtotime($campania['created_at'])) ?></p>
                    <p><strong>Última modificación:</strong> <?= date('d/m/Y H:i', strtotime($campania['updated_at'])) ?></p>
                    <hr>
                    <p class="small text-muted">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Los cambios en las reglas solo afectarán a las compras futuras.
                        Los puntos ya generados no se recalcularán.
                    </p>
                </div>
            </div>
        </div>
    </div>
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
});
</script>
<?= $this->endSection() ?>
