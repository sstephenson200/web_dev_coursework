<script>

    $(document).ready(function () {
        $('#musicSortFilter').text($(".dropdown-menu li a[id='defaultMusicSort']").text());
    });

    $(".dropdown-menu li a").click(function(){

        $("#musicSortFilter:first-child").text($(this).text());
        $("#musicSortFilter:first-child").val($(this).text());

    });

</script>