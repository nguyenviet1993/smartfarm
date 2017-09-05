@extends('layouts.main_layout')
@section('title')
    Nhập thông tin trong ngày
@endsection
@section('head')
    <style>
        th, td {
            white-space: nowrap;
        }


    </style>
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('main_content')
    <style>
        .fixed-column {
            width: 22px !important;
            position: absolute;
            margin-left: -15px;
            background: #EFEFEF !important;
            /*border-right: solid 1px #DDDDDD;*/
        }

        .fixed-row {
            width: 15px;
            position: absolute;
            margin-left: -15px;
            height: 40px !important;
            /*border-right: solid 1px #DDDDDD;*/
            background: #F9F9F9 !important;
        }
    </style>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="control-group">
                    <label class="control-label">Chọn ngày: </label>
                    <div class="controls">
                        <form method="get" action="/histories-drug-process">
                            <input id="datetimepicker" type="text" name="date" onchange="submit(this.form)"
                                   value="{{@$select_date}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Thông tin <span style="color: red">{{@$select_date}}</span></h5>
                    </div>
                    {{--<div class="widget-title">--}}
                    <ul class="nav nav-tabs">
                        <?php $first = 0?>
                        @foreach($lakes as $key=>$value)
                            @if($first == 0)
                                <li class="active"><a data-toggle="tab" href="#tab{{$key}}">{{$value}}</a></li>
                                <?php $first = 1;?>
                            @else
                                <li><a data-toggle="tab" href="#tab{{$key}}">{{$value}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                    {{--</div>--}}
                    <div class="widget-content tab-content">
                        @foreach($lakes as $key=>$value)
                            @if($first == 1)
                                <div id="tab{{$key}}" class="tab-pane active">
                                    <?php $first = 2?>
                                    @else
                                        <div id="tab{{$key}}" class="tab-pane">
                                            @endif
                                            <div class="widget-content nopadding">
                                                @if(Session::has('success_add_eat'))
                                                    <div class="alert alert-success">{{Session::get('success_add_eat')}}</div>
                                                @endif
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Thời gian</th>
                                                        <th>Dùng thuốc</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id='table_repeat_{{$key}}'>
                                                    @for($j=0;$j<count(@$new_drugs[$key]);$j++)
                                                        <tr class="odd gradeX"
                                                            id='col_repeat_{{$new_drugs[$key][$j]['lake_id']}}{{$new_drugs[$key][$j]['time']}}'>
                                                            <td>
                                                                <label class="control-label" style="text-align: center">{{$new_drugs[$key][$j]['hour']}}h {{$new_drugs[$key][$j]['minute']}}'</label>
                                                            </td>
                                                            <td>
                                                                <label class="control-label" style="text-align: center">{{$new_drugs[$key][$j]['amount']}}Kg - {{$new_drugs[$key][$j]['drug_name']}}</label>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="control-group warning" style="margin-left: 17px">
                                                <label class="control-label">Chú ý</label>
                                                <div class="controls">
                                                    <textarea class="span11" name="note" rows="5" id="note_{{$key}}"
                                                              onchange="addNote('<?php echo $key?>')"
                                                              onkeyup="textAreaAdjust(this)">{{@$notes[$key]}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        function addNote(lake_id) {
            var note = $('#note_' + lake_id).val();
            var agrs = {
                url: "/add-note",
                type: "get",
                dateType: "text",
                data: {
                    lake_id: lake_id,
                    note: note

                },
                success: function (result) {
                    alert('Thành công!');
                }
            };

            $.ajax(agrs);
        }

        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
    </script>

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