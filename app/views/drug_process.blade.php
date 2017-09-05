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
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
    <link type="text/css" rel="stylesheet" href="css/ui.notify.css" />
@endsection
@section('main_content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Thông tin hôm nay</h5>
                    </div>
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
                    <div class="widget-content tab-content">
                        @foreach($lakes as $key=>$value)
                            @if($first == 1)
                                <div id="tab{{$key}}" class="tab-pane active">
                                    <?php $first = 2?>
                                    @else
                                        <div id="tab{{$key}}" class="tab-pane">
                                            @endif
                                            @if($new_lake[$key]['drug_start_date'] != '')
                                                <?php
                                                $old_date = new DateTime(date('d-m-Y', strtotime($new_lake[$key]['drug_start_date'])));
                                                $new_date = new DateTime(date('d-m-Y', time()));
                                                $interval = date_diff($new_date, $old_date);
                                                $format = $interval->format('%a');
                                                ?>
                                                Đánh thuốc từ ngày {{$new_lake[$key]['drug_start_date']}} được <span
                                                        style="color: red">{{$format}}</span> ngày
                                                <form action="/stop-drug-process" method="post">
                                                    <button type="submit" class="btn btn-success" onclick="return confirm('Bạn có muốn dừng đánh thuốc không?')">Dừng đánh thuốc</button>
                                                    <input type="text" value="{{$key}}" name="lake_id" style="visibility: hidden; width: 20px">
                                                </form>

                                            @endif
                                            <div class="widget-content nopadding">
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
                                                                <select style="width: 60px;"
                                                                        id='HOUR_{{$new_drugs[$key][$j]['lake_id']}}{{$new_drugs[$key][$j]['time']}}'
                                                                        onchange="changeValueItem('<?= $new_drugs[$key][$j]['time'] ?>', '<?php echo $new_drugs[$key][$j]['lake_id']?>')">
                                                                    @for($k=1;$k<=24;$k++)
                                                                        @if($new_drugs[$key][$j]['hour'] == $k)
                                                                            <option value="{{$k}}"
                                                                                    selected>{{$k}}</option>
                                                                        @else
                                                                            <option value="{{$k}}">{{$k}}</option>
                                                                        @endif
                                                                    @endfor
                                                                </select>
                                                                <select style="width: 60px;"
                                                                        id="MINUTE_{{$new_drugs[$key][$j]['lake_id']}}{{$new_drugs[$key][$j]['time']}}"
                                                                        onchange="changeValueItem('<?= $new_drugs[$key][$j]['time'] ?>', '<?php echo $new_drugs[$key][$j]['lake_id']?>')">
                                                                    @for($h=0;$h<=50;$h++)
                                                                        @if($new_drugs[$key][$j]['minute'] == $h)
                                                                            <option value="{{$h}}"
                                                                                    selected>{{$h}}</option>
                                                                        @else
                                                                            <option value="{{$h}}">{{$h}}</option>
                                                                        @endif
                                                                        <?php $h += 9;?>
                                                                    @endfor
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select id='DRUG{{$new_drugs[$key][$j]['lake_id']}}{{$new_drugs[$key][$j]['time']}}'
                                                                        style="width: auto;"
                                                                        onchange="changeValueItem('<?= $new_drugs[$key][$j]['time'] ?>', '<?php echo $new_drugs[$key][$j]['lake_id']?>')">
                                                                    <option value="default">Thuốc</option>
                                                                    @foreach($drugs as $drug)
                                                                        @if($drug['category_id'] == $new_drugs[$key][$j]['drug_id'])
                                                                            <option value="{{$drug['category_id']}}"
                                                                                    selected>{{$drug['category_name']}}</option>
                                                                        @else
                                                                            <option value="{{$drug['category_id']}}">{{$drug['category_name']}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <input type="number" class="input-val"
                                                                       value="{{$new_drugs[$key][$j]['amount']}}"
                                                                       id='DRUG_VAL{{$new_drugs[$key][$j]['lake_id']}}{{$new_drugs[$key][$j]['time']}}'
                                                                       onchange="changeValueItem('<?= $new_drugs[$key][$j]['time'] ?>', '<?php echo $new_drugs[$key][$j]['lake_id']?>')"/>KG
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                    <?php $time = !empty($new_drugs[$key]) ? (count($new_drugs[$key]) + 1) : 1;?>
                                                    <tr class="odd gradeX" id='col_repeat_{{$key}}{{$time}}'>
                                                        <td>
                                                            <select style="width: 60px;" id='HOUR_{{$key}}{{$time}}'>
                                                                @for($k=1;$k<=24;$k++)
                                                                    <option value="{{$k}}">{{$k}}</option>
                                                                @endfor
                                                            </select>
                                                            <select style="width: 60px;" id="MINUTE_{{$key}}{{$time}}">
                                                                @for($h=0;$h<=50;$h++)
                                                                    <option value="{{$h}}">{{$h}}</option>
                                                                    <?php $h += 9;?>
                                                                @endfor
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select id='DRUG{{$key}}{{$time}}' style="width: auto;">
                                                                <option value="default">Thuốc</option>
                                                                @foreach($drugs as $drug)
                                                                    <option value="{{$drug['category_id']}}">{{$drug['category_name']}}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="number" class="input-val"
                                                                   id='DRUG_VAL{{$key}}{{$time}}'
                                                                   onchange="addNewRow('<?= $time ?>', '<?php echo $key?>')"/>KG
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
            var agrs = {
                url: "/add-note",
                type: "get",
                dateType: "text",
                data: {
                    lake_id: lake_id,
                    note: note

                },
                success: function (result) {
//                    create("default", { title:'Thông báo', text:'Thành công!'});
                }
            };

            $.ajax(agrs);
        }

        function addNewRow(time_id, lake_id) {

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

            var drug_val = $('#DRUG_VAL' + lake_id + time_id).val();
            $('#DRUG_VAL' + lake_id + time_id).attr('value', drug_val);
            $('#DRUG_VAL' + lake_id + time_id).removeAttr('onchange');
            $('#DRUG_VAL' + lake_id + time_id).attr('onchange', 'changeValueItem(\'' + time_id + '\',\'' + lake_id + '\')');


            var str_drug = $('#DRUG' + lake_id + time_id).html();
            var selected_drug = $('#DRUG' + lake_id + time_id).val();
            $('#DRUG' + lake_id + time_id + ' option[value=' + selected_drug + ']').attr('selected', 'selected');
            $('#DRUG' + lake_id + time_id).attr('onchange', 'changeValueItem(\'' + time_id + '\',\'' + lake_id + '\')');

            var next_time = time_id;
            next_time++;
            var str = '';
            str += '<tr class="odd gradeX"> ' +
                '<td> ' +
                '<select style="width: 60px;" id="HOUR_' + lake_id + next_time + '">' + str_hour + '</select> ';
            str += '<select style="width: 60px;" id="MINUTE_' + lake_id + next_time + '">' + str_minute + '</select>';
            str += '</td>';
            str += '<td> ' +
                '<select id="DRUG' + lake_id + next_time + '" style="width: auto">' + str_drug + '</select> ';
            str += '<input class="input-val" type="number" id="DRUG_VAL' + lake_id + next_time + '"' + ' onchange="addNewRow(\'' + next_time + '\',\'' + lake_id + '\')" />KG' +
                '</td> ' +
                '</tr>';
            $('#table_repeat_' + lake_id).html($('#table_repeat_' + lake_id).html() + str);

            var drug = $('#DRUG' + lake_id + time_id).val();

            var drug_val = $('#DRUG_VAL' + lake_id + time_id).val();

            var agrs = {
                url: "/add-drug-to-lake",
                type: "get",
                dateType: "text",
                data: {
                    time: time_id,
                    lake_id: lake_id,
                    hour: hour_val,
                    minute: minute_val,
                    drug_id: drug,
                    amount: drug_val,
                },
                success: function (result) {
//                    create("default", { title:'Thông báo', text:'Thành công!'});
                }
            };

            $.ajax(agrs);
        }

        function changeValueItem(time_id, lake_id) {

            var hour_val = $('#HOUR_' + lake_id + time_id).val();
            $('#HOUR_' + lake_id + time_id).attr('value', hour_val);

            var minute_val = $('#MINUTE_' + lake_id + time_id).val();
            $('#MINUTE_' + lake_id + time_id).attr('value', minute_val);

            var selected_drug = $('#DRUG' + lake_id + time_id).val();
            $('#DRUG' + lake_id + time_id + ' option[value=' + selected_drug + ']').attr('selected', 'selected');
            var drug_val = $('#DRUG_VAL' + lake_id + time_id).val();
            $('#DRUG_VAL' + lake_id + time_id).attr('value', drug_val);

            var agrs = {
                url: "/update-drug-to-lake",
                type: "get",
                dateType: "text",
                data: {
                    time: time_id,
                    lake_id: lake_id,
                    hour: hour_val,
                    minute: minute_val,
                    drug_id: selected_drug,
                    drug_val: drug_val
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
@endsection


