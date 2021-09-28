@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
       List Slider
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
              <th>Slider Title</th>
              <th>Slider Description</th>
              <th>Slider image</th>
              <th>Hiển thị/Ẩn</th>

              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
        @foreach($all_slider as $key => $slider)
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$slider->slider_title}}</td>
              <td>{{$slider->slider_desc}}</td>
              <td><img src="upload/slider/{{ $slider->slider_image}}" height="100" width="100"></td>
              <td><span class="text-ellipsis">
                <?php
                if ($slider->slider_status==0){
                ?>
                    <a href="{{URL::to('/unactive-slider/'.$slider->slider_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                <?php
                 }else{
                ?>
                   <a href="{{URL::to('/active-slider/'.$slider->slider_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                <?php
                }
                ?>
               </span></td>
              <td>
                <a href="{{URL::to('/edit_slider/'.$slider->slider_id)}}" class="active styling-edit" ui-toggle-class="" >
                    <i class="fa fa-pencil-square-o text-success text-active"></i> </a>
                 <a onclick="return confirm('Bạn có chắc là muồn xóa slide này không')" href="{{URL::to('/delete-slider/'.$slider->slider_id)}}" class="active styling-edit" ui-toggle-class="">
                    <i class="fa fa-times text-danger text"></i>
                </a>
              </td>
            </tr>
        @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection

