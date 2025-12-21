
<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-center align-items-center" style="min-height:60vh; background-color:#1A4FFF; border-radius:8px; padding:2px;">
  <div class="card shadow-sm" style="width:380px; border-radius:8px;">
    <div class="card-body p-4">
      <div class="text-center mb-3">
        <img src="<?= base_url('AdminLTE/dist/img/AdminLTELogo.png') ?>" alt="Logo" style="height:48px;opacity:.9">
        <h4 class="mt-2">Iniciar sesión</h4>
        <p class="text-muted small">Accede a tu panel de administración</p>
      </div>

      <?php if (session('error')): ?>
        <div class="alert alert-danger small" role="alert"><?= esc(session('error')) ?></div>
      <?php endif ?>

      <?php if (session('errors')): ?>
        <div class="alert alert-warning small" role="alert">
          <?php foreach(session('errors') as $err): ?>
            <div><?= esc($err) ?></div>
          <?php endforeach ?>
        </div>
      <?php endif ?>

      <form action="<?= base_url('login') ?>" method="post" novalidate>
        <?= csrf_field() ?>

        <div class="mb-3">
          <label class="form-label">Correo electrónico</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="form-control" placeholder="tucorreo@ejemplo.com" required value="<?= esc(old('email')) ?>">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input id="password" type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <button type="button" class="btn btn-light" id="togglePassword" title="Mostrar / ocultar" style="border-top-left-radius:0;border-bottom-left-radius:0">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small" for="remember">Recuérdame</label>
          </div>
          <a href="#" class="small">¿Olvidaste tu contraseña?</a>
        </div>

        <button class="btn btn-primary w-100">Entrar</button>
      </form>

      <div class="text-center mt-3 small text-muted">¿No tienes cuenta? Contacta al administrador.</div>
    </div>
  </div>
</div>

<script>
  // Toggle show/hide password
  (function(){
    const btn = document.getElementById('togglePassword');
    const pwd = document.getElementById('password');
    if (!btn || !pwd) return;
    btn.addEventListener('click', function(){
      const type = pwd.getAttribute('type') === 'password' ? 'text' : 'password';
      pwd.setAttribute('type', type);
      this.querySelector('i').classList.toggle('fa-eye');
      this.querySelector('i').classList.toggle('fa-eye-slash');
    });
  })();
</script>

<?= $this->endSection() ?>