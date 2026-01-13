$(function () {

    const baseUrl = BASE_URL;


    if (typeof echarts === 'undefined') {
        alert('ECharts no está cargado');
        return;
    }

    // === PUNTOS POR DÍA ===
    const chartPuntos = echarts.init(document.getElementById('chartPuntos'));

    chartPuntos.setOption({
        title: { text: 'Puntos generados por día' },
        tooltip: {
            trigger: 'axis',
            formatter: function(params) {
                let fecha = params[0].name;
                let puntos = params[0].value;
                return `<div style="padding: 5px;">
                          <b style="color: #28a745;">📅 ${fecha}</b><br/>
                          <span style="font-size: 14px;">Puntos generados: <b>${puntos.toLocaleString('es-PE')}</b></span><br/>
                          <small style="color: #666;">Click para ver detalles</small>
                        </div>`;
            }
        },
        xAxis: { type: 'category', data: [] },
        yAxis: { type: 'value' },
        series: [{
            name: 'Puntos',
            type: 'line',
            smooth: true,
            data: []
        }]
    });

    // Usar la función de recarga para mantener consistencia
    cargarPuntosPorDia();

    chartPuntos.on('click', function (params) {
        const fecha = params.name;

        window.location.href = baseUrl + 'compras?fecha=' + fecha;
    });

    // === COMPRAS POR DÍA ===
    const chartCompras = echarts.init(document.getElementById('chartCompras'));

    chartCompras.setOption({
        title: { text: 'Compras por día' },
        tooltip: {
            trigger: 'axis',
            formatter: function(params) {
                let fecha = params[0].name;
                let compras = params[0].value;
                return `<div style="padding: 5px;">
                          <b style="color: #007bff;">📅 ${fecha}</b><br/>
                          <span style="font-size: 14px;">Total compras: <b>${compras}</b></span><br/>
                          <small style="color: #666;">Click para filtrar esta fecha</small>
                        </div>`;
            }
        },
        xAxis: { type: 'category', data: [] },
        yAxis: { type: 'value' },
        series: [{
            name: 'Compras',
            type: 'bar',
            data: []
        }]
    });

    // Usar la función de recarga para mantener consistencia
    cargarComprasPorDia();

    chartCompras.on('click', function (params) {
        const fecha = params.name;

        window.location.href =
            baseUrl + 'compras?fecha=' + fecha;
    });


    // === TOP 5 CLIENTES ===
    const chartTop = echarts.init(document.getElementById('chartTopClientes'));
    let clientesData = [];

    chartTop.setOption({
        title: {
            text: 'Top 5 clientes por puntos',
            textStyle: {
                fontSize: 18,
                fontWeight: 'bold'
            }
        },
        tooltip: {
            trigger: 'axis',
            formatter: function(params) {
                let cliente = params[0].name;
                let puntos = params[0].value;
                return `<div style="padding: 5px;">
                          <b style="color: #ffc107;">👤 ${cliente}</b><br/>
                          <span style="font-size: 14px;">Puntos acumulados: <b>${puntos.toLocaleString('es-PE')}</b></span><br/>
                          <small style="color: #666;">Click para ver historial</small>
                        </div>`;
            }
        },
        grid: {
            left: '3%',
            right: '10%',
            containLabel: true
        },
        xAxis: { type: 'value' },
        yAxis: {
            type: 'category',
            data: [],
            axisLabel: {
                fontSize: 13,
                fontWeight: 'bold',
                color: '#333'
            }
        },
        series: [{
            type: 'bar',
            data: [],
            label: {
                show: true,
                position: 'insideRight',
                formatter: '{c}',
                fontSize: 14,
                fontWeight: 'bold',
                color: '#fff'
            },
            itemStyle: {
                color: '#5470c6'
            }
        }]
    });

    $.get('dashboard/top-clientes', function (data) {
        clientesData = data;
        // Invertir el orden para que el mayor quede arriba
        const reversed = [...data].reverse();
        chartTop.setOption({
            yAxis: { data: reversed.map(d => d.cliente) },
            series: [{ data: reversed.map(d => parseInt(d.total)) }]
        });
    });

    chartTop.on('click', function (params) {
        // Como el array está invertido, calculamos el índice correcto
        const reversedIndex = clientesData.length - 1 - params.dataIndex;
        const cliente = clientesData[reversedIndex];

        if (!cliente || !cliente.id) {
            console.error('Cliente sin ID');
            return;
        }

        window.location.href = baseUrl + 'clientes/' + cliente.id + '/puntos';
    });


    // refrescar gráficos dinámicamente
    function cargarComprasPorDia(inicio = '', fin = '') {
        const tipo = $('#tipoAgrupacion').val();
        const endpoint = tipo === 'mes' ? 'dashboard/compras-por-mes' : 'dashboard/compras-por-dia';

        $.get(endpoint, { inicio, fin }, function (data) {
            chartCompras.setOption({
                xAxis: { data: data.map(d => d.fecha) },
                series: [{ data: data.map(d => d.total) }]
            });
        });
    }

    function cargarPuntosPorDia(inicio = '', fin = '') {
        const tipo = $('#tipoAgrupacion').val();
        const endpoint = tipo === 'mes' ? 'dashboard/puntos-por-mes' : 'dashboard/puntos-por-dia';

        $.get(endpoint, { inicio, fin }, function (data) {
            chartPuntos.setOption({
                xAxis: { data: data.map(d => d.fecha) },
                series: [{ data: data.map(d => d.total) }]
            });
        });
    }

    function cargarTopClientes(inicio = '', fin = '') {
        $.get('dashboard/top-clientes', { inicio, fin }, function (data) {
            clientesData = data;
            // Invertir el orden para que el mayor quede arriba
            const reversed = [...data].reverse();
            chartTop.setOption({
                yAxis: { data: reversed.map(d => d.cliente) },
                series: [{ data: reversed.map(d => parseInt(d.total)) }]
            });
        });
    }


    $('#btnFiltrar').on('click', function () {
        const inicio = $('#fechaInicio').val();
        const fin = $('#fechaFin').val();

        if (!inicio || !fin) {
            alert('Selecciona fecha inicio y fin');
            return;
        }

        cargarComprasPorDia(inicio, fin);
        cargarPuntosPorDia(inicio, fin);
        cargarTopClientes(inicio, fin);

        // Mostrar indicador de filtro activo
        $('#filtroActivo').show();

        // Formatear fechas a DD/MM/YYYY para mostrar al usuario
        const formatearFechaLocal = (fecha) => {
            const partes = fecha.split('-');
            if (partes.length === 3) {
                return `${partes[2]}/${partes[1]}/${partes[0]}`;
            }
            return fecha;
        };

        $('#rangoFechas').text(` del ${formatearFechaLocal(inicio)} al ${formatearFechaLocal(fin)}`);
        $('#btnLimpiarFiltros').show();
    });

    $('#btnLimpiarFiltros').on('click', function () {
        // Limpiar campos de fecha
        $('#fechaInicio').val('');
        $('#fechaFin').val('');

        // Resetear selector a "Por Día"
        $('#tipoAgrupacion').val('dia');

        // Actualizar títulos de gráficos
        chartPuntos.setOption({
            title: { text: 'Puntos generados por día' }
        });

        chartCompras.setOption({
            title: { text: 'Compras por día' }
        });

        // Ocultar indicadores
        $('#filtroActivo').hide();
        $('#btnLimpiarFiltros').hide();

        // Recargar gráficos sin filtros
        cargarComprasPorDia();
        cargarPuntosPorDia();
        cargarTopClientes();
    });

    $('#tipoAgrupacion').on('change', function () {
        const inicio = $('#fechaInicio').val();
        const fin = $('#fechaFin').val();

        // Actualizar título del gráfico según la vista
        const tipo = $(this).val();
        const tituloTiempo = tipo === 'mes' ? 'por mes' : 'por día';

        chartPuntos.setOption({
            title: { text: `Puntos generados ${tituloTiempo}` }
        });

        chartCompras.setOption({
            title: { text: `Compras ${tituloTiempo}` }
        });

        // Mostrar botón limpiar cuando se cambie a "Por Mes"
        if (tipo === 'mes') {
            $('#btnLimpiarFiltros').show();
        }

        // Recargar datos con la nueva agrupación
        if (inicio && fin) {
            cargarPuntosPorDia(inicio, fin);
            cargarComprasPorDia(inicio, fin);
        } else {
            cargarPuntosPorDia();
            cargarComprasPorDia();
        }
    });


    $('#exportPuntos').on('click', function () {
        const url = chartPuntos.getDataURL({
            type: 'png',
            pixelRatio: 2,
            backgroundColor: '#fff'
        });

        const a = document.createElement('a');
        a.href = url;
        a.download = 'puntos-por-dia.png';
        a.click();
    });

    $('#exportCompras').on('click', function () {
        const url = chartCompras.getDataURL({
            type: 'png',
            pixelRatio: 2,
            backgroundColor: '#fff'
        });

        const a = document.createElement('a');
        a.href = url;
        a.download = 'compras-por-dia.png';
        a.click();
    });


    $('#exportTopClientes').on('click', function () {
        const url = chartTop.getDataURL({
            type: 'png',
            pixelRatio: 2,
            backgroundColor: '#fff'
        });

        const a = document.createElement('a');
        a.href = url;
        a.download = 'top-clientes-por-dia.png';
        a.click();
    });

    // =====================================================
    // NUEVOS GRÁFICOS
    // =====================================================

    // Colores personalizados para gráficos
    const coloresPastel = ['#5470c6', '#91cc75', '#fac858', '#ee6666', '#73c0de', '#3ba272', '#fc8452', '#9a60b4'];
    const coloresDona = ['#28a745', '#dc3545', '#17a2b8'];

    // === CARGAR KPIs ADICIONALES ===
    function cargarKPIs() {
        $.get('dashboard/kpis-resumen', function (data) {
            $('#kpiTotalCanjes').text(data.total_canjes.toLocaleString('es-PE'));
            $('#kpiPuntosCanjeados').text(data.puntos_canjeados.toLocaleString('es-PE'));
            $('#kpiMontoTotal').text('S/ ' + data.monto_total_compras.toLocaleString('es-PE', { minimumFractionDigits: 2 }));
            $('#kpiPromedioCliente').text(data.promedio_puntos_cliente.toLocaleString('es-PE'));
        });
    }
    cargarKPIs();

    // === GRÁFICO DE PASTEL: DISTRIBUCIÓN DE TIPOS ===
    const chartDistribucion = echarts.init(document.getElementById('chartDistribucionTipos'));

    chartDistribucion.setOption({
        tooltip: {
            trigger: 'item',
            formatter: function(params) {
                return `<div style="padding: 5px;">
                          <b style="color: ${params.color};">${params.name}</b><br/>
                          <span>Cantidad: <b>${params.data.cantidad.toLocaleString('es-PE')}</b></span><br/>
                          <span>Puntos: <b>${parseInt(params.data.total_puntos).toLocaleString('es-PE')}</b></span><br/>
                          <span>Porcentaje: <b>${params.percent}%</b></span>
                        </div>`;
            }
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            top: 'center'
        },
        series: [{
            name: 'Tipos de Movimiento',
            type: 'pie',
            radius: ['0%', '70%'],
            center: ['60%', '50%'],
            data: [],
            emphasis: {
                itemStyle: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            },
            label: {
                formatter: '{b}: {d}%'
            }
        }]
    });

    function cargarDistribucionTipos(inicio = '', fin = '') {
        $.get('dashboard/distribucion-tipos', { inicio, fin }, function (data) {
            chartDistribucion.setOption({
                series: [{
                    data: data.map((d, i) => ({
                        value: parseInt(d.cantidad),
                        name: d.nombre,
                        cantidad: parseInt(d.cantidad),
                        total_puntos: d.total_puntos,
                        itemStyle: { color: coloresPastel[i % coloresPastel.length] }
                    }))
                }]
            });
        });
    }
    cargarDistribucionTipos();

    // === GRÁFICO DE DONA: COMPARATIVA PUNTOS ===
    const chartComparativa = echarts.init(document.getElementById('chartComparativaPuntos'));

    chartComparativa.setOption({
        tooltip: {
            trigger: 'item',
            formatter: '{b}: {c} pts ({d}%)'
        },
        legend: {
            orient: 'horizontal',
            bottom: '5%',
            left: 'center'
        },
        series: [{
            name: 'Balance de Puntos',
            type: 'pie',
            radius: ['45%', '75%'],
            center: ['50%', '45%'],
            avoidLabelOverlap: false,
            itemStyle: {
                borderRadius: 10,
                borderColor: '#fff',
                borderWidth: 2
            },
            label: {
                show: true,
                formatter: '{b}\n{c} pts'
            },
            emphasis: {
                label: {
                    show: true,
                    fontSize: 16,
                    fontWeight: 'bold'
                }
            },
            data: []
        }]
    });

    function cargarComparativaPuntos(inicio = '', fin = '') {
        $.get('dashboard/comparativa-puntos', { inicio, fin }, function (data) {
            chartComparativa.setOption({
                series: [{
                    data: data.map((d, i) => ({
                        value: d.valor,
                        name: d.nombre,
                        itemStyle: { color: coloresDona[i] }
                    }))
                }]
            });
        });
    }
    cargarComparativaPuntos();

    // === GRÁFICO DE CANJES ===
    const chartCanjes = echarts.init(document.getElementById('chartCanjes'));

    chartCanjes.setOption({
        title: { text: 'Canjes realizados por día' },
        tooltip: {
            trigger: 'axis',
            axisPointer: { type: 'cross' },
            formatter: function(params) {
                let html = `<b>${params[0].name}</b><br/>`;
                params.forEach(p => {
                    html += `${p.marker} ${p.seriesName}: <b>${p.value.toLocaleString('es-PE')}</b><br/>`;
                });
                return html;
            }
        },
        legend: {
            data: ['Cantidad', 'Puntos Canjeados'],
            top: 30
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: { type: 'category', data: [] },
        yAxis: [
            { type: 'value', name: 'Cantidad', position: 'left' },
            { type: 'value', name: 'Puntos', position: 'right' }
        ],
        series: [
            {
                name: 'Cantidad',
                type: 'bar',
                data: [],
                itemStyle: { color: '#e83e8c' }
            },
            {
                name: 'Puntos Canjeados',
                type: 'line',
                yAxisIndex: 1,
                smooth: true,
                data: [],
                itemStyle: { color: '#6f42c1' },
                areaStyle: { color: 'rgba(111, 66, 193, 0.2)' }
            }
        ]
    });

    function cargarCanjes(inicio = '', fin = '') {
        const tipo = $('#tipoAgrupacion').val();
        const endpoint = tipo === 'mes' ? 'dashboard/canjes-por-mes' : 'dashboard/canjes-por-dia';

        $.get(endpoint, { inicio, fin }, function (data) {
            chartCanjes.setOption({
                title: { text: `Canjes realizados por ${tipo === 'mes' ? 'mes' : 'día'}` },
                xAxis: { data: data.map(d => d.fecha) },
                series: [
                    { data: data.map(d => parseInt(d.cantidad)) },
                    { data: data.map(d => parseInt(d.total_puntos || 0)) }
                ]
            });
        });
    }
    cargarCanjes();

    // === GRÁFICO DE MONTOS DE COMPRAS ===
    const chartMontoCompras = echarts.init(document.getElementById('chartMontoCompras'));

    chartMontoCompras.setOption({
        title: { text: 'Montos de compras por día' },
        tooltip: {
            trigger: 'axis',
            formatter: function(params) {
                let fecha = params[0].name;
                let monto = params[0].value;
                let cantidad = params[1] ? params[1].value : 0;
                return `<div style="padding: 5px;">
                          <b style="color: #20c997;">📅 ${fecha}</b><br/>
                          <span>Monto total: <b>S/ ${monto.toLocaleString('es-PE', { minimumFractionDigits: 2 })}</b></span><br/>
                          <span>Cantidad compras: <b>${cantidad}</b></span>
                        </div>`;
            }
        },
        legend: {
            data: ['Monto (S/)', 'Cantidad'],
            top: 30
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: { type: 'category', data: [] },
        yAxis: [
            { type: 'value', name: 'Monto (S/)', position: 'left' },
            { type: 'value', name: 'Cantidad', position: 'right' }
        ],
        series: [
            {
                name: 'Monto (S/)',
                type: 'bar',
                data: [],
                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: '#20c997' },
                        { offset: 1, color: '#17a2b8' }
                    ])
                }
            },
            {
                name: 'Cantidad',
                type: 'line',
                yAxisIndex: 1,
                smooth: true,
                data: [],
                itemStyle: { color: '#ffc107' },
                symbol: 'circle',
                symbolSize: 8
            }
        ]
    });

    function cargarMontoCompras(inicio = '', fin = '') {
        const tipo = $('#tipoAgrupacion').val();
        const endpoint = tipo === 'mes' ? 'dashboard/monto-compras-por-mes' : 'dashboard/monto-compras-por-dia';

        $.get(endpoint, { inicio, fin }, function (data) {
            chartMontoCompras.setOption({
                title: { text: `Montos de compras por ${tipo === 'mes' ? 'mes' : 'día'}` },
                xAxis: { data: data.map(d => d.fecha) },
                series: [
                    { data: data.map(d => parseFloat(d.total_monto || 0)) },
                    { data: data.map(d => parseInt(d.cantidad || 0)) }
                ]
            });
        });
    }
    cargarMontoCompras();

    // === GRÁFICO POLAR: ACTIVIDAD POR HORA ===
    const chartActividad = echarts.init(document.getElementById('chartActividadHora'));

    const horasLabels = [];
    for (let i = 0; i < 24; i++) {
        horasLabels.push(i.toString().padStart(2, '0') + ':00');
    }

    chartActividad.setOption({
        tooltip: {
            trigger: 'axis',
            formatter: function(params) {
                let html = `<b>${params[0].name}</b><br/>`;
                params.forEach(p => {
                    html += `${p.marker} ${p.seriesName}: <b>${p.value}</b><br/>`;
                });
                return html;
            }
        },
        legend: {
            data: ['Compras', 'Canjes'],
            bottom: 0
        },
        radar: {
            indicator: horasLabels.map(h => ({ name: h, max: 50 })),
            center: ['50%', '50%'],
            radius: '65%'
        },
        series: [{
            type: 'radar',
            data: [
                {
                    value: [],
                    name: 'Compras',
                    itemStyle: { color: '#5470c6' },
                    areaStyle: { color: 'rgba(84, 112, 198, 0.3)' }
                },
                {
                    value: [],
                    name: 'Canjes',
                    itemStyle: { color: '#ee6666' },
                    areaStyle: { color: 'rgba(238, 102, 102, 0.3)' }
                }
            ]
        }]
    });

    function cargarActividadPorHora(inicio = '', fin = '') {
        $.get('dashboard/actividad-por-hora', { inicio, fin }, function (data) {
            // Calcular el máximo para el indicador
            const maxCompras = Math.max(...data.compras, 1);
            const maxCanjes = Math.max(...data.canjes, 1);
            const maxValue = Math.max(maxCompras, maxCanjes) + 5;

            chartActividad.setOption({
                radar: {
                    indicator: horasLabels.map(h => ({ name: h, max: maxValue }))
                },
                series: [{
                    data: [
                        { value: data.compras, name: 'Compras' },
                        { value: data.canjes, name: 'Canjes' }
                    ]
                }]
            });
        });
    }
    cargarActividadPorHora();

    // === GRÁFICO DE BARRAS: PUNTOS POR CAMPAÑA ===
    const chartCampanias = echarts.init(document.getElementById('chartCampanias'));

    chartCampanias.setOption({
        tooltip: {
            trigger: 'axis',
            axisPointer: { type: 'shadow' },
            formatter: function(params) {
                let html = `<b>${params[0].name}</b><br/>`;
                params.forEach(p => {
                    html += `${p.marker} ${p.seriesName}: <b>${p.value.toLocaleString('es-PE')}</b> pts<br/>`;
                });
                return html;
            }
        },
        legend: {
            data: ['Disponibles', 'Canjeados'],
            bottom: 0
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '15%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            data: [],
            axisLabel: {
                rotate: 30,
                interval: 0
            }
        },
        yAxis: { type: 'value', name: 'Puntos' },
        series: [
            {
                name: 'Disponibles',
                type: 'bar',
                stack: 'total',
                data: [],
                itemStyle: { color: '#28a745' }
            },
            {
                name: 'Canjeados',
                type: 'bar',
                stack: 'total',
                data: [],
                itemStyle: { color: '#dc3545' }
            }
        ]
    });

    function cargarEstadisticasCampanias() {
        $.get('dashboard/estadisticas-campanias', function (data) {
            if (data.puntos_por_campania && data.puntos_por_campania.length > 0) {
                chartCampanias.setOption({
                    xAxis: { data: data.puntos_por_campania.map(c => c.nombre) },
                    series: [
                        { data: data.puntos_por_campania.map(c => parseInt(c.disponibles || 0)) },
                        { data: data.puntos_por_campania.map(c => parseInt(c.canjeados || 0)) }
                    ]
                });
            }
        });
    }
    cargarEstadisticasCampanias();

    // === EXPORTAR NUEVOS GRÁFICOS ===
    $('#exportCanjes').on('click', function () {
        const url = chartCanjes.getDataURL({ type: 'png', pixelRatio: 2, backgroundColor: '#fff' });
        const a = document.createElement('a');
        a.href = url;
        a.download = 'canjes-realizados.png';
        a.click();
    });

    $('#exportMontoCompras').on('click', function () {
        const url = chartMontoCompras.getDataURL({ type: 'png', pixelRatio: 2, backgroundColor: '#fff' });
        const a = document.createElement('a');
        a.href = url;
        a.download = 'montos-compras.png';
        a.click();
    });

    // === ACTUALIZAR FILTROS PARA INCLUIR NUEVOS GRÁFICOS ===
    const originalFiltrar = $('#btnFiltrar').off('click').on('click', function () {
        const inicio = $('#fechaInicio').val();
        const fin = $('#fechaFin').val();

        if (!inicio || !fin) {
            alert('Selecciona fecha inicio y fin');
            return;
        }

        // Gráficos originales
        cargarComprasPorDia(inicio, fin);
        cargarPuntosPorDia(inicio, fin);
        cargarTopClientes(inicio, fin);

        // Nuevos gráficos
        cargarDistribucionTipos(inicio, fin);
        cargarComparativaPuntos(inicio, fin);
        cargarCanjes(inicio, fin);
        cargarMontoCompras(inicio, fin);
        cargarActividadPorHora(inicio, fin);

        // Mostrar indicador de filtro activo
        $('#filtroActivo').show();

        const formatearFechaLocal = (fecha) => {
            const partes = fecha.split('-');
            if (partes.length === 3) {
                return `${partes[2]}/${partes[1]}/${partes[0]}`;
            }
            return fecha;
        };

        $('#rangoFechas').text(` del ${formatearFechaLocal(inicio)} al ${formatearFechaLocal(fin)}`);
        $('#btnLimpiarFiltros').show();
    });

    // Actualizar limpiar filtros
    $('#btnLimpiarFiltros').off('click').on('click', function () {
        $('#fechaInicio').val('');
        $('#fechaFin').val('');
        $('#tipoAgrupacion').val('dia');

        chartPuntos.setOption({ title: { text: 'Puntos generados por día' } });
        chartCompras.setOption({ title: { text: 'Compras por día' } });

        $('#filtroActivo').hide();
        $('#btnLimpiarFiltros').hide();

        // Recargar todos los gráficos
        cargarComprasPorDia();
        cargarPuntosPorDia();
        cargarTopClientes();
        cargarDistribucionTipos();
        cargarComparativaPuntos();
        cargarCanjes();
        cargarMontoCompras();
        cargarActividadPorHora();
    });

    // Actualizar cambio de agrupación
    $('#tipoAgrupacion').off('change').on('change', function () {
        const inicio = $('#fechaInicio').val();
        const fin = $('#fechaFin').val();
        const tipo = $(this).val();
        const tituloTiempo = tipo === 'mes' ? 'por mes' : 'por día';

        chartPuntos.setOption({ title: { text: `Puntos generados ${tituloTiempo}` } });
        chartCompras.setOption({ title: { text: `Compras ${tituloTiempo}` } });

        if (tipo === 'mes') {
            $('#btnLimpiarFiltros').show();
        }

        if (inicio && fin) {
            cargarPuntosPorDia(inicio, fin);
            cargarComprasPorDia(inicio, fin);
            cargarCanjes(inicio, fin);
            cargarMontoCompras(inicio, fin);
        } else {
            cargarPuntosPorDia();
            cargarComprasPorDia();
            cargarCanjes();
            cargarMontoCompras();
        }
    });

    // === RESPONSIVE: REDIMENSIONAR GRÁFICOS ===
    window.addEventListener('resize', function () {
        chartPuntos.resize();
        chartCompras.resize();
        chartTop.resize();
        chartDistribucion.resize();
        chartComparativa.resize();
        chartCanjes.resize();
        chartMontoCompras.resize();
        chartActividad.resize();
        chartCampanias.resize();
    });

});

