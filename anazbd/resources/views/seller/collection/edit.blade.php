@extends('material.layouts.master')
@section('title','Add Item')
@section('page_header')
    <i class="fa fa-plus"></i> Update Items in Collection
@stop


@section('content')
    <div class="card">
        <div class="card-header card-header-success">
            <h4 class="card-title">Update Collection</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    Collection: <b>{{$collection->title}}</b> <br>
                    View: <b><a href="{{route('frontend.collection',$collection->slug)}}"><i class="fa fa-eye"></i> View</a></b>
                </div>
                <div class="col-6">
                    <img src="{{asset($collection->cover_photo)}}" alt="image" class="img" height="100px">
                </div>
            </div>
            <div class="row">
                <div class="card shadow-sm col-md-6">
                    <form action="{{route('seller.product.collection.update',$collection)}}" method="POST">

                        <div class="card-body row">
                            @csrf
                            @method('PUT')
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Action</td>
                                    </tr>
                                    </thead>
                                    <tbody id="selected-table">
                                        @foreach($collection->items as $item)
                                            <tr id="row-{{$item->id}}">
                                                <td>{{$item->name}}</td>
                                                <td><input type='hidden' name='item_id[]' value='{{$item->id}}'><button type="button" data-id='{{$item->id}}' id='delete_btn' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div id="submit-btn" class="col-12 text-center">
                                <button class="btn btn-sm btn-success">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="card shadow-sm col-md-6 ">
                    <div class="card-body">
                        <div class="col-12 my-2">
                            <input type="text" id="searchBox" class="p-3 form-control" placeholder="Enter Item Name">
                        </div>
                        <div class="col-12">
                            <table id="items-table" class="table table-bordered text-center">
                                <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Action</td>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($items as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td><button id="add_btn" data-id="{{$item->id}}" data-name="{{$item->name}}" type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">NO Item Listed</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('click','#add_btn',function (){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let row = "<tr id='row-"+id+"'><td>"+name+"</td><td><input type='hidden' name='item_id[]' value='"+id+"'><button data-id='"+id+"' id='delete_btn' type='button' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button></td></tr>";
            $('#selected-table').append(row);
            $('#submit-btn').css('display','block');
        });
        $(document).on('keyup','#searchBox',function (){
            search();
        });
        $(document).on('click','#delete_btn',function (){
            let id = $(this).data('id');
            $('#row-'+id).remove();
        });
        function search(){
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchBox");
            filter = input.value.toUpperCase();
            table = document.getElementById("items-table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endpush

