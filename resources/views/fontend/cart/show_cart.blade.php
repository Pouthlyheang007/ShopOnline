@extends('layout')
@section('content')

	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Giỏ hàng của bạn</li>
				</ol>
			</div>
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

							 <td>
								@if(Session::get('customer_id'))
	                          	<a class="btn btn-default check_out" href="{{url('/checkout')}}">Đặt hàng</a>
	                          	@else
	                          	<a class="btn btn-default check_out" href="{{url('/login-checkout')}}">Đặt hàng</a>
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
												echo '<p><li>Tổng giảm:'.number_format($total_coupon,0,',','.').'đ</li></p>';
												@endphp
											</p>
											<p><li>Tổng đã giảm :{{number_format($total-$total_coupon,0,',','.')}}đ</li></p>
										@elseif($cou['coupon_condition']==2)
											Mã giảm : {{number_format($cou['coupon_number'],0,',','.')}} k
											<p>
												@php
												$total_coupon = $total - $cou['coupon_number'];

												@endphp
											</p>
											<p><li>Tổng đã giảm :{{number_format($total_coupon,0,',','.')}}đ</li></p>
										@endif
									@endforeach
                                 </li>
                                 @endif

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
	</section> <!--/#cart_items-->

@endsection
