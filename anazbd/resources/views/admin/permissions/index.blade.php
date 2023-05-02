@extends('admin.layout.master')
@section("title","All Permissions")
@section('page_header')
    <i class="material-icons">shield</i> Permissions
@endsection

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header-primary">
                    Permissions
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($permissions as $permission)
                                <tr>
                                    <td>{{ ($permissions->total()-$loop->index)-(($permissions->currentpage()-1) * $permissions->perpage()) }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->description }}</td>
                                    <td>
                                        <div class="row p-0 m-0 justify-content-center">
                                            <button data-id="{{ $permission->id }}"
                                                id="edit_btn"
                                                data-name="{{ $permission->name }}"
                                                data-desc="{{ $permission->description }}"
                                                class="btn btn-warning btn-sm"
                                                ><i class="fa fa-edit"></i></button>
                                           <form action="{{ route('admin.permission.delete',$permission->id) }}" method="post">
                                               @csrf
                                               @method('DELETE')
                                               <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                           </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No permissions Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header-primary">
                    <span id="form_title">New</span> Permission
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.permission.store') }}" method="POST" id="permission_form">
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
                        {{--  <div class="form-group">
                            <label for="">Permissions</label>
                            <select name="permissions[]" id="permissions" multiple="multiple" class="select2 col">
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>  --}}
                        <hr>
                        <div class="col text-right">
                            <button class="btn btn-sm btn-warning" id="reset_btn" type="button"><i class="fa fa-times"></i></button>
                            <button class="btn btn-sm btn-success"><i class="fa fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click','#edit_btn',function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let desc = $(this).data('desc');

            $('#permission_form').append(
                `<input type="hidden" name="id" id="permission_id" value='`+id+`'>`
            );
            $("#form_title").html("Update");

            $('#name').val(name);
            $('#description').val(desc);
        });

        $(document).on('click','#reset_btn',function(){
            $('#permission_id').remove();
            $('#name').val('');
            $('#description').val('');
            $("#form_title").html("New");

        });
    </script>
@endpush