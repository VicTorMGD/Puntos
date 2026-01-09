
<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<style>
  .login-card {
    width: 100%;
    border: none;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    overflow: hidden;
  }

  .login-card-header {
    background: linear-gradient(to bottom, #E0F4F8 0%, #ffffff 100%);
    padding: 30px 20px 20px;
    text-align: center;
  }

  .login-card-header img {
    height: 60px;
    opacity: 0.95;
    margin-bottom: 15px;
  }

  .login-card-header h4 {
    color: #1B5E7C;
    font-weight: 700;
    font-size: 1.4rem;
    margin-bottom: 5px;
  }

  .login-card-header p {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0;
  }

  .login-card-body {
    padding: 25px 20px 30px;
    background-color: #ffffff;
  }

  .login-card-body .form-label {
    color: #1B5E7C;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95rem;
  }

  .login-card-body .input-group-text {
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    color: #fff;
    border: none;
    border-radius: 8px 0 0 8px;
    padding: 12px 14px;
  }

  .login-card-body .form-control {
    border: 1px solid #87CEEB;
    border-radius: 0 8px 8px 0;
    padding: 12px 14px;
    font-size: 16px;
  }

  .login-card-body .form-control:focus {
    border-color: #1B5E7C;
    box-shadow: 0 0 0 0.2rem rgba(27, 94, 124, 0.25);
  }

  .btn-toggle-password {
    background-color: #f8f9fa;
    border: 1px solid #87CEEB;
    border-left: none;
    border-radius: 0 8px 8px 0;
    color: #1B5E7C;
    padding: 12px 14px;
  }

  .btn-toggle-password:hover {
    background-color: #E0F4F8;
    color: #1B5E7C;
  }

  .btn-login {
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    padding: 14px 24px;
    box-shadow: 0 4px 10px rgba(27, 94, 124, 0.4);
    transition: all 0.2s ease;
    font-size: 1rem;
  }

  .btn-login:hover,
  .btn-login:active {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(27, 94, 124, 0.5);
    color: #fff;
  }

  .alert-custom-danger {
    background-color: #fff5f5;
    border-left: 4px solid #dc3545;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 15px;
    font-size: 0.9rem;
  }

  .alert-custom-warning {
    background-color: #fffbf0;
    border-left: 4px solid #ffc107;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 15px;
    font-size: 0.9rem;
  }

  .form-check-input:checked {
    background-color: #1B5E7C;
    border-color: #1B5E7C;
  }

  .link-password {
    color: #1B5E7C;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.85rem;
  }

  .link-password:hover {
    color: #87CEEB;
    text-decoration: underline;
  }

  .form-check-label {
    font-size: 0.9rem;
  }

  .text-muted.small {
    font-size: 0.85rem;
  }

  @media (min-width: 576px) {
    .login-card-header {
      padding: 35px 25px 25px;
    }

    .login-card-header img {
      height: 70px;
    }

    .login-card-header h4 {
      font-size: 1.6rem;
    }

    .login-card-body {
      padding: 30px 35px 35px;
    }
  }
</style>

<div class="card login-card">
  <div class="login-card-header">
      <img src="<?= base_url('assets/img/pharmalivet.png') ?>" alt="Logo">
      <h4>Iniciar sesión</h4>
      <p>Accede a tu panel de administración</p>
    </div>

    <div class="login-card-body">
      <?php if (session('error')): ?>
        <div class="alert alert-danger alert-custom-danger small" role="alert">
          <?= esc(session('error')) ?>
        </div>
      <?php endif ?>

      <?php if (session('errors')): ?>
        <div class="alert alert-warning alert-custom-warning small" role="alert">
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
            <input id="password" type="password" name="password" class="form-control" placeholder="Contraseña" required style="border-right: none;">
            <button type="button" class="btn btn-toggle-password" id="togglePassword" title="Mostrar / ocultar">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small" for="remember">Recuérdame</label>
          </div>
          <a href="#" class="small link-password">¿Olvidaste tu contraseña?</a>
        </div>

        <button class="btn btn-login w-100">Entrar</button>
      </form>

      <div class="text-center mt-3 small text-muted">¿No tienes cuenta? Contacta al administrador.</div>
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