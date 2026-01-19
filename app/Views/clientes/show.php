<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .cliente-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .cliente-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
  }

  .cliente-card-header h3 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .cliente-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 25px;
  }

  .cliente-info-box {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .cliente-info-item {
    padding: 15px 0;
    border-bottom: 1px solid #E8F2F8;
  }

  .cliente-info-item:last-child {
    border-bottom: none;
  }

  .cliente-info-item strong {
    color: #1A6BA8;
    font-weight: 600;
    font-size: 0.95rem;
    display: inline-block;
    width: 180px;
  }

  .cliente-info-item span {
    color: #333;
    font-size: 1rem;
  }

  .puntos-destacado {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1A6BA8;
  }

  /* Estilos responsive */
  @media (max-width: 767.98px) {
    .cliente-card-header h3 {
      font-size: 1.2rem;
    }
    .cliente-card-body {
      padding: 15px;
    }
    .cliente-info-box {
      padding: 15px;
    }
    .cliente-info-item strong {
      display: block;
      width: 100%;
      margin-bottom: 5px;
    }
  }

  @media (max-width: 575.98px) {
    .cliente-card-header {
      padding: 12px 15px;
    }
    .cliente-card-header h3 {
      font-size: 1rem;
    }
    .cliente-card-body {
      padding: 12px;
    }
    .puntos-destacado {
      font-size: 1.3rem;
    }
  }
</style>

<div class="card cliente-card">
  <div class="cliente-card-header">
    <h3><i class="fas fa-user-circle mr-2"></i>Detalle del Cliente</h3>
  </div>

  <div class="cliente-card-body">
    <div class="cliente-info-box">
      <div class="cliente-info-item">
        <strong><i class="fas fa-user mr-2"></i>Nombre:</strong>
        <span><?= esc($cliente['nombres'] . ' ' . $cliente['apellidos']) ?></span>
      </div>

      <div class="cliente-info-item">
        <strong><i class="fas fa-id-card mr-2"></i>DNI:</strong>
        <span><?= esc($cliente['numero_documento']) ?></span>
      </div>

      <div class="cliente-info-item">
        <strong><i class="fas fa-coins mr-2"></i>Puntos acumulados:</strong>
        <span class="puntos-destacado"><?= number_format((int) $puntos_acumulados, 0, ',', '.') ?></span>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
