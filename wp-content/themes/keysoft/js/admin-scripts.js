jQuery(document).ready(function($) {
    $( "a:contains('import-demo-full-custom')" ).parent().remove();
    $('.import-demo-button').click(function() {
        $('.import-demo-button').removeClass('selected');
        $(this).addClass('selected');
        $('#import-link-value').val('http://keysoft-wp.keydesign-themes.com/import/' + $(this).attr('id'));
    });
});


