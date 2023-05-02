@extends('admin.layout.master')
@section("title","All Admins")
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('page_header')
    <i class="material-icons">shield</i> Admins
@endsection

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header-primary">
                    Admin
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Name</th>
                                <th>email</th>  
                                <th>Super Admin</th>  
                                <th>roles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($admins as $admin)
                                <tr>
                                    <td>{{ ($admins->total()-$loop->index)-(($admins->currentpage()-1) * $admins->perpage()) }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td><span class="badge {{ $admin->is_super ? 'badge-warning' : 'badge-primary' }}">{{ $admin->is_super ? 'Yes' : 'No' }}</span></td>
                                    <td>
                                        @foreach ($admin->roles as $item)
                                            <span class="badge badge-success">{{ $item->name }}</span>    
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="row m-0 p-0 justify-content-center">
                                            <button class="btn btn-sm btn-warning" id="edit_btn"
                                                data-id="{{ $admin->id }}"
                                                data-name="{{ $admin->name }}"
                                                data-email="{{ $admin->email }}"
                                                data-roles="[{{ $admin->roles->implode('id',',') }}]"
                                                data-super="{{ $admin->is_super }}"
                                            ><i class="fa fa-edit"></i></button>
                                            <form action="{{ route('admin.admin.delete',$admin->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure ?')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No admins Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $admins->links() }}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header-primary">
                    <Span id="form_title">New</Span> admin
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.admin.store') }}" id="admin_form" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name <sup class="text-danger">*</sup></label>
                            <input type="text" name="name" class="form-control" id="name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Email <sup class="text-danger">*</sup></label>
                            <input type="email"  name="email" class="form-control" id="email">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" name="is_super" value="1" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Make Super Admin</label>
                          </div>
                        <div class="form-group">
                            <label for="">Password <sup class="text-danger star_indicator">*</sup></label>
                            <input type="password" name="password" class="form-control" id="password">
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Password Confirmation <sup class="text-danger star_indicator">*</sup></label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                            @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        {{--  <div class="form-group">
                            <label for="">Description</label>
                            <textarea rows="4" name="description" class="form-control" id="description"></textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>  --}}
                        <div class="form-group">
                            <label for="">Roles <sup class="text-danger">*</sup></label>
                            <select name="roles[]" id="roles" multiple="multiple" class="select2 col">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <hr>
                        <div class="col text-right">
                            <button class="btn btn-sm btn-warning" id="reset_btn" type="reset"><i class="fa fa-times"></i></button>
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
            let email = $(this).data('email');
            let roles = $(this).data('roles');
            let superAdmin = $(this).data('super');
            if(superAdmin == 1){
                $('#exampleCheck1').attr('checked','checked')
            }else{
                $('#exampleCheck1').removeAttr('checked')
            }
            $('.select2').val(roles);
            $('.select2').trigger('change');
            $('#admin_form').append(
                `<input type="hidden" name="id" id="admin_id" value='`+id+`'>`
            );
            $('.star_indicator').css('display','none');
            $("#form_title").html("Update");
            $('#name').val(name);
            $('#email').val(email);
        });

        $(document).on('click','#reset_btn',function(){
            $('.star_indicator').css('display','inline');
            $('#admin_id').remove();
            $('#name').val('');
            $('#email').val('');
            $('.select2').val([]);
            $('.select2').trigger('change');
            $("#form_title").html("New");
            $('#exampleCheck1').removeAttr('checked');
        });
    </script>
@endpush