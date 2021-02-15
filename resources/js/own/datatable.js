$(function tablau() {

  $('#tb-tabla').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "order": [],
    "info": true,
    "autoWidth": false,
    "language": {
        "lengthMenu": "Mostrar: _MENU_ Registros.",
        "zeroRecords": "No se encontraron resultados en su busqueda",
        "searchPlaceholder": "Buscar",
        "info": "Registros del _START_ al _END_ de un total de  _TOTAL_.",
        "infoEmpty": "No existen registros",
        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
        "search": "Buscar:",
        "paginate": {
            "first":    "Primero",
            "last":    "Último",
            "next":    "Siguiente",
            "previous": "Anterior"
        }
      }
  });


});
