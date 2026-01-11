<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .user-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .user-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
  }

  .user-card-header h2 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .user-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 18px 22px 22px;
  }

  .form-wrapper {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .form-wrapper .mb-3 label {
    color: #1A6BA8;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .form-wrapper .form-control,
  .form-wrapper .form-select {
    border-radius: 8px;
    border: 1px solid #4A9DD9;
  }

  .form-wrapper .form-control:focus,
  .form-wrapper .form-select:focus {
    border-color: #1A6BA8;
    box-shadow: 0 0 0 0.2rem rgba(26, 107, 168, 0.25);
  }

  .btn-registrar {
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

  .btn-registrar:hover {
    background: linear-gradient(90deg, #ff7a45 0%, #ffb319 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(255, 107, 53, 0.3);
    color: #ffffff;
  }

  .btn-cancelar {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 50px;
    padding: 12px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
  }

  .btn-cancelar:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 12px rgba(108, 117, 125, 0.3);
    color: #fff;
  }

  .alert-errors {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 18px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border-left: 4px solid #dc3545;
  }
</style>

<div class="card user-card">
  <div class="user-card-header">
    <h2><i class="fas fa-user-plus mr-2"></i>Nuevo Usuario</h2>
  </div>

  <div class="user-card-body">
    <?php if (session('errors')): ?>
      <div class="alert alert-danger alert-errors">
        <ul class="mb-0">
          <?php foreach (session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
          <?php endforeach ?>
        </ul>
      </div>
    <?php endif ?>

    <div class="form-wrapper">
      <form action="<?= base_url('users/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label>Nombre</label>
          <input type="text" name="name" class="form-control" required value="<?= old('name') ?>">
        </div>
        <div class="mb-3">
          <label>Correo electrónico</label>
          <input type="email" name="email" class="form-control" required value="<?= old('email') ?>">
        </div>
        <div class="mb-3">
          <label>Contraseña</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Rol</label>
          <select name="role" class="form-control" required>
            <option value="">Seleccionar rol</option>
            <option value="administrador" <?= old('role') == 'administrador' ? 'selected' : '' ?>>Administrador</option>
            <option value="vendedor" <?= old('role') == 'vendedor' ? 'selected' : '' ?>>Vendedor</option>
          </select>
        </div>

        <button type="submit" class="btn btn-registrar">Registrar</button>
        <a href="<?= base_url('users') ?>" class="btn btn-cancelar">Cancelar</a>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
