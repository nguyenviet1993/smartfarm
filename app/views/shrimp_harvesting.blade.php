@extends('layouts.main_layout')
@section('title')
    Thu hoạch
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('main_content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span7">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Thu hoạch</h5>
                    </div>
                    <div class="widget-content nopadding">
                        @if(Session::has('success_add_harvesting'))
                            <div class="alert alert-success">{{Session::get('success_add_harvesting')}}</div>
                        @endif
                        <form action="/add-harvesting-action" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Khối lượng :</label>
                                <div class="controls">
                                    <input type="text" class="span10" placeholder="Nhập khối lượng" name="weigh"
                                           required/>&nbsp;(Kg)
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Số lượng :</label>
                                <div class="controls">
                                    <input type="text" class="span10" placeholder="Nhập kích thước" name="size"
                                    />&nbsp;(Con)
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Giá hiện tại</label>
                                <div class="controls">
                                    <input type="text" class="span10" placeholder="Nhập giá bán hiện tại"
                                           name="current_price" required/>&nbsp;(Vnđ/kg)
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Người mua</label>
                                <div class="controls">
                                    <select name="user_id">
                                        @foreach($users as $user)
                                            <option value="{{$user['user_id']}}">{{$user['full_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Loại tôm</label>
                                <div class="controls">
                                    <select name="type">
                                        <option value="TOM-SONG">Tôm sống</option>
                                        <option value="TOM-DA">Tôm đá</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Chọn Ao</label>
                                <div class="controls">
                                    <select name="lake">
                                        @foreach($lakes as $lake=>$item)
                                            <option value="{{$lake}}|{{$item}}">{{$item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ngày bán</label>
                                <div class="controls">
                                    <input id="datetimepicker" type="text" name="day_of_sale"
                                           value="<?=date('d-m-Y')?>"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Ghi chú</label>
                                <div class="controls">
                                    <textarea class="span10" name="note" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success"
                                        onclick="return confirm('Bạn có muốn thu hoạch không?')">Lưu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/date-time-picker/jquery.js"></script>
    <script src="js/date-time-picker/jquery.datetimepicker.full.min.js"></script>
    <script>
        $.datetimepicker.setLocale('vi');
        $('#datetimepicker').datetimepicker({
            format: 'd-m-Y',
            timepicker: false,
        });

    </script>
@endsection