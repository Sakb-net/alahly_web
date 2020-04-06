<script type="text/javascript">
    $(document).ready(function () {
        $("#access-all").change(function () {
//            var type_cato = $("#all_access option:selected").val();
            var all_access = $('#access-all').is(':checked');
            if (all_access == 'true' || all_access == true) {
                $('.custom-checkbox').prop("checked", true);
            } else {
                $('.custom-checkbox').prop("checked", false);
            }
        });
        @foreach ($permission as $key_rol => $val_rol)
        $("#{{$val_rol->name}}").change(function () {
            var data_checked = $('#{{$val_rol->name}}').is(':checked');
            if (data_checked == 'true' || data_checked == true) {
                $('.{{$val_rol->name}}').prop("checked", true);
            } else {
                $('.{{$val_rol->name}}').prop("checked", false);
            }
        });
        @endforeach
    });
</script>