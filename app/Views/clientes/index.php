<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Módulo de Clientes</h2>

<table id="tablaClientes" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>DNI</th>
            <th>Cliente</th>
            <th>Puntos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?= esc($c['numero_documento']) ?></td>
                <td><?= esc($c['nombres'] . ' ' . $c['apellidos']) ?></td>
                <td><?= $c['puntos'] ?></td>
                <td>
                    <a href="<?= site_url('clientes/' . $c['id'] . '/puntos') ?>"
                       class="btn btn-sm btn-info">
                        Ver puntos
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/clientes/index.js') ?>"></script>
<?= $this->endSection() ?>

