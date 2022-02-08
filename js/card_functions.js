$(document).ready(function () {
    $('[data-toggle="popover"]').popover({
        placement: 'bottom',
        trigger: 'hover'
    });
});

$('#favouriteIcon').click(function () {
    $(this).toggleClass("far fa-heart fa-lg");
    $(this).toggleClass("fas fa-heart fa-lg");
});

$('#ownIcon').click(function () {
    $(this).toggleClass("fas fa-plus fa-lg");
    $(this).toggleClass("fas fa-check fa-lg");
});

$('#joinIcon').click(function () {
    $(this).toggleClass("fas fa-user-plus fa-lg");
    $(this).toggleClass("fas fa-users fa-lg");
});