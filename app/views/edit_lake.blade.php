@extends('layouts.main_layout')
@section('head')
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('title')
    Sửa Ao nuôi
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
                        @if(Session::has('success_edit_lake'))
                            <div class="alert alert-success">{{Session::get('success_edit_lake')}}</div>
                        @endif
                        <form action="/edit-lake-action" method="post" class="form-horizontal">
                            <input type="text" class="span11" name="lake_id" value="{{$lake['lake_id']}}"
                                   style="visibility: hidden"/><input type="text" class="span11" name="season" value="{{$lake['season']}}"
                                                                      style="visibility: hidden"/>
                            <div class="control-group">
                                <label class="control-label">Tên Ao nuôi :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Ao tôm số 01" name="lake_name"
                                           value="{{$lake['lake_name']}}" required/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Số lượng con giống (con):</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="2000" name="amount_brood"
                                           value="{{$lake['amount_brood']}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Diện tích (m2):</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="1000" name="acreage"
                                           value="{{$lake['acreage']}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Mức nước (cm): </label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="1000" name="water_level"
                                           value="{{$lake['water_level']}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ngày thả: </label>
                                <div class="controls">
                                    <input id="datetimepicker" type="text" name="start_date"
                                           value="{{$lake['start_date']}}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nguồn giống: </label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="CP, Thông Thuận" name="seed_source"
                                           value="{{$lake['seed_source']}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Số lượng (con/kg): </label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="40" name="amount_per_kg"
                                           value="{{$lake['amount_per_kg']}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-group">
                                    <label class="control-label">Chú ý</label>
                                    <div class="controls">
                                        <textarea class="span11" name="note" onkeyup="textAreaAdjust(this)" rows="5">{{$lake['note']}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" name="btnSave" class="btn btn-success" value="save">Lưu</button>
                                <button type="submit" name="btnSave" class="btn btn-primary" value="save_exits">Lưu & thoát</button>
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
            format: 'd-m-Y H:i',
        });
        $('#datetimepicker1').datetimepicker({
            format: 'd-m-Y H:i'
        });
        function addNewRow(date) {
            var status_selected = $('#status').val();
            if (status_selected == 4) {
                var str = '<label class="control-label">Ngày bắt đầu đánh thuốc: </label>' +
                    '<div class="controls">' +
                    '<input id="datetimepicker1" type="text" name="drug_start_date" value="' + date + '" />' +
                    '</div>';
//                $('#drug_start_date_row').html(str);

            } else {
//                $('#drug_start_date_row').html('');
            }
        }
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25+o.scrollHeight)+"px";
        }
    </script>

@endsection