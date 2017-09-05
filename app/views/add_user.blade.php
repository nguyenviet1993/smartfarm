@extends('layouts.main_layout')
@section('title')
    Thêm người dùng mới
@endsection
@section('main_content')

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Thông tin người dùng</h5>
                    </div>
                    <div class="widget-content nopadding">
                        @if(Session::has('error_add_user'))
                            <div class="alert alert-error">{{Session::get('error_add_user')}}</div>
                        @endif
                        @if(Session::has('success_add_user'))
                            <div class="alert alert-success">{{Session::get('success_add_user')}}</div>
                        @endif
                        <form action="/add-user-action" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Họ và tên :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nguyễn Văn Hoàng" name="full_name"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tên đăng nhập :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="hoangnv" name="username" required/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Địa chỉ</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Hà nội" name="address"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Số điện thoại</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="0986786789" name="phone_number"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Email</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Email" name="email"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nhân viên</label>
                                <div class="controls">
                                    <select name="role">
                                        @foreach($roles  as $role)
                                            <option value="{{$role['code']}}">{{$role['role_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Chọn Ao quản lý</label>
                                <div class="controls">
                                    <select multiple name="lake_id[]">
                                        @foreach($lakes as $lake)
                                            <option value="{{$lake['lake_id'].'|'.$lake['lake_name']}}">{{$lake['lake_name']}}</option>
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
        </div>
    </div>
@endsection
@section('select2js')
    <script src="js/select2.min.js"></script>
@endsection