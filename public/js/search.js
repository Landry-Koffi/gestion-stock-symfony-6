$(document).ready(function() {
    $('#search-all').on('keyup', function() {
        var searchText = $(this).val().toLowerCase();

        $('table tbody tr').filter(function() {
            var rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.indexOf(searchText) > -1);
        });
    });
});