<div class="alerts">
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <script> toastr.error('{{ $error }}'); </script>
        @endforeach
    @endif

    @if (session()->has('success'))
        <script> toastr.success('{{ session('success') }}'); </script>
    @endif

    @if (session()->has('error'))
            <script> toastr.error('{{ session('error') }}'); </script>
    @endif
</div>
