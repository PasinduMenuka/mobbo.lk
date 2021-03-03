search();

function search() {

    $(document).ready(function () {
        $('#search-text').val($("#search-drop").val());
        $(document).on('change', '#search-drop', function () {
            $('#search-text').val($("#search-drop").val());
        });
    })

}
