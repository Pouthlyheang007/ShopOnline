@extends('layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href=""> Thanh toán giỏ hàng</a></li>
            </ol>
        </div><!--/breadcrums-->

        <div class="register-req">
            <p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
        </div><!--/register-req-->

        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-12 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin gửi hàng</p>
                        <div class="form-one">
                            <form  method="POST">
                            {{-- action="{{URL::to('/checkout-customer')}}" --}}
                               @csrf
                                <input type="text" name="shipping_email" class="shipping_email" placeholder="Địa chỉ email">
                                <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên">
                                <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ">
                                <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại">
                                <textarea name="shipping_notes" class="shipping_notes" placeholder="Ghi chủ đơn hàng của bạn" rows="6"></textarea>
{{-- mmm --}}
                                @if(Session::get('fee'))
									<input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
								@else
									<input type="hidden" name="order_fee" class="order_fee" value="10000">
								@endif

								@if(Session::get('coupon'))
									@foreach(Session::get('coupon') as $key => $cou)
										<input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
									@endforeach
								@else
									<input type="hidden" name="order_coupon" class="order_coupon" value="no">
								@endif
{{-- mmm --}}
                                <div class="">
									<div class="form-group">
		                                <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
		                                    <select name="payment_select"  class="form-control input-sm m-bot15 payment_select">
		                                        <option value="0">Qua chuyển khoản</option>
		                                        <option value="1">Tiền mặt</option>
		                                    </select>
		                            </div>
								</div>
								<input type="button" value="Xác nhận đơn hàng" name="send_order" class="btn btn-primary btn-sm send_order">

                            </form>

{{-- mmm --}}
                            <form>
                                @csrf

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn thành phố</label>
                                      <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                        <option value="">--Chọn tỉnh thành phố--</option>
                                        @foreach($city as $key => $ci)
                                            <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn quận huyện</label>
                                      <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                            <option value="">--Chọn quận huyện--</option>

                                    </select>
                                </div>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn xã phường</label>
                                      <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                            <option value="">--Chọn xã phường--</option>
                                    </select>
                                </div>

                              	<input type="button" value="Tính phí vận chuyển" name="calculate_order" class="btn btn-primary btn-sm calculate_delivery ">
                            </form>
                        </div>
{{-- mm --}}

                    </div>
                </div>
            </div>

{{-- mm --}}
	<div class="col-sm-12 clearfix">
         {{-- message --}}
             @if(session()->has('message'))
             <div class="alert alert-success">
                 {{session()->get('message')}}
             </div>
         @elseif(session()->has('error'))
             <div class="alert alert-danger">
                 {{session()->get('error')}}
             </div>
         @endif
 {{-- end message --}}
			<div class="table-responsive cart_info">
				<?php
				$content = Cart::content();
                 //echo '<pre>';
                   //  print_r($content);
                 //echo '</pre>';
				?>
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh</td>
							<td class="description">Tên sp</td>
							<td class="price">Giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Tổng</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
                    @if(Session::get('cart')==true)
                    @php
                    $total = 0;
                    @endphp
						@foreach($content as $v_content)

						<tr>
							<td class="cart_product">
								<a href=""><img src="{{URL::to('upload/product/'.$v_content->options->image)}}" width="90" alt="" /></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{$v_content->name}}</a></h4>
								<p>Web ID:{{$v_content->id}}</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($v_content->price).' '.'vnđ'}}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<form action="{{URL::to('/update-cart-quantity')}}" method="POST">
									{{ csrf_field() }}
									<input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}"  >
									<input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
									<input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
									</form>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">

									<?php
									$subtotal = $v_content->price * $v_content->qty;
                                    $total+=$subtotal;
									echo number_format($subtotal).' '.'vnđ';
									?>
								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						@endforeach

                        <tr>
                            <td>
                                <a class="btn btn-default check_out" href="{{URL::to('/delete-all-cart')}}">Xóa tất cả giỏ hàng</a>
                            </td>
                            <td>
								@if(Session::get('coupon'))
	                          	<a class="btn btn-default check_out" href="{{url('/unset-coupon')}}">Xóa mã khuyến mãi</a>
								@endif
							</td>


                            @if(Session::get('cart'))
                            <td>
                                <form action="{{url('/check-coupon')}}" method="POST">
                                    @csrf
                                    <input type="text" class="form-control" placeholder="Nhập mã giảm giá" name="coupon">
                                    <input type="submit" class="btn btn-default check_coupon" name="check_coupon"
                                    value="Tính mã giảm giá">
                                </form>
                            </td>
                            @endif

                            <td>
                                 <li>Tổng tiền : <span>{{Cart::subtotal().' '.'vnđ'}}</span></li>
                                 @if(Session::get('coupon'))
                                <li>

									@foreach(Session::get('coupon') as $key => $cou)
										@if($cou['coupon_condition']==1)
											Mã giảm : {{$cou['coupon_number']}} %
												<p>
												@php
													$total_coupon = ($total*$cou['coupon_number'])/100;

												@endphp
												</p>
												<p>
												@php
													$total_after_coupon = $total-$total_coupon;
												@endphp
												</p>
										@elseif($cou['coupon_condition']==2)
											Mã giảm : {{number_format($cou['coupon_number'],0,',','.')}} k
												<p>
												@php
													$total_coupon = $total - $cou['coupon_number'];

												@endphp
												</p>
												@php
													$total_after_coupon = $total_coupon;
												@endphp
										@endif
									@endforeach

							    </li>
                                 @endif

                                @if(Session::get('fee'))
									<li>
										<a class="cart_quantity_delete" href="{{url('/del-fee')}}"><i class="fa fa-times"></i></a>

										Phí vận chuyển <span>{{number_format(Session::get('fee'),0,',','.')}}đ</span>
                                    </li>
										<?php $total_after_fee = $total + Session::get('fee'); ?>
								@endif
                                <li>Tổng còn:
									@php
										if(Session::get('fee') && !Session::get('coupon')){
											$total_after = $total_after_fee;
											echo number_format($total_after,0,',','.').'đ';
										}elseif(!Session::get('fee') && Session::get('coupon')){
											$total_after = $total_after_coupon;
											echo number_format($total_after,0,',','.').'đ';
										}elseif(Session::get('fee') && Session::get('coupon')){
											$total_after = $total_after_coupon;
											$total_after = $total_after + Session::get('fee');
											echo number_format($total_after,0,',','.').'đ';
										}elseif(!Session::get('fee') && !Session::get('coupon')){
											$total_after = $total;
											echo number_format($total_after,0,',','.').'đ';
										}

									@endphp
								</li>

                            </td>
                        </tr>
                        {{-- <tr>
                            <td style="margin-left: 200px;">
                                <?php
                                    $customer_id = Session::get('customer_id');
                                    if($customer_id!=NULL){
                                ?>
                                    <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Thanh toán</a>

                                <?php
                                    }else{
                                ?>
                                    <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh toán</a>
                                <?php
                                     }
                                ?>
                            </td>
                        </tr> --}}
                        @else
                        <tr>
                            <td colspan="5"><center>
                                @php
                                     echo'Làm ơn thêm sản phẩm vào giỏ hàng';
                                @endphp
                                </center>
                            </td>
                        </tr>
                    @endif
					</tbody>
				</table>
			</div>
		</div>
{{-- mm --}}

    </div>

</section> <!--/#cart_items-->
@endsection
