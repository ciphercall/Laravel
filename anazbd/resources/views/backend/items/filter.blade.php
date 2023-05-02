<form class="form-horizontal"
      method="get"
      action="{{ url('/')  }}/{{request()->route()->uri()}}"
      role="form"
      enctype="multipart/form-data">
    <table class="table table-bordered">
        <tr>
            <th class="bg-dark" style="width: 18%"><label for="shop">Shop</label></th>
            <th class="bg-dark" style="width: 18%"><label for="category">Category</label></th>
            <th class="bg-dark" style="width: 18%"><label for="category">Sub Category</label></th>
            <th class="bg-dark" style="width: 18%"><label for="brand">Brand</label></th>
            <th class="bg-dark" style="width: 18%"><label for="name">Name</label></th>
            <th class="bg-dark" style="width: 10%;">Actions</th>
        </tr>
        <tr>
            <td>
                <select class="chosen-select" id="shop" name="shop" data-placeholder="- Shop -">
                    <option value=""></option>
                    @foreach($shops as $shop)
                        <option value="{{ $shop->id }}"
                            {{ request()->query('shop') == $shop->id ? 'selected' : '' }}>
                            {{ $shop->shop_name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="chosen-select" id="category" name="category" data-placeholder="- Category -">
                    <option value=""></option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request()->query('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="chosen-select" id="sub_category" name="sub_category" data-placeholder="- Sub Category -">
                    <option value=""></option>
                    @foreach($sub_categories as $sub_category)
                        <option value="{{ $sub_category->id }}"
                            {{ request()->query('sub_category') == $sub_category->id ? 'selected' : '' }}>
                            {{ $sub_category->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="chosen-select" id="brand" name="brand" data-placeholder="- Brand -">
                    <option value=""></option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ request()->query('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text"
                       id="name"
                       name="name"
                       placeholder="Name"
                       value="{{request()->query('name')}}"
                       class="input-sm form-control text-center">
            </td>
            <td>
                <div class="btn-group btn-group-mini btn-corner">
                    <button type="submit"
                            class="btn btn-xs btn-primary"
                            title="Search">
                        <i class="ace-icon fa fa-search"></i>
                    </button>

                    <a href="/{{request()->route()->uri()}}"
                       class="btn btn-xs btn-info"
                       title="Show All">
                        <i class="ace-icon fa fa-list"></i>
                    </a>
                </div>
            </td>
        </tr>
    </table>
</form>
