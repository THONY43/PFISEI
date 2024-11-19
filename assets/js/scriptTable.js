$(document).ready(function() {
    $('#exampl').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        },
        info: false // Desactivar info rmación de resultados mostrados
    });

    // Buscar por RollId
    $('#search-status').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#exampl tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});