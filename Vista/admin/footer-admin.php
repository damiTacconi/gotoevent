<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>



<!-- Page level plugin JavaScript-->
<script src="/./admin/vendor/datatables/jquery.dataTables.js"></script>
<script src="/./admin/vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="/./admin/js/sb-admin.min.js"></script>

<!-- Demo scripts for this page-->
<script src="/./admin/js/demo/datatables-demo.js"></script>

<script type="text/javascript">
    $(function () {
        $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
            icons: {
                time: 'far fa-clock',
                date: 'fas fa-calendar-alt',
                up: 'fas fa-arrow-circle-up',
                down: 'fas fa-arrow-circle-down ',
                previous: 'fas fa-chevron-circle-left',
                next: 'fas fa-chevron-circle-right',
                today: 'far fa-calendar-check-o',
                clear: 'far fa-trash',
                close: 'far fa-times'
            } });

        /************/
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#fechapicker').datetimepicker({
            format: "YYYY-MM-DD"
        });
        $('#desdepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#hastapicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#hora_desde_picker').datetimepicker({
            format: 'LT'
        });
        $('#hora_hasta_picker').datetimepicker({
            format: 'LT',
            useCurrent: false
        });

        /************/
        $('#datetimepicker1').datetimepicker();
        $('#datetimepicker2').datetimepicker({
            useCurrent: false
        });
        $("#datetimepicker1").on("change.datetimepicker", function (e) {
            $('#datetimepicker2').datetimepicker('minDate', e.date);
        });
        $("#datetimepicker2").on("change.datetimepicker", function (e) {
            $('#datetimepicker1').datetimepicker('maxDate', e.date);
        });

        $("#hora_desde_picker").on("change.datetimepicker", function (e) {
            $('#hora_hasta_picker').datetimepicker('minDate', e.date);
        });
        $("#hora_hasta_picker").on("change.datetimepicker", function (e) {
            $('#hora_desde_picker').datetimepicker('maxDate', e.date);
        });
    });
</script>
</body>

</html>