<script type="text/javascript">
    $(document).ready(function () {
        $("#type_cost").change(function () {
            var type_cost = $("#type_cost option:selected").val();
            if(type_cost=="discount" || type_cost=='discount'){
                $('.allow_discount').removeClass("hide");
            }else{
                $('.allow_discount').addClass("hide");
            }
        });

    });
</script>
