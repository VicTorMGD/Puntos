<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4"><i class="fas fa-user-circle"></i> Mi Perfil</h2>
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
        <!-- Columna izquierda: Avatar -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <?php if ($user['avatar'] && file_exists(WRITEPATH . 'uploads/avatars/' . $user['avatar'])): ?>
                            <img class="profile-user-img img-fluid img-circle avatar-animated"
                                 src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>"
                                 alt="Avatar del usuario"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <div class="avatar-initials avatar-animated" style="width: 150px; height: 150px; margin: 0 auto;">
                                <?= strtoupper(substr($user['name'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <h3 class="profile-username text-center mt-3"><?= esc($user['name']) ?></h3>
                    <p class="text-muted text-center">
                        <span class="badge badge-<?= $user['role'] === 'administrador' ? 'danger' : 'info' ?>">
                            <?= ucfirst(esc($user['role'])) ?>
                        </span>
                    </p>

                    <hr>

                    <!-- Formulario de avatar -->
                    <form action="<?= base_url('perfil/avatar') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="avatar">Cambiar foto de perfil</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="avatar" name="avatar" accept="image/*">
                                <label class="custom-file-label" for="avatar">Seleccionar imagen...</label>
                            </div>
                            <small class="form-text text-muted">JPG, PNG, GIF o WEBP. Máximo 2MB.</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-upload"></i> Subir foto
                        </button>
                    </form>

                    <?php if ($user['avatar']): ?>
                        <form action="<?= base_url('perfil/avatar/delete') ?>" method="post" class="mt-2">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-outline-danger btn-block btn-sm"
                                    onclick="return confirm('¿Estás seguro de eliminar tu foto de perfil?')">
                                <i class="fas fa-trash"></i> Eliminar foto
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Columna derecha: Datos y contraseña -->
        <div class="col-md-8">
            <!-- Datos personales -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-edit"></i> Datos Personales</h3>
                </div>
                <form action="<?= base_url('perfil/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nombre completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="<?= old('name', $user['name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="<?= old('email', $user['email']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   value="<?= old('phone', $user['phone'] ?? '') ?>"
                                   placeholder="Ej: +51 999 999 999">
                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <input type="text" class="form-control" value="<?= ucfirst(esc($user['role'])) ?>" disabled>
                            <small class="form-text text-muted">El rol solo puede ser modificado por un administrador.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar cambios
                        </button>
                    </div>
                </form>
            </div>

            <!-- Cambiar contraseña -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-lock"></i> Cambiar Contraseña</h3>
                </div>
                <form action="<?= base_url('perfil/password') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="current_password">Contraseña actual <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_password">Nueva contraseña <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                           minlength="6" required>
                                    <small class="form-text text-muted">Mínimo 6 caracteres.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirm_password">Confirmar contraseña <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Cambiar contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para el avatar con iniciales */
.avatar-initials {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 4rem;
    font-weight: bold;
    border-radius: 50%;
    text-transform: uppercase;
}

/* Animación suave para el avatar */
.avatar-animated {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 4px solid #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.avatar-animated:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

/* Estilo para el profile-user-img */
.profile-user-img {
    border: 4px solid #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* Custom file input */
.custom-file-label::after {
    content: "Buscar";
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Mostrar nombre del archivo seleccionado
document.getElementById('avatar').addEventListener('change', function(e) {
    var fileName = e.target.files[0] ? e.target.files[0].name : 'Seleccionar imagen...';
    var label = document.querySelector('.custom-file-label');
    label.textContent = fileName;
});

// Validar que las contraseñas coincidan
document.getElementById('confirm_password').addEventListener('input', function() {
    var newPass = document.getElementById('new_password').value;
    var confirmPass = this.value;

    if (newPass !== confirmPass) {
        this.setCustomValidity('Las contraseñas no coinciden');
    } else {
        this.setCustomValidity('');
    }
});
</script>
<?= $this->endSection() ?>
