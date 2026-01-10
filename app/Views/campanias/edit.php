<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2><i class="fas fa-edit"></i> Editar Campaña</h2>
                <a href="<?= base_url('campanias') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Editar: <?= esc($campania['nombre']) ?></h3>
                </div>
                <form action="<?= base_url('campanias/update/' . $campania['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="card-body">
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
                        <h5><i class="fas fa-calculator"></i> Regla Base de Puntos</h5>

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

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Ejemplo:</strong> Con la configuración actual, por una compra de <strong>S/ 100</strong>
                            el cliente obtendrá <strong id="ejemploPuntos">50</strong> puntos.
                            <small class="d-block mt-1">(Solo se considera la parte entera de la división)</small>
                        </div>

                        <hr>
                        <h5><i class="fas fa-magic"></i> Reglas Especiales (Opcionales)</h5>

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

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                        <a href="<?= base_url('campanias') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Información</h3>
                </div>
                <div class="card-body">
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
