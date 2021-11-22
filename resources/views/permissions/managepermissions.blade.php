@extends('layouts.app')

@section('content')

<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>



<!--body wrapper start-->
<div class="wrapper">

    @include('includes.alertmessages')

    <div class="card mt-2">
        <div class="card-header">
            <h3 class="text-center">Manage Permissions</h3>
        </div>
        <div class="card-body">

            {{-- @if (in_array("permission create", session('permissions'))) --}}
                <div class="row mb-2 ml-3 float-left">
                    <a href="#" data-toggle="modal" data-target="#create_modal">
                        <button id="editable-sample_new" class="btn btn-primary">
                            <i class="las la-plus mr-1"></i>
                            Add New Permission
                        </button>
                    </a>
                </div>
            {{-- @endif --}}

            <form action="{{route('managepermissions')}}" method="get">
                <div class="col-md-4 input-group mb-3 float-right">
                    @csrf
                    <input type="text" id="search" name="search"  value="{{request('search')}}" placeholder="Search..." class="form-control"/>
                    <div class="input-group-append">
                        <button class="input-group-text bg-primary text-white" id="basic-addon2"  type="submit">
                            <i class="las la-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive my-2">
                <table class="table table-centered mb-0">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Permission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $i =>  $permission)
                            <tr>
                                <td>{{ getPaginatedSerial($paginator, $i) }}</td>
                                <td>
                                    <div class="overflow-hidden">
                                        <p class="mb-0 font-weight-medium"><a href="javascript: void(0);">{{$permission->name}}</a></p>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-sm"  title="" data-original-title="Edit"  href="#" data-toggle="modal" data-target="#update_modal"
                                        data-id="{{$permission->id}}"
                                        data-name="{{$permission->name}}"
                                    >Edit</a>
                                    {!! Form::open(['method' => 'POST','route' => ['deletepermission', ['id'=>$permission->id]],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            @include('/includes/paginate')

        </div>
    </div>

</div>
<!--body wrapper end-->


{{-- create modal --}}
<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="permission_create_modal" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-center mx-auto text-white" id="permission_create_modal">Create Permission</h4>
            </div>
            <form action="{{ route('createpermissionsave') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label class="col-sm-4 col-form-label control-label">Name</label>
                            <div class="col-sm-8">
                                {{Form::text('name', '', ['class' => 'form-control', 'required' => 'required'])}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label class="col-sm-4 col-form-label control-label">Guard</label>
                            <div class="col-sm-8">
                                {{Form::text('guard_name', 'web', ['class' => 'form-control', 'required' => 'required', 'readonly'])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary float-right mr-1" data-dismiss="modal">Cancel</button>
                    <button data-toggle="modal" type="submit" class="btn btn-primary mr-2 float-right" id="formSubmit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



{{-- update modal --}}
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="permission_update_modal" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-center mx-auto text-white" id="permission_update_modal">Update Permission</h4>
            </div>
            <form action="{{ route('editpermissionsave') }}" method="post">
                @csrf

                <div class="modal-body">
                    {{Form::number('id', '', ['class' => 'id', 'required' => 'required', 'hidden'])}}

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label class="col-sm-4 col-form-label control-label">Name</label>
                            <div class="col-sm-8">
                                {{Form::text('name', '', ['class' => 'form-control name', 'required' => 'required'])}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label class="col-sm-4 col-form-label control-label">Guard</label>
                            <div class="col-sm-8">
                                {{Form::text('guard_name', 'web', ['class' => 'form-control', 'required' => 'required', 'readonly'])}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary float-right mr-1" data-dismiss="modal">Cancel</button>
                    <button data-toggle="modal" type="submit" class="btn btn-primary mr-2 float-right" id="formSubmit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    $(document).ready(function(){
        $('#update_modal').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget) ;

              var id = button.data('id') ;
              var name = button.data('name') ;

              var modal = $(this);

              modal.find('.modal-body .id').val(id);
              modal.find('.modal-body .name').val(name);

        });
    });
</script>

@endsection
