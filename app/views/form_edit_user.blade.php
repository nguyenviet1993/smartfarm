@extends('layouts.main_layout')
@section('title')
    Sửa người dùng
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
                        @if(Session::has('success_add_user'))
                            <div class="alert alert-success">{{Session::get('success_add_user')}}</div>
                        @endif
                        <form action="/edit-user-action" method="post" class="form-horizontal">
                            <input type="text" class="span11" placeholder="hoangnv" name="username" required
                                   value="{{$user['username']}}" style="visibility: hidden"/>
                            <div class="control-group">
                                <label class="control-label">Họ và tên :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nguyễn Văn Hoàng" name="full_name"
                                           value="{{$user['full_name']}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Địa chỉ</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Hà nội" name="address"
                                           value="{{$user['address']}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Số điện thoại</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="0986786789" name="phone_number"
                                           value="{{$user['phone_number']}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Email</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Email" name="email"
                                           value="{{$user['email']}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nhân viên</label>
                                <div class="controls">
                                    <select name="role">
                                        @foreach($roles  as $role)
                                            @if($role['code'] == $user['role'])
                                                <option value="{{$role['code']}}"
                                                        selected>{{$role['role_name']}}</option>
                                            @else
                                                <option value="{{$role['code']}}">{{$role['role_name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Chọn Ao quản lý</label>
                                <div class="controls">
                                    <select multiple name="lake_id[]">
                                        @foreach($lakes as $lake)
                                            <?php $selected = false?>
                                            @foreach($user_lake as $key=>$value)
                                                @if($key == $lake['lake_id'])
                                                    <?php $selected = true?>
                                                @endif
                                            @endforeach
                                            @if($selected)
                                                <option selected
                                                        value="{{$lake['lake_id'].'|'.$lake['lake_name']}}">{{$lake['lake_name']}}</option>
                                            @else
                                                <option value="{{$lake['lake_id'].'|'.$lake['lake_name']}}">{{$lake['lake_name']}}</option>
                                            @endif
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