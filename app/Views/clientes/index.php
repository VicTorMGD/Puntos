<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
  .clientes-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
  }

  .clientes-card-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .clientes-card-header h2 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
  }

  .clientes-card-body {
    background: linear-gradient(to bottom, #D4E8F5 0%, #ffffff 100%);
    padding: 18px 22px 22px;
  }

  #tablaClientes {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
  }

  #tablaClientes thead {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
  }

  #tablaClientes thead th {
    border-color: rgba(255, 255, 255, 0.2);
    font-weight: 600;
  }

  #tablaClientes tbody tr:nth-child(even) {
    background-color: #F0F7FB;
  }

  #tablaClientes tbody tr:hover {
    background-color: #C8E0F0;
  }

  #tablaClientes td,
  #tablaClientes th {
    vertical-align: middle;
  }

  /* Estilos del gráfico Top 5 */
  .top5-chart-card {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    margin-bottom: 24px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
  }

  .top5-chart-header {
    background: linear-gradient(135deg, #1A6BA8 0%, #4A9DD9 100%);
    color: #fff;
    padding: 15px 24px;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .top5-chart-header i {
    font-size: 1.5rem;
  }

  .top5-chart-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
  }

  .top5-chart-body {
    padding: 15px 20px;
  }

  .top5-chart-col {
    display: flex;
    align-items: center;
  }

  .top5-img-col {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 15px;
  }

  .img-cli-top {
    width: 100%;
    max-width: 100%;
    height: auto;
    object-fit: contain;
  }

  #chartTop5Clientes {
    width: 100%;
    height: 320px;
    min-height: 280px;
  }

  /* Responsive adjustments */
  @media (max-width: 991.98px) {
    .clientes-card-header {
      flex-direction: column;
      gap: 10px;
      text-align: center;
    }
    .clientes-card-header h2 {
      font-size: 1.25rem;
    }
    .top5-chart-header h3 {
      font-size: 1.1rem;
    }
    #chartTop5Clientes {
      height: 300px;
    }
    .top5-img-col {
      display: none;
    }
  }

  @media (max-width: 767.98px) {
    .clientes-card-header {
      padding: 14px 18px;
    }
    .clientes-card-body {
      padding: 14px 16px;
    }
    .top5-chart-header {
      padding: 12px 16px;
    }
    .top5-chart-body {
      padding: 15px;
    }
    #chartTop5Clientes {
      height: 280px;
      min-height: 250px;
    }
    #tablaClientes thead th {
      font-size: 0.85rem;
      padding: 10px 8px;
    }
    #tablaClientes tbody td {
      font-size: 0.85rem;
      padding: 10px 8px;
    }
    .btn-sm {
      padding: 0.35rem 0.5rem;
      font-size: 0.8rem;
    }
  }

  @media (max-width: 575.98px) {
    .clientes-card-header h2 {
      font-size: 1.1rem;
    }
    #chartTop5Clientes {
      height: 280px;
      min-height: 260px;
    }
    .top5-chart-header h3 {
      font-size: 1rem;
    }
  }
</style>



<div class="card clientes-card">
  <div class="clientes-card-header">
    <h2><i class="fas fa-users mr-2"></i>Módulo de Clientes</h2>
  </div>

  <div class="clientes-card-body">

  <!-- Gráfico Top 5 Clientes -->
    <div class="top5-chart-card">
      <div class="top5-chart-header">
        <i class="fas fa-trophy"></i>
        <h3>Top 5 Clientes con Más Puntos</h3>
      </div>
      <div class="top5-chart-body">
        <div class="row g-0 align-items-center">
          <div class="col-lg-8 col-12 top5-chart-col">
            <div id="chartTop5Clientes"></div>
          </div>
          <div class="col-lg-4 top5-img-col">
            <img class="img-cli-top" src="<?= base_url('assets/img/ranking.png') ?>" alt="Ilustración ranking">
          </div>
        </div>
      </div>
    </div> 

    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0" id="tablaClientes">
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
                <a href="<?= site_url('clientes/'.$c['id'].'/puntos') ?>"
                  class="btn btn-sm btn-info">
                    <i class="fas fa-coins"></i>
                </a>

                <a href="<?= site_url('clientes/'.$c['id'].'/edit') ?>"
                  class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                </a>

                <button class="btn btn-sm btn-danger btnEliminar"
                        data-id="<?= $c['id'] ?>">
                    <i class="fas fa-trash"></i>
                </button>
              </td>

            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- ECharts -->
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script src="<?= base_url('js/clientes/index.js') ?>"></script>

<script>
$(function() {
    // Datos del Top 5 desde PHP
    const top5Data = <?= json_encode($top5Clientes) ?>;

    if (top5Data.length === 0) {
        $('#chartTop5Clientes').html('<div class="text-center text-muted py-5"><i class="fas fa-users fa-3x mb-3"></i><p>No hay clientes registrados aún</p></div>');
        return;
    }

    const chartTop5 = echarts.init(document.getElementById('chartTop5Clientes'));

    // Colores dorados con intensidad decreciente (1° más intenso, 5° más claro)
    const gradients = [
        ['#FFD700', '#FFA500'],  // 1° - Dorado intenso
        ['#FFDF33', '#FFB833'],  // 2° - Dorado fuerte
        ['#FFE766', '#FFCC66'],  // 3° - Dorado medio
        ['#FFEF99', '#FFDD88'],  // 4° - Dorado claro
        ['#FFF5BF', '#FFE8A0']   // 5° - Dorado muy suave
    ];

    // Medallas y posiciones
    const medals = ['🥇', '🥈', '🥉', '🏅', '🏅'];

    // Preparar datos - ordenados de mayor a menor
    const maxValue = Math.max(...top5Data.map(d => parseInt(d.total)));

    // Detectar si es móvil
    function isMobile() {
        return window.innerWidth <= 575;
    }

    // Función para obtener opciones según el tamaño de pantalla
    function getChartOption() {
        const mobile = isMobile();

        // Crear nombres según el dispositivo
        const nombresDisplay = top5Data.map((d, i) => {
            if (mobile) {
                // En móvil: solo medalla y primer nombre
                const primerNombre = d.nombres.split(' ')[0];
                return `${medals[i]} ${primerNombre}`;
            } else {
                // En desktop: medalla + nombre completo
                return `${medals[i]}  ${d.nombres} ${d.apellidos} `;
            }
        });

        return {
            tooltip: {
                trigger: 'item',
                backgroundColor: 'rgba(255, 255, 255, 0.98)',
                borderColor: '#ffc107',
                borderWidth: 3,
                padding: 15,
                textStyle: { color: '#333', fontSize: 14 },
                formatter: function(params) {
                    const realIdx = top5Data.length - 1 - params.dataIndex;
                    const cliente = top5Data[realIdx];
                    const nombreCompleto = cliente.nombres + ' ' + cliente.apellidos;
                    const posiciones = ['1er', '2do', '3er', '4to', '5to'];
                    return `<div style="text-align: center;">
                        <div style="font-size: 28px; margin-bottom: 8px;">${medals[realIdx]}</div>
                        <div style="font-size: 16px; font-weight: bold; color: #1A6BA8; margin-bottom: 5px;">${posiciones[realIdx]} Lugar</div>
                        <div style="font-size: 14px; color: #555; margin-bottom: 10px;">${nombreCompleto}</div>
                        <div style="font-size: 22px; font-weight: bold; color: #000000;">
                            ${parseInt(cliente.total).toLocaleString('es-PE')} pts
                        </div>
                    </div>`;
                }
            },
            grid: {
                left: mobile ? '3%' : '3%',
                right: mobile ? '3%' : '3%',
                top: mobile ? '8%' : '5%',
                bottom: mobile ? '3%' : '5%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                max: maxValue * 1.15,
                axisLine: { show: false },
                axisTick: { show: false },
                axisLabel: { show: false },
                splitLine: { show: false }
            },
            yAxis: {
                type: 'category',
                data: nombresDisplay.slice().reverse(),
                inverse: false,
                axisLine: { show: false },
                axisTick: { show: false },
                axisLabel: {
                    show: true,
                    fontSize: mobile ? 13 : 15,
                    fontWeight: '600',
                    color: '#333',
                    width: mobile ? 100 : 200,
                    overflow: 'truncate'
                }
            },
            series: [{
                name: 'Puntos',
                type: 'bar',
                data: top5Data.map((d, i) => ({
                    value: parseInt(d.total),
                    itemStyle: {
                        color: new echarts.graphic.LinearGradient(0, 0, 1, 0, [
                            { offset: 0, color: gradients[i][0] },
                            { offset: 1, color: gradients[i][1] }
                        ]),
                        borderRadius: [0, 15, 15, 0],
                        shadowColor: 'rgba(0, 0, 0, 0.15)',
                        shadowBlur: mobile ? 4 : 8,
                        shadowOffsetX: 2,
                        shadowOffsetY: 2
                    }
                })).reverse(),
                barWidth: mobile ? '50%' : '60%',
                label: {
                    show: true,
                    position: mobile ? 'insideRight' : 'insideRight',
                    distance: mobile ? 5 : 8,
                    fontSize: mobile ? 11 : 14,
                    fontWeight: 'bold',
                    color: '#333',
                    formatter: function(params) {
                        return params.value.toLocaleString('es-PE') + ' pts';
                    }
                },
                emphasis: {
                    itemStyle: {
                        shadowBlur: 15,
                        shadowColor: 'rgba(0, 0, 0, 0.3)'
                    }
                },
                animationDelay: function(idx) {
                    return idx * 200;
                }
            }],
            animationEasing: 'elasticOut',
            animationDuration: 1500
        };
    }

    // Inicializar con las opciones adecuadas
    chartTop5.setOption(getChartOption());

    // Variable para detectar cambio de modo
    let wasMobile = isMobile();

    // Responsive - actualizar opciones cuando cambia el tamaño
    $(window).on('resize', function() {
        const nowMobile = isMobile();
        // Solo actualizar opciones si cambió entre móvil y desktop
        if (nowMobile !== wasMobile) {
            chartTop5.setOption(getChartOption(), true);
            wasMobile = nowMobile;
        }
        chartTop5.resize();
    });
});
</script>
<?= $this->endSection() ?>

