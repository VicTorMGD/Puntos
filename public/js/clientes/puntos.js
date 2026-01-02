$(function () {
    if (!$('#tablaPuntos').length) return;
  
    $('#tablaPuntos').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
      },
      order: [[0, 'desc']],
      pageLength: 10,
      responsive: true
    });
  });
  