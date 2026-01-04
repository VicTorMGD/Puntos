<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Editar cliente</h3>

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
               value="<?= esc($cliente['telefono']) ?>">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email"
               class="form-control"
               value="<?= esc($cliente['email']) ?>">
    </div>

    <button type="submit" class="btn btn-primary">
        Guardar cambios
    </button>

    <a href="<?= site_url('clientes') ?>" class="btn btn-secondary">
        Volver
    </a>
</form>

<?= $this->endSection() ?>
