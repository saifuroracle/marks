@extends('layouts.app')

@section('content')

<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
<link href="{{ asset('/assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('/assets/js/select2.min.js') }}" type="text/javascript" ></script>



<!--body wrapper start-->
<div class="wrapper">

    @include('includes.alertmessages')

    <div class="card mt-2">
        <div class="card-header">
            <h3 class="text-center">Manage Users</h3>
        </div>
        <div class="card-body">

            {{-- @if (in_array("user create", session('permissions'))) --}}
                <div class="row mb-2 ml-3 float-left">
                    <a href="#" data-toggle="modal" data-target="#create_modal">
                        <button id="editable-sample_new" class="btn btn-primary">
                            <i class="las la-plus mr-1"></i>
                            Add New User
                        </button>
                    </a>
                </div>
            {{-- @endif --}}

            <form action="{{route('manageusers')}}" method="get">
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
                <table class="table  table-centered mb-0">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Basic Info</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $i =>  $user)
                            <tr>
                                <td>{{ getPaginatedSerial($paginator, $i) }}</td>
                                <td>
                                    <div class="overflow-hidden">
                                        <p class="mb-0 font-weight-medium"><a href="javascript: void(0);">{{$user->username}}</a></p>
                                        <span class="font-13 my-0">{{$user->email}}</span> <br>
                                        <span class="font-13 my-0">{{$user->mobile}}</span>
                                    </div>
                                </td>
                                <td>{{$user->roles_comma_seperated}}</td>
                                <td>@include('includes.status', ['status' => [['key' => 'Active', 'value' => 1, 'class'=> 'badge-primary'], ['key' => 'Inactive', 'value' => 0, 'class'=> 'badge-warning']], 'selected'=> $user->status])</td>
                                <td>
                                    {{-- @if (in_array("user update", session('permissions'))) --}}
                                        <div class="flex align-items-center list-user-action">
                                            <a class="iq-bg-success" title="" data-original-title="Edit"  href="#" data-toggle="modal" data-target="#update_modal"
                                                    data-id="{{$user->id}}"
                                                    data-username="{{$user->username}}"
                                                    data-email="{{$user->email}}"
                                                    data-status="{{$user->status}}"
                                                    data-mobile="{{$user->mobile}}"
                                                    data-roles="{{$user->roles_comma_seperated}}"
                                            >
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                        </div>
                                    {{-- @endif --}}
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
<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="user_create_modal" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-center mx-auto text-white" id="user_create_modal">Create User</h4>
            </div>
            <form action="{{ route('createusersave') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label class="col-sm-4 col-form-label control-label">Username</label>
                            <div class="col-sm-8">
                                {{Form::text('username', '', ['class' => 'form-control', 'required' => 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label class="col-sm-4 col-form-label control-label">Email</label>
                            <div class="col-sm-8">
                                {{Form::text('email', '', ['class' => 'form-control', 'required' => 'required'])}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label class="col-sm-4 col-form-label control-label">Password</label>
                            <div class="col-sm-8">
                                {{Form::password('password', ['class' => 'form-control', 'required' => 'required'])}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label control-label">Mobile</label>
                            <div class="col-sm-8">
                                {{Form::text('mobile', '', ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label for="role" class="col-sm-4 col-form-label control-label">Status</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('status', 1, true, array('id' => 'status_active', 'class' => 'form-check-input')) !!}
                                    {!! Form::label('status_active', 'Active', ['class' => 'form-check-label', 'style'=>'cursor:pointer']) !!}
                                </div>
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('status', 0, false, array('id' => 'status_inactive', 'class' => 'form-check-input')) !!}
                                    {!! Form::label('status_inactive', 'Inactive', ['class' => 'form-check-label', 'style'=>'cursor:pointer']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label for="role" class="col-sm-4 col-form-label control-label">Roles</label>
                            <div class="col-sm-8">
                                {!! Form::select('roles[]', $roles,[], array('id' =>'roles','class' => 'form-control', 'required' => 'required','multiple')) !!}
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
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="user_update_modal" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-center mx-auto text-white" id="user_update_modal">Update User</h4>
            </div>
            <form action="{{ route('editusersave') }}" method="post">
                @csrf

                <div class="modal-body">
                    {{Form::number('id', '', ['class' => 'id', 'required' => 'required', 'hidden'])}}

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label class="col-sm-4 col-form-label control-label">Username</label>
                            <div class="col-sm-8">
                                {{Form::text('username', '', ['class' => 'form-control username', 'required' => 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label class="col-sm-4 col-form-label control-label">Email</label>
                            <div class="col-sm-8">
                                {{Form::text('email', '', ['class' => 'form-control email', 'required' => 'required'])}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row ">
                            <label class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                {{Form::text('password', '', ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label control-label">Mobile</label>
                            <div class="col-sm-8">
                                {{Form::text('mobile', '', ['class' => 'form-control mobile'])}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label for="role" class="col-sm-4 col-form-label control-label">Status</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('status', 1, false, array('id' => 'status_active_e', 'class' => 'form-check-input')) !!}
                                    {!! Form::label('status_active_e', 'Active', ['class' => 'form-check-label', 'style'=>'cursor:pointer']) !!}
                                </div>
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('status', 0, false, array('id' => 'status_inactive_e', 'class' => 'form-check-input')) !!}
                                    {!! Form::label('status_inactive_e', 'Inactive', ['class' => 'form-check-label', 'style'=>'cursor:pointer']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group row required">
                            <label for="role" class="col-sm-4 col-form-label control-label">Roles</label>
                            <div class="col-sm-8">
                                {!! Form::select('roles[]', $roles,[], array('id' => 'roles2','class' => 'form-control', 'required' => 'required','multiple')) !!}
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
        $('#roles').select2({
            dropdownParent: $("#create_modal .modal-body"),
            placeholder: {
                id: '', // the value of the option
                text: '--Select Roles--'
            },
            maximumSelectionLength: 1,
            allowClear: true,
            language: {
            noResults: function (params) {
                return "No Data Found!";
            }
            },
        });

        $('#roles2').select2({
            dropdownParent: $("#update_modal .modal-body"),
            placeholder: {
                id: '', // the value of the option
                text: '--Select Roles--'
            },
            tags: true,
            maximumSelectionLength: 1,
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
              var username = button.data('username') ;
              var email = button.data('email') ;
              var mobile = button.data('mobile') ;
              var status = button.data('status') ;
              var roles = button.data('roles') ;
            //   console.log(id)
            //   console.log(roles)
            //   console.log(roles.split(', '))
              roles = roles.split(', ')
            //   console.log(roles);

              var modal = $(this);

              modal.find('.modal-body .id').val(id);
              modal.find('.modal-body .username').val(username);
              modal.find('.modal-body .email').val(email);
              modal.find('.modal-body .mobile').val(mobile);
              if (status==1) {
                $('#status_active_e').prop('checked', true);
              }
              else{
                $('#status_inactive_e').prop('checked', true);
              }

              roles2Defaulter(roles)
            //   modal.find('.modal-body #roles2').val(roles).trigger("change");
            //   $('#roles2').select2('val', roles).trigger("change");
            //   $('#roles2').val(roles).trigger("change");
            //   $('#roles2').select2('val',roles );

            //   $('#roles2').select2(['Super Admin'], null, false);
            //   $('#roles2').val(['Super Admin']).change();
            //   $('#roles2').select2().val(roles).trigger("change")
            // $("#roles2 > option").val(roles);
            // $("#roles2").trigger("change");
        });

    });

    function  roles2Defaulter(val)
    {
        // console.log(val);
        $('#roles2').val(val).trigger('change');
        // $('#roles2').val(null).trigger('change');
        // $('#roles2').val(val).trigger("change");
        // $('#roles2').select2('val',null );
        // $('#roles2').select2('val',val );
        // $("#roles2").select2().select2("val", null);
        // $("#roles2").select2().select2("val", val);
        // $('#roles2').select2('val', val );
        // $('#roles2').val(null).trigger('change');
        // $("#roles2").trigger("change")
    }
</script>

@endsection
