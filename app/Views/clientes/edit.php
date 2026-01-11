<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .edit-clientes-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .edit-clientes-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .edit-clientes-card-header h2 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .edit-clientes-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 28px 32px 32px;
  }

  .edit-form-wrapper {
    background: #ffffff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  }

  .edit-form-wrapper .form-group {
    margin-bottom: 20px;
  }

  .edit-form-wrapper label {
    font-weight: 600;
    color: #1A6BA8;
    margin-bottom: 8px;
    font-size: 0.95rem;
  }

  .edit-form-wrapper .form-control {
    border: 2px solid #4A9DD9;
    border-radius: 8px;
    padding: 10px 14px;
    transition: all 0.3s ease;
    font-size: 1rem;
  }

  .edit-form-wrapper .form-control:focus {
    border-color: #1A6BA8;
    box-shadow: 0 0 0 0.2rem rgba(26, 107, 168, 0.25);
  }

  .edit-form-wrapper .form-control:read-only {
    background-color: #f8f9fa;
    cursor: not-allowed;
  }

  .btn-guardar {
    background: linear-gradient(90deg, #ff6b35 0%, #ffa500 100%);
    border: none;
    color: #ffffff;
    padding: 12px 20px;
    font-weight: 600;
    border-radius: 50px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    letter-spacing: 0.5px;
  }

  .btn-guardar:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-volver {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    border: none;
    color: #fff;
    padding: 12px 20px;
    font-weight: 600;
    border-radius: 50px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .btn-volver:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(108, 117, 125, 0.3);
    color: #fff;
  }

  .form-buttons {
    margin-top: 24px;
    display: flex;
    gap: 12px;
  }

  /* ===== MEJORAS RESPONSIVE PARA MÓVILES ===== */
  @media (max-width: 768px) {
    /* Header más grande en móviles */
    .edit-clientes-card-header {
      padding: 20px 16px;
    }

    .edit-clientes-card-header h2 {
      font-size: 1.6rem;
    }

    /* Menos padding en el body para aprovechar espacio */
    .edit-clientes-card-body {
      padding: 20px 16px;
    }

    /* Form wrapper más espacioso */
    .edit-form-wrapper {
      padding: 20px 16px;
    }

    /* Mayor espacio entre campos */
    .edit-form-wrapper .form-group {
      margin-bottom: 24px;
    }

    /* Labels más grandes y legibles */
    .edit-form-wrapper label {
      font-size: 1.1rem;
      margin-bottom: 10px;
      display: block;
    }

    /* Inputs más grandes y fáciles de tocar */
    .edit-form-wrapper .form-control {
      font-size: 1.1rem;
      padding: 14px 16px;
      min-height: 50px;
      border-width: 2px;
    }

    /* Botones más grandes para mejor UX táctil */
    .btn-guardar,
    .btn-volver {
      font-size: 1.1rem;
      padding: 14px 24px;
      min-height: 50px;
      width: 100%;
    }

    /* Botones en columna en móviles */
    .form-buttons {
      flex-direction: column;
      gap: 14px;
      margin-top: 28px;
    }

    /* Mejor legibilidad en inputs readonly */
    .edit-form-wrapper .form-control:read-only {
      font-size: 1.1rem;
      color: #6c757d;
    }
  }

  /* Mejoras para móviles muy pequeños */
  @media (max-width: 480px) {
    .edit-clientes-card-header h2 {
      font-size: 1.4rem;
    }

    .edit-form-wrapper label {
      font-size: 1rem;
    }

    .edit-form-wrapper .form-control {
      font-size: 1rem;
      padding: 12px 14px;
      min-height: 48px;
    }

    .btn-guardar,
    .btn-volver {
      font-size: 1rem;
      padding: 12px 20px;
      min-height: 48px;
    }
  }
</style>

<div class="card edit-clientes-card">
  <div class="edit-clientes-card-header">
    <h2><i class="fas fa-user-edit mr-2"></i>Editar Cliente</h2>
  </div>

  <div class="edit-clientes-card-body">
    <div class="edit-form-wrapper">
      <form method="post" action="<?= site_url('clientes/'.$cliente['id'].'/update') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
          <label>DNI</label>
          <input type="text" name="numero_documento"
                 class="form-control"
                 value="<?= esc($cliente['numero_documento']) ?>"
                 readonly>
        </div>

        <div class="form-group">
          <label>Nombres</label>
          <input type="text" name="nombres"
                 class="form-control"
                 value="<?= esc($cliente['nombres']) ?>" required>
        </div>

        <div class="form-group">
          <label>Apellidos</label>
          <input type="text" name="apellidos"
                 class="form-control"
                 value="<?= esc($cliente['apellidos']) ?>" required>
        </div>

        <div class="form-group">
          <label>Teléfono</label>
          <input type="text" name="telefono"
                 class="form-control"
                 value="<?= esc($cliente['telefono']) ?>"
                 maxlength="9">
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email"
                 class="form-control"
                 value="<?= esc($cliente['email']) ?>">
        </div>

        <div class="form-buttons">
          <button type="submit" class="btn btn-guardar">
            <i class="fas fa-save"></i> Guardar cambios
          </button>

          <a href="<?= site_url('clientes') ?>" class="btn btn-volver">
            <i class="fas fa-arrow-left"></i> Volver
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
