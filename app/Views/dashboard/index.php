<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Dashboard</h2>

<div class="row mb-4">

    <div class="col-md-3">
        <div class="card text-bg-primary">
            <div class="card-body">
                <h6>Total Clientes</h6>
                <h3><?= $totalClientes ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-bg-success">
            <div class="card-body">
                <h6>Puntos Totales</h6>
                <h3><?= $puntosTotales ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-bg-warning">
            <div class="card-body">
                <h6>Puntos Hoy</h6>
                <h3><?= $puntosHoy ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-bg-dark">
            <div class="card-body">
                <h6>Total de compras hoy</h6>
                <h3><?= $totalComprasHoy ?></h3>
            </div>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-md-12">
        <div id="chartPuntos" style="height:400px;"></div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div id="chartCompras" style="height:400px;"></div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script src="<?= base_url('js/dashboard/index.js') ?>"></script>
<?= $this->endSection() ?>
