@extends('layouts.main_layout')
@section('head')
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('title')
    Danh mục thức ăn
@endsection
@section('head')
    <style>
        .paging_link ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        .paging_link li {
            float: left;
        }

        .paging_link li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        /* Change the link color to #111 (black) on hover */
        .paging_link li a:hover {
            background-color: #111;
        }
    </style>
@endsection
@section('main_content')

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Danh mục thức ăn</h5>
                    </div>
                    <div class="widget-content nopadding">
                        @if(Session::has('success_food_type_item'))
                            <div class="alert alert-success">{{Session::get('success_food_type_item')}}</div>
                        @endif
                        <form action="/add-food-type-item-action" method="post" class="form-horizontal">
                            <input type="text" id="category_id" name="category_id" style="visibility: hidden"/>
                            <div class="control-group">
                                <label class="control-label">Loại 1: </label>
                                <div class="controls">
                                    <select name="ftype" id="ftype">
                                        @for($k=0;$k<=15;$k++)
                                            <option value="{{$k}}">{{$k}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Loại 2:</label>
                                <div class="controls">
                                    <select name="ftype1" id="ftype1">
                                        @for($h=0;$h<=15;$h++)
                                            <option value="{{$h}}">{{$h}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tỉ lệ (L1/L2): </label>
                                <div class="controls">
                                    <select name="ratio" id="ratio">
                                        <option value="1-1">1</option>
                                        <option value="0.5-0.5">(1/2-1/2)</option>
                                        <option value="0.7-0.3">(1/3-2/3)</option>
                                        <option value="0.3-0.7">(2/3-1/3)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vị trí: </label>
                                <div class="controls">
                                    <input type="text" class="span8" placeholder="Vị trí" name="order" id="order"
                                           value="{{$order_max}}"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-file"></i> </span>
                        <h5>Danh mục thức ăn</h5>
                    </div>
                    @if(Session::has('success_del_food_type_item'))
                        <div class="alert alert-success">{{Session::get('success_del_food_type_item')}}</div>
                    @endif
                    <div class="widget-content nopadding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Tên thức ăn</th>
                                <th>Vị trí</th>
                                <th>Sửa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($food_types as $item)
                                <tr>
                                    <td><a href="#" onclick="updateCatalog('<?= $item['category_id']?>')">{{$item['category_name']}}</a>
                                    </td>
                                    <td style="text-align: right">{{$item['order']}}</td>
                                    <td style="text-align: center">
                                        <a href="#" onclick="updateCatalog('<?= $item['category_id']?>')"><span
                                                    class="icon-edit"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/date-time-picker/jquery.js"></script>
    <script src="js/date-time-picker/jquery.datetimepicker.full.min.js"></script>
    <script>
        function updateCatalog(cat_id) {

            var agrs = {
                url: "/get-food-type",
                type: "get",
                dateType: "text",
                data: {
                    category_id: cat_id
                },
                success: function (result) {

                    $('#order').val(result.order);

                    $('#ftype').val(result.ftype);
                    $('#ftype1').val(result.ftype1);
                    $('#category_id').val(result.category_id);
                    var ratio = result.value+"-"+result.value1;
                    $('#ratio').val(ratio);
                }
            };

            $.ajax(agrs);

        }

        $.datetimepicker.setLocale('vi');
        $('#datetimepicker').datetimepicker({
            timepicker: false,
            format: 'd-m-Y'
        });
    </script>
@endsection
