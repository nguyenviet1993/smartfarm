@extends('layouts.main_layout')
@section('head')
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('title')
    Vật tư
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
                        <h5>Tạo danh mục vật tư</h5>
                    </div>
                    <div class="widget-content nopadding">
                        @if(Session::has('success_catalog'))
                            <div class="alert alert-success">{{Session::get('success_catalog')}}</div>
                        @endif
                        <form action="/add-catalog-action" method="post" class="form-horizontal">
                            <input type="text" id="cat_id" name="cat_id" style="visibility: hidden" />
                            <div class="control-group">
                                <label class="control-label">Tên vật tư (*): </label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nhập tên vật tư" name="catalog_name" id="catalog_name"
                                           required/>
                                </div>
                            </div>
                            {{--<div class="control-group">--}}
                                {{--<label class="control-label">Mã (*):</label>--}}
                                {{--<div class="controls">--}}
                                    {{--<input type="text" class="span11" placeholder="PVC001" name="code" required/>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="control-group">--}}
                                {{--<label class="control-label">Giá (VNĐ):</label>--}}
                                {{--<div class="controls">--}}
                                    {{--<input type="text" class="span11" placeholder="1000" name="price"/>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="control-group">
                                <label class="control-label">Đơn vị:</label>
                                <div class="controls">
                                    <select name="unit_id" id="unit_id">
                                        @foreach($units as $unit)
                                            <option value="{{$unit['category_id']}}">{{$unit['category_name']}}</option>
                                        @endforeach
                                    </select>
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
                        <h5>Danh mục vật tư</h5>
                    </div>
                    @if(Session::has('success_delete_catalog'))
                        <div class="alert alert-success">{{Session::get('success_delete_catalog')}}</div>
                    @endif
                    <div class="widget-content nopadding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Tên vật tư</th>
                                <th>Đơn vị</th>
                                <th>Sửa</th>
                                {{--<th>Giá (VNĐ)</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($catalogs as $catalog)
                                <tr>
                                    <td><a href="#" onclick="updateCatalog('<?= $catalog['catalog_name']?>','<?= $catalog['cat_id']?>', '<?= $catalog['unit_id']?>')">{{$catalog['catalog_name']}}</a></td>
                                    <td style="text-align: right">{{$catalog['unit']}}</td>
                                    <td style="text-align: center">
{{--                                        <a href="/delete-catalog?id={{$catalog['cat_id']}}" onclick="return confirm('Bạn có muốn xóa danh mục vật tư không?')"><span class="icon-remove"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;--}}
                                        <a href="#" onclick="updateCatalog('<?= $catalog['catalog_name']?>','<?= $catalog['cat_id']?>', '<?= $catalog['unit_id']?>')"><span class="icon-edit"></span></a>
                                    </td>
                                    {{--<td style="text-align: right"><a href="#">{{number_format($catalog['price'],0)}}</a>--}}
                                    {{--</td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$catalogs->links()}}
                </div>
            </div>
        </div>
    </div>
    <script src="js/date-time-picker/jquery.js"></script>
    <script src="js/date-time-picker/jquery.datetimepicker.full.min.js"></script>
    <script>
        function updateCatalog(catalog_name, cat_id, unit_id) {
            $('#catalog_name').val(catalog_name);
            $('#cat_id').val(cat_id);
            $("#unit_id selected").val(unit_id);
            $('#unit_id option[value=' + unit_id + ']').attr('selected', 'selected');
        }

        $.datetimepicker.setLocale('vi');
        $('#datetimepicker').datetimepicker({
            timepicker: false,
            format: 'd-m-Y'
        });
    </script>
@endsection
