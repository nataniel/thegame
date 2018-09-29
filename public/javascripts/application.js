$(function () {

    $('form').submit(function () {
        $(this).find('button:submit').attr('disabled', true);
        return true;
    });

    // setTimeout(function() {
    //     $('#flash').fadeOut('slow');
    // }, 5000);

    $('[data-toggle="tooltip"]').tooltip();

    $('[data-toggle="tooltip-next"]').tooltip({
        title: function () { return $(this).next().html(); },
        html: true,
    });

    $('[data-toggle="tooltip-next"]').next().hide();

});