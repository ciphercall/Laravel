<form action="{{ route($route) }}" class="col text-right" method="GET">
    @csrf
    <input type="hidden" name="order_no" value="{{request()->order_no}}" class="form-control" id="">
    <input type="hidden" name="invoice_no" value="{{request()->invoice_no}}" class="form-control" id="">
    <input type="hidden" name="user" value="{{request()->user}}" class="form-control" id="">
    <input type="hidden" value="{{request()->from}}" name="from" class="form-control" id="">
    <input type="hidden" value="{{request()->to}}" name="to" class="form-control" id="">
    <input type="hidden" name="total" value="{{request()->total}}" class="form-control" id="">
    <input type="hidden" class="form-control" value="{{ request()->mobile }}" name="mobile">
    <input type="hidden" class="form-control" value="{{ request()->order_date }}" name="order_date">
    <input type="hidden" name="price_from" value="{{request()->price_from}}" class="form-control" id="">
    <input type="hidden" name="price_to" value="{{request()->price_to}}" class="form-control" id="">
    <input type="hidden" name="payment_status" value="{{request()->payment_status}}" class="form-control" id="">
    <input type="hidden" name="status" value="{{$status}}">
    @if($status == "delivered")
        <input type="hidden" name="item_id" value="{{ request()->item_id }}">
        <input type="hidden" name="category_id" value="{{ request()->category_id }}">
        <input type="hidden" name="sub_category_id" value="{{ request()->sub_category_id }}">
        <input type="hidden" name="child_category_id" value="{{ request()->child_category_id }}">
    @endif
    <button class="btn btn-sm btn-primary"><i class="fa fa-file-download"></i></button>
</form>