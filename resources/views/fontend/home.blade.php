@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Sản phẩm mới nhất</h2>
@foreach ($all_product as $key =>$product )

    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
                        <img src="{{URL::to('upload/product/'.$product->product_image)}}" alt="" height="200"/>
                        <h2>{{($product->product_price).' '.'VND'}}</h2>
                        <p>{{$product->product_name}}</p>
                        <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">
                            Chi tiết sản phẩm</button>
                    </a>
                </div>

            </div>
        </div>
    </div>

@endforeach
</div><!--features_items-->

@endsection
