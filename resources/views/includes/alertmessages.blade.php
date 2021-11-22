

<script src="{{ asset('/assets/js/sweetalert2.all.min.js') }}"></script>

@if (session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{!! session('success') !!}',
        icon: 'success',
        confirmButtonText: 'Ok'
    })
</script>
@endif


@if (session('fail'))
<script>
    Swal.fire({
        title: 'Error!',
        text: '{!! session('fail') !!}',
        icon: 'error',
        confirmButtonText: 'Ok'
    })
</script>
@endif


@if ($errors->any())
<script>
    Swal.fire({
        title: 'Error!',
        text: '{!! $errors->all() !!}',
        icon: 'error',
        confirmButtonText: 'Ok'
    })
</script>
@endif



