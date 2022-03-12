<script>

    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            placement: 'bottom',
            trigger: 'hover'
        });
});

<?php if($_SESSION['userLoggedIn']){ ?>

    $('.favourite').click(function () {
        var target = $(this).attr('data-target');
        $('#'+target).toggleClass("far fa-heart fa-lg");
        $('#'+target).toggleClass("fas fa-heart fa-lg");
});

    $('.own').click(function () {
        var target = $(this).attr('data-target');
        $('#'+target).toggleClass("fas fa-plus fa-lg");
        $('#'+target).toggleClass("fas fa-check fa-lg");
});

    $('.join').click(function () {
        var target = $(this).attr('data-target');
        $('#'+target).toggleClass("fas fa-user-plus fa-lg");
        $('#'+target).toggleClass("fas fa-users fa-lg");
});

    $('.report').click(function () {
        var target = $(this).attr('data-target');
        $('#'+target).toggleClass("far fa-flag fa-lg");
        $('#'+target).toggleClass("fas fa-flag fa-lg");
});

<?php } ?>

</script>
