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
        title: { text: 'Top 5 clientes por puntos' },
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
        xAxis: { type: 'value' },
        yAxis: { type: 'category', data: [] },
        series: [{
            type: 'bar',
            data: []
        }]
    });

    $.get('dashboard/top-clientes', function (data) {
        clientesData = data;
        chartTop.setOption({
            yAxis: { data: data.map(d => d.cliente) },
            series: [{ data: data.map(d => d.total) }]
        });
    });

    chartTop.on('click', function (params) {
        const cliente = clientesData[params.dataIndex];

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
            chartTop.setOption({
                yAxis: { data: data.map(d => d.cliente) },
                series: [{ data: data.map(d => d.total) }]
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

});

