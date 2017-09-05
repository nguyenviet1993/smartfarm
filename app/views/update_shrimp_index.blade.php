@extends('layouts.main_layout')
@section('head')
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" />
@endsection
@section('title')
    Cập nhật chỉ số vật nuôi
@endsection
@section('main_content')

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Cập nhật chỉ số vật nuôi</h5>
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
                                <label class="control-label">Số lượng (con/kg):</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="2000" name="amount" />
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
