
@extends('layout')
@section('content')

    <section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li class="active"><a href=""> Giỏ hàng của bạn</a></li>
				</ol>
			</div>
{{-- message --}}
            @if(session()->has('message'))
                <div class="alert alert-success">
                     {{ session()->get('message') }}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                     {{ session()->get('error') }}
                </div>
            @endif
{{-- end message --}}
			<div class="table-responsive cart_info">
            <form action="{{URL::to('/update-cart')}}" method="POST">
                {{ csrf_field() }}
				<table class="table table-condensed" >
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh sản phẩm</td>
							<td class="description">Tên sản phẩm</td>
							<td class="price">giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Tổng tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
                     @if(Session::get('cart')==true)
                        @php
                            $total = 0;
                        @endphp

						@foreach(Session::get('cart') as $key => $cart)

                         @php
                             $subtotal = (int) $cart['product_price'] * (int) $cart['product_qty'];
                             $total+=$subtotal;
                         @endphp

						<tr>
							<td class="cart_product">
								<a href=""><img src="{{asset('upload/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}"></a>
							</td>
							<td class="cart_description">
								 <h4><a href="">{{$cart['product_name']}}</a></h4>
                                <p>{{$cart['product_id']}}</p>
							</td>
							<td class="cart_price">
								<p>{{$cart['product_price']}}đ</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">

									<input class="cart_quantity" type="number" min="1" name="update_cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  >

								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
                                    {{$subtotal}}
                                </p>
							</td>

							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('/delete-cart/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>

                        @endforeach
                        <tr>
                            <td> <input type="submit" value="Cập nhật giỏ hàng" name="update_qty"
                                class="check_out btn btn-default btn-sm">
                            </td>
                            <td>
                                <a class="btn btn-default check_out" href="{{URL::to('/delete-all-cart')}}">Xóa tất cả giỏ hàng</a>
                            </td>
                            <td>
                                 <li>Tổng tiền : <span>{{$total}}</span></li>
                                 <li>Thuế <span>{{Cart::tax().' '.'vnđ'}}</span></li>
                                 <li>Phí vận chuyển <span></span></li>
                                 <li>Tiền sau giảm <span>{{Cart::total().' '.'vnđ'}}</span></li>
                                 <td>
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
                            </td>
                        </tr>
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
                </form>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

    {{-- <section id="do_action">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Tổng tiền : <span>{{$total}}</span></li>
                            <li>Thuế <span></span></li>
                            <li>Phí vận chuyển <span></span></li>
                            <li>Tiền sau giảm <span></span></li>
						</ul>

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

					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action--> --}}
    @endsection
