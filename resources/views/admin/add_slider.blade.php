@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   Slider
                </header>
                <div class="panel-body">

                    <div class="position-center">
                        <form role="form" action="{{URL::to('/save-slider')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slider title</label>
                            <input type="text" name="slider_title" class="form-control" id="exampleInputEmail1" placeholder="Titale slider">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slider image</label>
                            <input type="file" name="slider_image" class="form-control" id="exampleInputEmail1" >
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Slider Description</label>
                            <textarea style="resize: none" rows="6" class="form-control" name="slider_desc" id="exampleInputPassword1"  placeholder="Mô tả slider"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Hien thi</label>
                            <select name="slider_status" class="form-control input-sm m-bot15">
                                <option value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>

                            </select>
                        </div>

                             <button type="submit" name="add_slider" class="btn btn-info">Add Slider</button>
                         </form>
                    </div>
                </div>
            </section>

    </div>
@endsection

