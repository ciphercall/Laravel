@extends('admin.layout.master')
@section("title","All Roles")
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('page_header')
    <i class="material-icons">shield</i> Roles
@endsection

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header-primary">
                    Roles
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($roles as $role)
                                <tr>
                                    <td>{{ ($roles->total()-$loop->index)-(($roles->currentpage()-1) * $roles->perpage()) }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                        @forelse ($role->permissions as $permission)
                                            <span class="badge badge-success">{{ $permission->name }}</span>
                                        @empty
                                            <span class="badge badge-warning">No Permissions Found</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <div class="row m-0 p-0 justify-content-center">
                                            <button class="btn btn-sm btn-warning" id="edit_btn"
                                            data-id="{{ $role->id }}"
                                            data-name="{{ $role->name }}"
                                            data-description="{{ $role->description }}"
                                            data-permissions="[{{ $role->permissions->implode('id',',') }}]"
                                            ><i class="fa fa-edit"></i></button>
                                            <form action="{{ route('admin.role.delete',$role->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are You sure?')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Roles Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header-primary">
                    <span id="form_title">New</span> Role
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.role.store') }}" id="role_form" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea rows="4" name="description" class="form-control" id="description"></textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Permissions</label>
                            <select name="permissions[]" id="permissions" multiple="multiple" class="select2 col">
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission->id }}" id='permission_{{ $permission->id }}'>{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <hr>
                        <div class="col text-right">
                            <button class="btn btn-sm btn-warning" type="button" id="reset_btn"><i class="fa fa-times"></i></button>
                            <button class="btn btn-sm btn-success"><i class="fa fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2();
        $(document).on('click','#edit_btn',function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let desc = $(this).data('description');
            let permissions = $(this).data('permissions');

            $('.select2').val(permissions);
            $('.select2').trigger('change');
            $('#role_form').append(
                `<input type="hidden" name="id" id="role_id" value='`+id+`'>`
            );
            $("#form_title").html("Update");

            $('#name').val(name);
            $('#description').val(desc);
        });

        $(document).on('click','#reset_btn',function(){
            $('#role_id').remove();
            $('#name').val('');
            $('#description').val('');
            $('.select2').val([]);
            $('.select2').trigger('change');
            $("#form_title").html("New");
        });
    </script>
@endpush