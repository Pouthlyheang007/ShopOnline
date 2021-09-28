@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
       Liệt kê customer
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
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Customer name</th>
              <th>Customer email</th>
              <th>Customer phone</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
        @foreach($all_customer as $key => $customer)
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$customer->customer_name}}</td>
              <td>{{$customer->customer_email}}</td>
              <td>{{$customer->customer_phone}}</td>
              <td><span class="text-ellipsis">

               </span></td>
              <td>

                 <a onclick="return confirm('Bạn có chắc là muồn xóa sản phẩm này không')" href="{{URL::to('/delete-product/'.$customer->customer_id)}}" class="active styling-edit" ui-toggle-class="">
                    <i class="fa fa-times text-danger text"></i>
                </a>
              </td>
            </tr>
        @endforeach
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">

      </footer>
    </div>
  </div>

@endsection

