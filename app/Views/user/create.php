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
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
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
    background: linear-gradient(to bottom, #E0F4F8 0%, #ffffff 100%);
    padding: 18px 22px 22px;
  }

  .form-wrapper {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .form-wrapper .mb-3 label {
    color: #1B5E7C;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .form-wrapper .form-control,
  .form-wrapper .form-select {
    border-radius: 8px;
    border: 1px solid #87CEEB;
  }

  .form-wrapper .form-control:focus,
  .form-wrapper .form-select:focus {
    border-color: #1B5E7C;
    box-shadow: 0 0 0 0.2rem rgba(27, 94, 124, 0.25);
  }

  .btn-registrar {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    padding: 10px 24px;
    box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
  }

  .btn-registrar:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4);
    color: #fff;
  }

  .btn-cancelar {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    padding: 10px 24px;
    box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
  }

  .btn-cancelar:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(108, 117, 125, 0.4);
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
    <h2>Nuevo Usuario</h2>
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
