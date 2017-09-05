@extends('layouts.main_layout')
@section('head')
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" />
@endsection
@section('title')
    Thêm mới ao nuôi
@endsection
@section('main_content')

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Thông tin ao nuôi</h5>
                    </div>
                    <div class="widget-content nopadding">
                        @if(Session::has('success_add_lake'))
                            <div class="alert alert-success">{{Session::get('success_add_lake')}}</div>
                        @endif
                        <form action="/add-lake-action" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Tên Ao nuôi :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Ao tôm số 01" name="lake_name" required/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Số lượng con giống (con):</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="2000" name="amount_brood" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Diện tích (m2):</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="1000" name="acreage" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Mức nước (cm): </label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="1000" name="water_level" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ngày thả: </label>
                                <div class="controls">
                                    <input id="datetimepicker" type="text" name="start_date" >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nguồn giống: </label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="CP, Thông Thuận" name="seed_source" />
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Lưu</button>
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
        $('#datetimepicker').datetimepicker();
    </script>
@endsection
