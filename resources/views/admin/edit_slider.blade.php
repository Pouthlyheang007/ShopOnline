@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                  Update Slider
                </header>

                <div class="panel-body">

                    <div class="position-center">
            @foreach($edit_slider as $key =>$slider)
                        <form role="form" action="{{URL::to('/update-slider/'.$slider->slider_id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slider Title</label>
                            <input type="text" name="slider_title" class="form-control" id="exampleInputEmail1" value="{{$slider->slider_title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slider Image</label>
                            <input type="file" name="slider_image" class="form-control" id="exampleInputEmail1" >
                            <img src="{{URL::to('upload/slider/'.$slider->slider_image)}}" height="100" width="100">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Slider Description</label>
                            <textarea style="resize: none" rows="6" class="form-control" name="slider_desc" id="exampleInputPassword1" >{{$slider->slider_desc}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Hien thi</label>
                            <select name="slider_status" class="form-control input-sm m-bot15">
                                <option value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>

                            </select>
                        </div>

                        <button type="submit" name="add_slider" class="btn btn-info">Update Slider</button>
                    </form>
            @endforeach
                    </div>

                </div>
            </section>

    </div>
@endsection

