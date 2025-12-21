<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Editar Usuario</h2>

<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<form action="<?= base_url('users/update/' . $user['id']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" value="<?= old('name', $user['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= old('email', $user['email']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Rol</label>
        <select name="role" class="form-control" required>
            <option value="administrador" <?= old('role', $user['role']) == 'administrador' ? 'selected' : '' ?>>Administrador</option>
            <option value="vendedor" <?= old('role', $user['role']) == 'vendedor' ? 'selected' : '' ?>>Vendedor</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Contraseña (dejar en blanco si no se desea cambiar)</label>
        <input type="password" name="password" class="form-control">
    </div>
    <button class="btn btn-primary">Actualizar</button>
</form>

<?= $this->endSection() ?>
