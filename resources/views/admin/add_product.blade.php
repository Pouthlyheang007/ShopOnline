@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   Thêm sản phẩm
                </header>
                <div class="panel-body">

                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Ten san pham">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Gía sản phẩm</label>
                            <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Gia san pham">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" >
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows="6" class="form-control" name="product_desc" id="exampleInputPassword1"  placeholder="Mo ta san pham"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chi tiết sản phẩm</label>
                            <textarea style="resize: none" rows="6" class="form-control" name="product_content" id="exampleInputPassword1"  placeholder="Noi dung san pham"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                            <select name="product_cate" class="form-control input-sm m-bot15">

                    @foreach($cate_product as $key =>$cate)
                                <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
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

                        <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
@endsection

