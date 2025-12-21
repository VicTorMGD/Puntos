<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<h3 class="text-center">Iniciar sesión</h3>

<?php if (session('error')): ?>
  <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif ?>

<form action="<?= base_url('login') ?>" method="post">
<?= csrf_field() ?>

  <div class="mb-3">
    <label>Correo</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Contraseña</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button class="btn btn-primary w-100">Entrar</button>
</form>

<?= $this->endSection() ?>
