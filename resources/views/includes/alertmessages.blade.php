{{-- @if (session('success'))
    <div class="alert alert-success fade in">
        <button type="button" class="close close-sm" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Success!</strong> {{ session('success') }}
    </div>
@endif




@if ($errors->any())
    <div class="alert alert-block alert-danger fade in">
        <button type="button" class="close close-sm" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Error!</strong> Change a few things up and try submitting again.

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}


<script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

@if (session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{!! session('success')[0] !!}',
        icon: 'success',
        confirmButtonText: 'Ok'
    })
</script>
@endif


@if (session('fail'))
<script>
    Swal.fire({
        title: 'Error!',
        text: '{!! session('fail')[0] !!}',
        icon: 'error',
        confirmButtonText: 'Ok'
    })
</script>
@endif


@if ($errors->any())
<script>
    Swal.fire({
        title: 'Error!',
        text: '{!! $errors->all()[0] !!}',
        icon: 'error',
        confirmButtonText: 'Ok'
    })
</script>
@endif



