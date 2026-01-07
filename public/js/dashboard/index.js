$(function () {

    if (typeof echarts === 'undefined') {
        alert('ECharts no está cargado');
        return;
    }

    // === PUNTOS POR DÍA ===
    const chart = echarts.init(document.getElementById('chartPuntos'));

    chart.setOption({
        title: { text: 'Puntos generados por día' },
        tooltip: { trigger: 'axis' },
        xAxis: { type: 'category', data: [] },
        yAxis: { type: 'value' },
        series: [{
            name: 'Puntos',
            type: 'line',
            smooth: true,
            data: []
        }]
    });

    $.get('dashboard/puntos-por-dia', function (data) {
        chart.setOption({
            xAxis: { data: data.map(d => d.fecha) },
            series: [{ data: data.map(d => d.total) }]
        });
    });

    // === COMPRAS POR DÍA ===
    const chartCompras = echarts.init(document.getElementById('chartCompras'));

    chartCompras.setOption({
        title: { text: 'Compras por día' },
        tooltip: { trigger: 'axis' },
        xAxis: { type: 'category', data: [] },
        yAxis: { type: 'value' },
        series: [{
            name: 'Compras',
            type: 'bar',
            data: []
        }]
    });

    $.get('dashboard/compras-por-dia', function (data) {
        chartCompras.setOption({
            xAxis: { data: data.map(d => d.fecha) },
            series: [{ data: data.map(d => d.total) }]
        });
    });
});

