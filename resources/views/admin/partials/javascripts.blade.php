<script src="//code.jquery.com/jquery-1.11.3.min.js?v={{ env('ASSETS_VERSION_NUMBER') }}"></script>
<script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js?v={{ env('ASSETS_VERSION_NUMBER') }}"></script>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js?v={{ env('ASSETS_VERSION_NUMBER') }}"></script>
<!--<script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
<script src="//cdn.ckeditor.com/4.5.4/full/ckeditor.js"></script>-->
<script src="{{ url('quickadmin/js') }}/bootstrap.min.js?v={{ env('ASSETS_VERSION_NUMBER') }}"></script>
<script src="{{ url('quickadmin/js') }}/main.js?v={{ env('ASSETS_VERSION_NUMBER') }}"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>

/*$('.datepicker').datepicker({
 autoclose: true,
 dateFormat: "{{ config('quickadmin.date_format_jquery') }}"
 });
 
 $('.datetimepicker').datetimepicker({
 autoclose: true,
 dateFormat: "{{ config('quickadmin.date_format_jquery') }}",
 timeFormat: "{{ config('quickadmin.time_format_jquery') }}"
 });*/

$('#datatable').dataTable({
    "language": {
        "url": "{{ trans('admin/strings.datatable_url_language') }}"
    }
});


</script>
