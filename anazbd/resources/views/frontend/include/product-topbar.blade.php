<div class="shop_toolbar_wrapper">
    {{--  <div class="shop_toolbar_btn">
        <button data-role="grid_4"
                type="button"
                class="btn-grid-4 active"
                data-toggle="tooltip"
                title="4">
        </button>
        <button data-role="grid_list"
                type="button"
                class="btn-list"
                data-toggle="tooltip"
                title="List">
        </button>
    </div>  --}}

    @if (Request::is('search'))
    @else
    <select name="orderby" id="sort-select">
        <option value="0" {{request()->query('desc') == 'time' ? 'selected' : ''}}>
            Sort by Time: recent to old
        </option>
        <option value="1" {{request()->query('asc') == 'time' ? 'selected' : ''}}>
            Sort by Time: old to recent
        </option>
        <option value="2" {{request()->query('asc') == 'price' ? 'selected' : ''}}>
            Sort by Price: low to high
        </option>
        <option value="3" {{request()->query('desc') == 'price' ? 'selected' : ''}}>
            Sort by Price: high to low
        </option>
        <option value="4" {{request()->query('asc') == 'name' ? 'selected' : ''}}>
            Sort by Product Name: A-Z
        </option>
        <option value="5" {{request()->query('desc') == 'name' ? 'selected' : ''}}>
            Sort by Product Name: Z-A
        </option>
    </select>
    @endif
</div>
