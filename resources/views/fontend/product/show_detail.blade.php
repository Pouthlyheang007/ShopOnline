@extends('layout')
@section('content')
@foreach ($product_detail as $key =>$value)
{{-- <h2 class="category-name-style">{{$value->category_name}}</h2> --}}
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <div class="view-product">
            <img src="{{URL::to('upload/product/'.$value->product_image)}}" alt="" />
            <h3>ZOOM</h3>
        </div>
        <div id="similar-product" class="carousel slide" data-ride="carousel">
              <a class="left item-control" href="#similar-product" data-slide="prev">
                <i class="fa fa-angle-left"></i>
              </a>
              <a class="right item-control" href="#similar-product" data-slide="next">
                <i class="fa fa-angle-right"></i>
              </a>
        </div>

    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$value->product_name}}</h2>
            <p>Mã ID:{{$value->product_id}} </p>
            <img src="images/product-details/rating.png" alt="" />

        <form action="{{URL::to('/save-cart')}}" method="POST">
            {{ csrf_field() }}
        <span>
            <span>{{$value->product_price.'VNĐ'}}</span>

            <label>Số lượng:</label>
            <input name="qty" type="number" min="1"  value="1" />
            <input name="productid_hidden" type="hidden"  value="{{$value->product_id}}" />
            <button type="submit" class="btn btn-fefault cart">
                <i class="fa fa-shopping-cart"></i>
                Thêm giỏ hàng
            </button>

        </span>
        </form>
            <p><b>Biểu kiện:</b> Mới 100%</p>
            <p><b>Danh mục:</b> {{$value->category_name}}</p>
            <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->


<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Mổ tả sản phẩm</a></li>
            <li><a href="#companyprofile" data-toggle="tab">Chỉ tiết sản phẩm</a></li>
            <li ><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="details" >
            <p>{!!$value->product_desc!!}</p>
        </div>

        <div class="tab-pane fade" id="companyprofile" >
            <p>{!!$value->product_content!!}</p>
        </div>

        <div class="tab-pane fade" id="reviews" >
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                </ul>
                <style type="text/css">
                row.style_comment{
                    border: 1px solid #ddd;
                    border-radius:10px;
                    background: #F0F0E9;
                }
                </style>

                <form>
                    @csrf
                    <div id="comment_show"></div>
                    <input type="hidden" name="comment_product_id" class="comment_product_id" value="{{$value->product_id}}">
                </form>
                <p></p>
                <p><b>Viết đánh giá của bạn</b></p>

                <form action="#">
                    <span>
                        <input style="width:94%;magin-left:0;" type="text" placeholder="Tên bình luận" class="comment_name"/>
                    </span>
                    <textarea name="comment" class="comment_content" placeholder="Nội dung bình luận" ></textarea>
                    <div id="notify_comment"></div>
                    <button type="button" class="btn btn-default pull-right send-comment">
                        Gửi bình luận
                    </button>
                    <div id="notify_comment"></div>
                </form>
            </div>
        </div>

    </div>
</div><!--/category-tab-->

@endforeach
<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm liên quan</h2>

    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">
            @foreach ($relate as $key =>$product )
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
            </div>
        </div>
         <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>
    </div>
</div><!--/recommended_items-->
@endsection
