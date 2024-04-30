<script src="{{ asset("admin-assets/plugins/jquery/jquery.min.js") }}"></script>
<script src="{{ asset("admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<script src="{{ asset("admin-assets/js/adminlte.min.js") }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset("admin-assets/js/demo.js") }}"></script>
<script>
    $(document).ready(function() {
        $('#date_id').change(function() {
            const selectedValue = $(this).val();
            $.ajax({
                url: "{{ route('temp-date') }}",
                type: "GET",
                data: {
                    date_id: selectedValue
                },
                success: function(data) {
                    window.location.href = '?date=' + encodeURIComponent(selectedValue);
                },
            })
        });
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.js"></script>
