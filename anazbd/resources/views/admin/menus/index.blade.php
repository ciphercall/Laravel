@extends('admin.layout.master')
@section("title","All Menu")
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('page_header')
    <i class="material-icons">menu</i> Menu
@endsection

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header-primary">
                    Menu
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>SL</th>
                                <th>Name</th>
                                <th>Route</th>
                                <th>Panel</th>
                                <th>Icon</th>
                                <th>Permissions</th>
                                 <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($menus as $menu)
                                <tr>
                                    <td>{{ ($menus->total()-$loop->index)-(($menus->currentpage()-1) * $menus->perpage()) }}</td>
                                    <td>{{ $menu->name }}</td>
                                    <td>{{ $menu->route }}</td>
                                    <td><span class="badge badge-{{ $menu->is_new_panel ? 'primary' : 'info' }}">{{ $menu->is_new_panel ? 'NEW' : 'OLD' }}</span></td>
                                    <td>
                                        <i class="{{ $menu->icon }}"></i>
                                        <span class="text-muted">{{ $menu->icon }}</span>
                                    </td>
                                    <td>@foreach($menu->permissions as $permission) <span class="badge badge-info">{{$permission->name}}</span> @endforeach</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"
                                         data-id="{{ $menu->id }}"
                                         data-name="{{ $menu->name }}"
                                         data-route="{{ $menu->route }}"
                                         data-icon="{{ $menu->icon }}"
                                         data-is_new_panel="{{ $menu->is_new_panel }}"
                                         data-parent_id="{{ $menu->parent_id }}"
                                         data-permissions="{{ $menu->permissions->pluck('id') }}"
                                         id="editBtn"><i class="fa fa-edit"></i></button>
                                         <form action="{{ route('admin.menu.delete',$menu->id) }}" method="POST">
                                             @csrf
                                             @method('DELETE')
                                             <button class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure?');" id="deleteBtn"><i class="fa fa-trash"></i></button>
                                         </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">NO MENU FOUND</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $menus->links() }}
                    <div class="row">
                        @php
                        $old = $dirtyMenus->where('is_new_panel',false)->filter(function($menu){
                                return $menu->submenus->count() > 0 || $menu->parent_id == null;
                            });
                        $new = $dirtyMenus->where('is_new_panel',true)->filter(function($menu){
                                return $menu->submenus->count() > 0 || $menu->parent_id == null;
                            });
                        @endphp
                        <div class="col">
                            <div class="card rounded shadow m-2">
                                <div class="card-header card-header-primary">
                                    Old Panel
                                </div>
                                <div class="card-body">
                                    <ul>
                                        @foreach($old as $item)
                                            <li>{{ $item->name }}</li>
                                            @if($item->submenus->count() > 0)
                                                <ul>
                                                    @foreach($item->submenus as $smenu)
                                                        <li>{{ $smenu->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card rounded shadow m-2">
                                <div class="card-header card-header-primary">
                                    New Panel
                                </div>
                                <div class="card-body">
                                    <ul>
                                        @foreach($new as $item)
                                            <li>{{ $item->name }}</li>
                                            @if($item->submenus->count() > 0)
                                                <ul>
                                                    @foreach($item->submenus as $smenu)
                                                        <li>{{ $smenu->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header-primary">
                    <span id="form_title">New</span> Menu
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.menu.store') }}" id="menu_form" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Route</label>
                            <input type="text" name="route" class="form-control" id="route">
                            @error('route') <small class="text-danger">{{ $message }}</small> @else <small class="text-muted">Ex: admin.product.index</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Icon</label>
                            <input type="text" name="icon" class="form-control" id="icon">
                            @error('icon') <small class="text-danger">{{ $message }}</small> @else <small class="text-muted">Ex: admin.product.index</small> @enderror
                        </div>
                        <div class="form-check">
                            <input class="" type="radio" value="1" name="is_new_panel" id="flexRadio1">
                            <label class="form-check-label" for="flexRadioDefault1">
                              For New Admin Panel
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="" type="radio" value="0" name="is_new_panel" id="flexRadio2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                For Old Admin Panel
                            </label>
                          </div>
                          @error('is_new_panel') <small class="text-danger">{{ $message }}</small> @enderror
                          <div class="form-group">
                            <label for="">Parent Menu</label>
                            <select name="parent_id" id="parent" class="select2 col">
                            <option value="">Choose Parent if Any</option>
                                @foreach($parentMenus as $menu)
                                    <option value="{{ $menu->id }}" >{{ $menu->name }}</option>
                                @endforeach
                            </select>
                            @error('parent_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Permissions</label>
                            <select name="permissions[]" id="permissions" multiple="multiple" class="select2 col">
                                @foreach($permissions as $permission)
                                    <option value="{{ $permission->id }}" id='permission_{{ $permission->id }}'>{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            @error('permissions') <small class="text-danger">{{ $message }}</small> @enderror
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
        $(document).on('click','#editBtn',function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let icon = $(this).data('icon');
            let isAdminPanelNew = $(this).data('is_new_panel');
            let parent = $(this).data('parent_id');
            let route = $(this).data('route');
            let permissions = $(this).data('permissions');
            let url = "{{ route('admin.menu.update') }}";
            if(isAdminPanelNew == 0){
                $('#flexRadio1').removeAttr('checked');
                $('#flexRadio2').attr('checked','checked');
            }else{
                $('#flexRadio2').removeAttr('checked');
                $('#flexRadio1').attr('checked','checked');
            }
            $('#menu_form').attr('action',url);
            $('#permissions').val(permissions);
            $('#parent').val(parent);
            $('.select2').trigger('change');
            $('#menu_form').append(
                `<input type="hidden" name="id" id="menu_id" value='`+id+`'><input type="hidden" name="_method" id="menu_method" value='PATCH'>`
            );
            $("#form_title").html("Update");

            $('#name').val(name);
            $('#route').val(route);
            $('#icon').val(icon);
        });

        $(document).on('click','#reset_btn',function(){
            let url = "{{route('admin.menu.store')}}";
            $('#menu_form').attr('action',url);
            $('#menu_id').remove();
            $('#menu_method').remove();
            $('#name').val('');
            $('#route').val('');
            $('#icon').val('');
            $('.select2').val([]);
            $('.select2').trigger('change');
            $("#form_title").html("New");
            $('#flexRadio1').removeAttr('checked');
            $('#flexRadio2').attr('checked','checked');
        });
    </script>
@endpush