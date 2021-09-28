@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                  Cập nhật sản phẩm
                </header>

                <div class="panel-body">

                    <div class="position-center">
            @foreach($edit_product as $key =>$pro)
                        <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phảm</label>
                            <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" value="{{$pro->product_name}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Gía sản phẩm</label>
                            <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" value="{{$pro->product_price}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" >
                            <img src="{{URL::to('upload/product/'.$pro->product_image)}}" height="100" width="100">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows="6" class="form-control" name="product_desc" id="exampleInputPassword1" >{{$pro->product_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chi tiết sản phẩm</label>
                            <textarea style="resize: none" rows="6" class="form-control" name="product_content" id="exampleInputPassword1"  >{{$pro->product_content}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                            <select name="product_cate" class="form-control input-sm m-bot15">

                    @foreach($cate_product as $key =>$cate)
                            @if($cate->category_id==$pro->category_id)
                                <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                            @else
                            <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                            @endif
                    @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Hien thi</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>

                            </select>
                        </div>

                        <button type="submit" name="add_product" class="btn btn-info">Update Product</button>
                    </form>
            @endforeach
                    </div>

                </div>
            </section>

    </div>
@endsection

