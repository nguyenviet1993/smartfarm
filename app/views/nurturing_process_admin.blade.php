@extends('layouts.layout_not_jquery')
@section('title')
    Nhập thông tin trong ngày
@endsection
@section('head')
    <style>
        th, td {
            white-space: nowrap;
        }

    </style>
    <link type="text/css" rel="stylesheet" href="css/ui.notify.css" />
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
                        <form method="get" action="/nurturing-process-admin">
                            <input id="datetimepicker" type="text" name="date" onchange="submit(this.form)" value="{{@$select_date}}" >
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
                        <h5>Thông tin ngày <span style="color: red">{{$select_date}}</span></h5>
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
                                                        <th class="fixed-column">Lần</th>
                                                        <th></th>
                                                        <th>Thời gian</th>
                                                        <th>Số lượng thức ăn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id='table_repeat_{{$key}}'>
                                                    @for($j=0;$j<count(@$new_foods[$key]);$j++)
                                                        <tr class="odd gradeX"
                                                            id='col_repeat_{{$new_foods[$key][$j]['lake_id']}}{{$new_foods[$key][$j]['time']}}'>
                                                            <td class="fixed-row">{{$new_foods[$key][$j]['time']}}</td>
                                                            <td></td>
                                                            <td>
                                                                <select style="width: 60px;"
                                                                        id='HOUR_{{$new_foods[$key][$j]['lake_id']}}{{$new_foods[$key][$j]['time']}}'
                                                                        onchange="changeValueItem('<?= $new_foods[$key][$j]['time'] ?>', '<?php echo $new_foods[$key][$j]['lake_id']?>')">
                                                                    @for($k=1;$k<=24;$k++)
                                                                        @if($new_foods[$key][$j]['hour'] == $k)
                                                                            <option value="{{$k}}"
                                                                                    selected>{{$k}}</option>
                                                                        @else
                                                                            <option value="{{$k}}">{{$k}}</option>
                                                                        @endif
                                                                    @endfor
                                                                </select>
                                                                <select style="width: 60px;"
                                                                        id="MINUTE_{{$new_foods[$key][$j]['lake_id']}}{{$new_foods[$key][$j]['time']}}"
                                                                        onchange="changeValueItem('<?= $new_foods[$key][$j]['time'] ?>', '<?php echo $new_foods[$key][$j]['lake_id']?>')">
                                                                    @for($h=0;$h<=55;$h++)
                                                                        @if($new_foods[$key][$j]['minute'] == $h)
                                                                            <option value="{{$h}}"
                                                                                    selected>{{$h}}</option>
                                                                        @else
                                                                            <option value="{{$h}}">{{$h}}</option>
                                                                        @endif
                                                                        <?php $h += 4;?>
                                                                    @endfor
                                                                </select>
                                                            </td>
                                                            <td class="form-group">
                                                                <input type="number" class="input-val"
                                                                       id='FOOD_VAL_{{$new_foods[$key][$j]['lake_id']}}{{$new_foods[$key][$j]['time']}}'
                                                                       value="{{$new_foods[$key][$j]['food_val_1']+$new_foods[$key][$j]['food_val_2']}}"
                                                                       onchange="changeValueItem('<?= $new_foods[$key][$j]['time'] ?>', '<?php echo $new_foods[$key][$j]['lake_id']?>')"/>KG
                                                                <select style="width: auto;"
                                                                        id='FOOD_TYPE{{$new_foods[$key][$j]['lake_id']}}{{$new_foods[$key][$j]['time']}}'
                                                                        class="controls"
                                                                        onchange="changeValueItem('<?= $new_foods[$key][$j]['time'] ?>', '<?php echo $new_foods[$key][$j]['lake_id']?>')">

                                                                    @if($new_foods[$key][$j]['food_type_id']=='default')
                                                                        <option value="default" selected>Số</option>
                                                                        @foreach($food_types as $food_type)
                                                                            <option value="{{$food_type['category_id']}}">{{$food_type['category_name']}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="default">Số</option>
                                                                        @foreach($food_types as $food_type)
                                                                            @if($food_type['category_id']==$new_foods[$key][$j]['food_type_id'])
                                                                                <option value="{{$food_type['category_id']}}"
                                                                                        selected>{{$food_type['category_name']}}</option>
                                                                            @else
                                                                                <option value="{{$food_type['category_id']}}">{{$food_type['category_name']}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif

                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                    <?php $time = !empty($new_foods[$key]) ? (count($new_foods[$key]) + 1) : 1;?>
                                                    <tr class="odd gradeX" id='col_repeat_{{$key}}{{$time}}'>
                                                        <td class="fixed-row">{{$time}}</td>
                                                        <td></td>
                                                        <td>
                                                            <select style="width: 60px;" id='HOUR_{{$key}}{{$time}}'>
                                                                @for($k=1;$k<=24;$k++)
                                                                    @if($smart_time['type'][$time]['hour_value'] == $k)
                                                                        <option value="{{$k}}" selected>{{$k}}</option>
                                                                    @else
                                                                        <option value="{{$k}}">{{$k}}</option>
                                                                    @endif
                                                                @endfor
                                                            </select>
                                                            <select style="width: 60px;" id="MINUTE_{{$key}}{{$time}}">
                                                                @for($h=0;$h<=55;$h++)
                                                                    @if($smart_time['type'][$time]['minute_value'] == $h)
                                                                        <option value="{{$h}}" selected>{{$h}}</option>
                                                                    @else
                                                                        <option value="{{$h}}">{{$h}}</option>
                                                                    @endif
                                                                    <?php $h += 4;?>
                                                                @endfor
                                                            </select>
                                                        </td>
                                                        <td class="form-group">
                                                            <input type="number" class="input-val"
                                                                   id='FOOD_VAL_{{$key}}{{$time}}'
                                                                   onchange="addNewRow('<?= $time ?>', '<?php echo $key?>')"/>KG
                                                            <select style="width: auto;" id='FOOD_TYPE{{$key}}{{$time}}'
                                                                    class="controls">
                                                                <option value="default">Số</option>
                                                                @foreach($food_types as $food_type)
                                                                    <option value="{{$food_type['category_id']}}">{{$food_type['category_name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
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
    <div id="content">
        <!--- container to hold notifications, and default templates --->
        <div id="container" style="display:none">
            <div id="default">
                <h1>#{title}</h1>
                <p>#{text}</p>
            </div>
        </div>
    </div>
    <script>

        function addNote(lake_id) {
            var note = $('#note_' + lake_id).val();
            var date = $('#datetimepicker').val();
            var agrs = {
                url: "/add-note",
                type: "get",
                dateType: "text",
                data: {
                    lake_id: lake_id,
                    note: note,
                    date:date

                },
                success: function (result) {
//                    create("default", { title:'Thông báo', text:'Thành công!'});
                }
            };

            $.ajax(agrs);
        }

        function addNewRow(time_id, lake_id) {

            var data = '<?php echo json_encode($smart_time)?>';
            var smart_times = JSON.parse(data);

            var food_val = $('#FOOD_VAL_' + lake_id + time_id).val();
            $('#FOOD_VAL_' + lake_id + time_id).attr('value', food_val);
            $('#FOOD_VAL_' + lake_id + time_id).removeAttr('onchange');
            $('#FOOD_VAL_' + lake_id + time_id).attr('onchange', 'changeValueItem(\'' + time_id + '\',\'' + lake_id + '\')');

            var hour_val = $('#HOUR_' + lake_id + time_id).val();
            var str_hour = $('#HOUR_' + lake_id + time_id).html();
            $('#HOUR_' + lake_id + time_id).attr('value', hour_val);
            $('#HOUR_' + lake_id + time_id).removeAttr('onchange');
            $('#HOUR_' + lake_id + time_id).attr('onchange', 'changeValueItem(\'' + time_id + '\',\'' + lake_id + '\')');
            $('#HOUR_' + lake_id + time_id + ' option[value=' + hour_val + ']').attr('selected', 'selected');

            var minute_val = $('#MINUTE_' + lake_id + time_id).val();
            var str_minute = $('#MINUTE_' + lake_id + time_id).html();
            $('#MINUTE_' + lake_id + time_id).attr('value', minute_val);
            $('#MINUTE_' + lake_id + time_id).removeAttr('onchange');
            $('#MINUTE_' + lake_id + time_id).attr('onchange', 'changeValueItem(\'' + time_id + '\',\'' + lake_id + '\')');
            $('#MINUTE_' + lake_id + time_id + ' option[value=' + minute_val + ']').attr('selected', 'selected');

            //set selected
            var str_food_type = $('#FOOD_TYPE' + lake_id + time_id).html();
            var selected_type = $('#FOOD_TYPE' + lake_id + time_id).val();
            $('#FOOD_TYPE' + lake_id + time_id + ' option[value=' + selected_type + ']').attr('selected', 'selected');
            $('#FOOD_TYPE' + lake_id + time_id).attr('onchange', 'changeValueItem(\'' + time_id + '\',\'' + lake_id + '\')');

            var next_time = time_id;
            next_time++;
            var str = '';
            str += '<tr class="odd gradeX"> ' +
                '<td class="fixed-row">' + next_time + '</td>' +
                '<td></td>' +
                '<td> ' +
                '<select style="width: 60px;" id="HOUR_' + lake_id + next_time + '">' + str_hour + '</select> ';
            str += '<select style="width: 60px;" id="MINUTE_' + lake_id + next_time + '">' + str_minute + '</select>';
            str += '</td>' +
                '<td> ';
            str += '<input class="input-val" type="number" id="FOOD_VAL_' + lake_id + next_time + '" onchange="addNewRow(\'' + next_time + '\',\'' + lake_id + '\')" />KG' +
                '<select style="width: auto;" id="FOOD_TYPE' + lake_id + next_time + '" >' + str_food_type + '</select> ';
            str += '</td> ' +
                '</tr>';
            $('#table_repeat_' + lake_id).html($('#table_repeat_' + lake_id).html() + str);

            $('#HOUR_' + lake_id + next_time).find('option:selected').removeAttr("selected");
            $('#HOUR_' + lake_id + next_time + ' option[value=' + smart_times.type[next_time]['hour_value'] + ']').attr('selected', 'selected');
            $('#MINUTE_' + lake_id + next_time).find('option:selected').removeAttr("selected");
            $('#MINUTE_' + lake_id + next_time + ' option[value=' + smart_times.type[next_time]['minute_value'] + ']').attr('selected', 'selected');

            var date = $('#datetimepicker').val();
            //insert into database
            var food_type_id = $('#FOOD_TYPE' + lake_id + time_id).val();
            var food_val = $('#FOOD_VAL_' + lake_id + time_id).val();

            var agrs = {
                url: "/add-eat-to-lake",
                type: "get",
                dateType: "text",
                data: {
                    food_type_id: food_type_id,
                    time: time_id,
                    lake_id: lake_id,
                    food_val: food_val,
                    hour: hour_val,
                    minute: minute_val,
                    date:date
                },
                success: function (result) {
//                    create("default", { title:'Thông báo', text:'Thành công!'});
                }
            };

            $.ajax(agrs);
        }

        function changeValueItem(time_id, lake_id) {

            var selected_type = $('#FOOD_TYPE' + lake_id + time_id).val();
            $('#FOOD_TYPE' + lake_id + time_id + ' option[value=' + selected_type + ']').attr('selected', 'selected');

            var food_val = $('#FOOD_VAL_' + lake_id + time_id).val();
            $('#FOOD_VAL_' + lake_id + time_id).attr('value', food_val);

            var hour_val = $('#HOUR_' + lake_id + time_id).val();
            $('#HOUR_' + lake_id + time_id).attr('value', hour_val);

            var minute_val = $('#MINUTE_' + lake_id + time_id).val();
            $('#MINUTE_' + lake_id + time_id).attr('value', minute_val);
            var date = $('#datetimepicker').val();

            var agrs = {
                url: "/update-eat-to-lake",
                type: "get",
                dateType: "text",
                data: {
                    food_type_id: selected_type,
                    food_val: food_val,
                    time: time_id,
                    lake_id: lake_id,
                    hour: hour_val,
                    minute: minute_val,
                    date:date
                },
                success: function (result) {
//                    create("default", { title:'Thông báo', text:'Thành công!'});
                }
            };

            $.ajax(agrs);
        }

        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25 + o.scrollHeight) + "px";
        }
    </script>
    <script src="js/jquery/jquery.js" type="text/javascript"></script>
    <script src="js/jquery/jquery-ui.js" type="text/javascript"></script>
    <script src="js/jquery.notify.js" type="text/javascript"></script>

    <script type="text/javascript">
        function create( template, vars, opts ){
            return $container.notify("create", template, vars, opts);
        }

        $(function(){
            $container = $("#container").notify();

        });
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