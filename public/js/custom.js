

$('#inputGroupFile02').on('change', function () {
    const fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName.split('\\').pop());
})