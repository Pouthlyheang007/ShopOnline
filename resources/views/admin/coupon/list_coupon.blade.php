@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê mã giảm giá
    </div>

    <div class="table-responsive">
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
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>


            <th>Tên mã giảm giá</th>
            <th>Mã giảm giá</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Số lượng giảm giá</th>
            <th>Điều kiện giảm giá</th>
            <th>Số giảm</th>
            <th>Tình trạng</th>
            <th>Thời hạn</th>
            <td>Quản lý</td>
            <th>Gửi mã</th>



          </tr>
        </thead>
        <tbody>
          @foreach($coupon as $key => $cou)
          <tr>

            <td>{{ $cou->coupon_name }}</td>
            <td>{{ $cou->coupon_code }}</td>
            <td>{{ $cou->coupon_date_start }}</td>
            <td>{{ $cou->coupon_date_end }}</td>
            <td><span class="text-ellipsis">
                <?php
                if($cou->coupon_time>0){
                  ?>
                  <span style="color:green">{{ $cou->coupon_time}}</span>
                  <?php
                }else{
                  ?>
                  <span style="color:red">Đã hết</span>
                  <?php
                }
                ?>
              </span>
            </td>
            <td><span class="text-ellipsis">
              <?php
               if($cou->coupon_condition==1){
                ?>
                Giảm theo %
                <?php
                 }else{
                ?>
                Giảm theo tiền
                <?php
               }
              ?>
            </span>
          </td>

             <td><span class="text-ellipsis">
              <?php
               if($cou->coupon_condition==1){
                ?>
                Giảm {{$cou->coupon_number}} %
                <?php
                 }else{
                ?>
                Giảm {{$cou->coupon_number}} k
                <?php
               }
              ?>
            </span></td>

            <td><span class="text-ellipsis">
                <?php
                if($cou->coupon_status==1){
                  ?>
                  <span style="color:green">Đang kích hoạt</span>
                  <?php
                }else{
                  ?>
                  <span style="color:red">Đã khóa</span>
                  <?php
                }
                ?>
              </span>
            </td>

            <td>
                @if($cou->coupon_date_end>=$today)
                <span style="color:green">Còn hạn</span>
                @else
                <span style="color:red">Đã hết hạn</span>
                @endif
              </td>

            <td>

              <a onclick="return confirm('Bạn có chắc là muốn xóa mã này ko?')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>

            <td>

                <p><a href="{{url('/send-coupon-vip', [

                  'coupon_time'=> $cou->coupon_time,
                  'coupon_condition'=> $cou->coupon_condition,
                  'coupon_number'=> $cou->coupon_number,
                  'coupon_code'=> $cou->coupon_code


                ])}}" class="btn btn-primary" style="margin:5px 0;">Gửi giảm giá khách vip</a></p>
                <p><a href="{{url('/send-coupon',[


                  'coupon_time'=> $cou->coupon_time,
                  'coupon_condition'=> $cou->coupon_condition,
                  'coupon_number'=> $cou->coupon_number,
                  'coupon_code'=> $cou->coupon_code


                ])}}" class="btn btn-default">Gửi giảm giá khách thường</a></p>


             </td>

          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">

        <div class="col-sm-5 text-center">

          </div>
          <div class="col-sm-7 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
             {!!$coupon->links()!!}
           </ul>
         </div>
      </div>
    </footer>
  </div>
</div>
@endsection
