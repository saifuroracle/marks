@extends('layouts.app')

@section('content')

<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>


<!--body wrapper start-->
<div class="wrapper">

    @include('includes.alertmessages')

    <div class="card mt-2">
        <div class="card-header">
            <h3 class="text-center">Manage Roles</h3>
        </div>
        <div class="card-body">

            <div class="row mb-2 ml-3  float-left">
                <a href="#" data-toggle="modal" data-target="#create_modal">
                    <button id="editable-sample_new" class="btn btn-primary">
                        <i class="las la-plus mr-1"></i>
                        Add New Role
                    </button>
                </a>
            </div>

            <div class="table-responsive my-2">
                <table class="table table-centered mb-0">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $i =>  $role)
                            <tr>
                                <td>{{ getPaginatedSerial($paginator, $i) }}</td>
                                <td>
                                    <div class="overflow-hidden">
                                        <p class="mb-0 font-weight-medium"><a href="javascript: void(0);">{{$role->name}}</a></p>
                                    </div>
                                </td>
                                <td>{{ucwords($role->permissions_comma_seperated)}}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm"  title="" data-original-title="Edit"  href="#" data-toggle="modal" data-target="#update_modal"
                                        data-id="{{$role->id}}"
                                        data-name="{{$role->name}}"
                                        data-permissions="{{$role->permissions_comma_seperated}}"
                                    >Edit</a>
                                    {!! Form::open(['method' => 'POST','route' => ['deleterole', ['id'=>$role->id]],'style'=>'display:inline']) !!}
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
<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="role_create_modal" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-center mx-auto text-white" id="role_create_modal">Create Role</h4>
            </div>
            <form action="{{ route('createrolesave') }}" method="post">
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

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label for="role" class="col-sm-4 col-form-label control-label">Permissions</label>
                            <div class="col-sm-8">
                                {!! Form::select('permissions[]', $permissions,[], array('id' =>'permissions','class' => 'form-control', 'required' => 'required','multiple')) !!}
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
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="role_update_modal" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-center mx-auto text-white" id="role_update_modal">Update Role</h4>
            </div>
            <form action="{{ route('editrolesave') }}" method="post">
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

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label for="role" class="col-sm-4 col-form-label control-label">Permissions</label>
                            <div class="col-sm-8">
                                {!! Form::select('permissions[]', $permissions,[], array('id' => 'permissions2','class' => 'form-control', 'required' => 'required','multiple')) !!}
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
        $('#permissions').select2({
            dropdownParent: $("#create_modal .modal-body"),
            placeholder: {
                id: '', // the value of the option
                text: '--Select Permissions--'
            },
            // maximumSelectionLength: 1,
            allowClear: true,
            language: {
            noResults: function (params) {
                return "No Data Found!";
            }
            },
        });

        $('#permissions2').select2({
            dropdownParent: $("#update_modal .modal-body"),
            placeholder: {
                id: '', // the value of the option
                text: '--Select Permissions--'
            },
            tags: true,
            // maximumSelectionLength: 1,
            allowClear: true,
            language: {
                noResults: function (params) {
                    return "No Data Found!";
                }
            },
        });

        $('#update_modal').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget) ;

              var id = button.data('id') ;
              var name = button.data('name') ;
              var permissions = button.data('permissions') ;
              permissions = permissions.split(', ')

              var modal = $(this);

              modal.find('.modal-body .id').val(id);
              modal.find('.modal-body .name').val(name);

              permissions2Defaulter(permissions)
        });
    });

    function  permissions2Defaulter(val)
    {
        $('#permissions2').val(val).trigger('change');
    }
</script>

@endsection
