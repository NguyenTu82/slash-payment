<!-- jQuery -->
<script src="{{ asset('dashboard/themes/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/themes/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('dashboard/themes/plugins/toastr/toastr.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('dashboard/themes/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('dashboard/themes/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dashboard/themes/dist/js/adminlte.js') }}"></script>
<!-- sbadmin2 -->
<script src="{{ asset('dashboard/themes/dist_sbadmin2/js/sb-admin-2.js') }}"></script>


<!--merchant_dashboard-->
<script src="{{ asset('dashboard/main_html/js/chart.js') }}"></script>
<script src="{{ asset('dashboard/themes/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dashboard/libs/qrcode/jquery-qrcode.js') }}"></script>
<script src="{{ asset('dashboard/libs/export_csv/table2csv.min.js') }}"></script>
<script src="{{ asset('dashboard/libs/moment/moment-with-locales.js') }}"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="{{ asset('dashboard/libs/qrcode/jquery-qrcode.js') }}"></script>
<script src="{{ asset('dashboard/main_html/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('dashboard/main_html/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('dashboard/libs/pdf/pdf.min.js') }}"></script>

<script src="{{ asset('js/common.js') }}"></script>

<script>
    $(function () {
        $.widget.bridge('uibutton', $.ui.button)
        $('select').selectpicker({noneSelectedText: ''});
    });

    const PROCESS_FAILED_MSG_COMMON = "{{__('common.error.process_failed')}}";

    @if (session()->has('success'))
        $(function () {
            $('#result-modal').modal('show');
            $('.modal-backdrop').show();
        });
    @endif

    function parseValidateMessage(errors) {
        let messages = [];
        Object.values(errors).forEach(function (e) {
            messages.push('<li>' + e.join('</li><li>') + '</li>')
        });
        return messages.join('');
    }

    $(function () {
        // toastr option
        toastr.options.escapeHtml = false;
        toastr.options.closeButton = false;
        toastr.options.closeDuration = 0;
        toastr.options.extendedTimeOut = 500;
        toastr.options.timeOut = 4000;
        toastr.options.tapToDismiss = false;
        toastr.options.positionClass = 'toast-top-center custom-toast';
        @if (session()->has('error'))
            toastr.error("{{session()->get('error')}}");
        @endif
    });
</script>
@stack('script')
