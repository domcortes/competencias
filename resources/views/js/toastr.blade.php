@if(session('success'))
    <script>
        toastr.success('{{ session('success') }}')
    </script>
@endif

@if(session('error'))
    <script>
        toastr.error('{{ session('error') }}')
    </script>
@endif

@if(session('warning'))
    <script>
        toastr.error('{{ session('warning') }}')
    </script>
@endif

