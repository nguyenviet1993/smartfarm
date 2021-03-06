<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css"/>
    <link rel="stylesheet" href="css/fullcalendar.css"/>
    <link rel="stylesheet" href="css/matrix-style.css"/>
    <link rel="stylesheet" href="css/matrix-media.css"/>
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/jquery.gritter.css"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/colorpicker.css"/>
    <link rel="stylesheet" href="css/datepicker.css"/>
    <link rel="stylesheet" href="css/uniform.css"/>
    <link rel="stylesheet" href="css/select2.css"/>
    <link rel="stylesheet" href="css/bootstrap-wysihtml5.css"/>
    @yield('head')
</head>
<body onload="time()">

<div id="header">
    <h1><a href="/">Trang chủ</a></h1>
</div>
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
        <li class="dropdown" id="profile-messages"><a title="" href="#" data-toggle="dropdown"
                                                      data-target="#profile-messages" class="dropdown-toggle"><i
                        class="icon icon-user"></i> <span
                        class="text">Chào {{\Illuminate\Support\Facades\Session::get('user.full_name')}}!</span><b
                        class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="/profile"><i class="icon-user"></i> Thông tin cá nhân</a></li>
                <li class="divider"></li>
                <li><a href="/logout"><i class="icon-key"></i> Đăng xuất</a></li>
            </ul>
        </li>
        <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages"
                                                   class="dropdown-toggle"><i class="icon icon-envelope"></i> <span
                        class="text">Tin nhắn</span> <span class="label label-important">5</span> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> tin nhắn mới</a></li>
                <li class="divider"></li>
                <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> hộp thư</a></li>
                <li class="divider"></li>
                <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> hộp thư đi</a></li>
                <li class="divider"></li>
                <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> thùng rác</a></li>
            </ul>
        </li>
        <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Cài đặt</span></a></li>
        <li class=""><a title="" href="/logout"><i class="icon icon-share-alt"></i> <span class="text">Đăng xuất</span></a>
        </li>
    </ul>
</div>
<div id="search">
    <input type="text" placeholder="Tìm kiếm..."/>
    <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<div id="sidebar"><a href="/home" class="visible-phone"><i class="icon icon-home"></i> Trang chủ</a>
    <ul>
        @if(Session::get('user.role') == CategoryDefine::$role_ql || Session::get('user.role') == CategoryDefine::$role_super_admin)
            <li {{ (Request::is('basic-building') ? "class='active submenu'" :Request::is('form-catalog') ? "class='active submenu'":Request::is('input-inventory') ? "class='active submenu'":'class=submenu')}}>
                <a href="#"><i class="icon icon-home"></i> <span>Xây dựng cơ bản</span></a>
                <ul>
                    <li><a href="/form-catalog">Tạo danh mục vật tư</a></li>
                    <li><a href="/input-inventory">Nhập kho vật tư</a></li>
                </ul>
            </li>
            <li {{ (Request::is('form-fee-catalog') ? "class='active submenu'" :Request::is('input-fee') ? "class='active submenu'":'class=submenu')}}>
                <a href="#"><i class="icon icon-money"></i> <span>Chi phí hàng tháng</span></a>
                <ul>
                    <li><a href="/form-fee-catalog">Tạo danh mục chi phí</a></li>
                    <li><a href="/input-fee">Nhập chi phí</a></li>
                </ul>
            </li>
            <li {{ (Request::is('food-analytic') ? "class='active submenu'"
        :Request::is('food-details') ? "class='active submenu'"
        :Request::is('drug-analytic') ? "class='active submenu'"
        :Request::is('drug-details') ? "class='active submenu'"
        :Request::is('fee-analytic') ? "class='active submenu'"
        :Request::is('fee-details') ? "class='active submenu'"
        :'class=submenu')}}>
                <a href="#"><i class="icon-time"></i> <span>Thống kê</span></a>
                <ul>
                    <li><a href="/food-analytic">Cho ăn</a></li>
                    <li><a href="/drug-analytic">Dùng thuốc</a></li>
                    <li><a href="/fee-analytic">Chi phí hàng tháng</a></li>
                </ul>
            </li>
            <li><a href="/statement"><i
                            class="icon-beaker"></i> <span>Quyết toán</span></a></li>
            <li {{ (Request::is('shrimp_harvesting') ? 'class=active' :'')}}><a href="/shrimp_harvesting"><i
                            class="icon-truck"></i> <span>Thu hoạch</span></a>
            </li>
            <li {{ (Request::is('users-manager') ? 'class=active' :Request::is('profile')?'class=active':'')}}><a
                        href="/users-manager"><i class="icon-group"></i> <span>Người dùng</span></a></li>
            <li {{ (Request::is('histories-nurturing-process') ? "class='active submenu'" :Request::is('histories-nha-process') ? "class='active submenu'":
        Request::is('histories-drug-process') ? "class='active submenu'":Request::is('histories-environment-index') ? "class='active submenu'":'class=submenu')}}>
                <a href="#"><i class="icon-time"></i> <span>Lịch sử</span></a>
                <ul>
                    <li><a href="/histories-nurturing-process">Cho ăn</a></li>
                    <li><a href="/histories-drug-process">Dùng thuốc</a></li>
                    <li><a href="/histories-nha-process">Kiểm tra Nhá</a></li>
                    <li><a href="/histories-environment-index">Chỉ số môi trường nuôi</a></li>
                    <li><a href="/histories-fees">Chi phí hàng tháng</a></li>
                </ul>
            </li>
        @endif
        @if(Session::get('user.role') == CategoryDefine::$role_nvcs || Session::get('user.role') == CategoryDefine::$role_super_admin)
            <li {{ (Request::is('nurturing-process') ? "class='active submenu'"
        :Request::is('nha-process')?"class='active submenu'"
        :Request::is('nurturing-process-admin')?"class='active submenu'"
        :Request::is('drug-process')?"class='active submenu'"
        :'class=submenu')}}>
                <a href="#"><i class="icon-bar-chart"></i> <span>Nhật ký nuôi</span></a>
                <ul>
                    <li><a href="/nurturing-process">Cho ăn</a></li>
                    <li><a href="/nurturing-process-admin">Cho ăn (AD)</a></li>
                    <li><a href="/drug-process">Dùng thuốc</a></li>
                    <li><a href="/nha-process">Kiểm tra Nhá</a></li>
                </ul>
            </li>
            <li {{ (Request::is('environment-index') ? 'class=active' :'')}}><a href="/environment-index"><i
                            class="icon-beaker"></i> <span>Chỉ số môi trường nuôi</span></a></li>
            <li {{ (Request::is('lakes') ? 'class=active' :'')}}><a href="/lakes"><i class="icon-dashboard"></i> <span>Thông tin Ao nuôi</span></a>
            </li>
        @endif
        @if(Session::get('user.role') == CategoryDefine::$role_admin || Session::get('user.role') == CategoryDefine::$role_super_admin)
            <li {{ (Request::is('form-drug-item') ? "class='active submenu'" :Request::is('form_add_drug_item1') ? "class='active submenu'":'class=submenu')}}>
                <a href="#"><i class="icon-wrench"></i> <span>Cấu hình danh mục</span></a>
                <ul>
                    <li><a href="/form-drug-item">Danh mục thuốc</a></li>
                    <li><a href="/form-eat-time-item">Danh mục giờ cho ăn</a></li>
                    <li><a href="form-food-type-item">Danh mục thức ăn</a></li>
                </ul>
            </li>
        @endif
    </ul>
</div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"><a href="/home" title="Thời gian hiện tại" class="tip-bottom"> <span class="text"
                                                                                                  id="clock"></span></a>
        </div>
    </div>
    @yield('main_content')
</div>

<div class="row-fluid">
    <div id="footer" class="span12"> 2017 &copy; copyright <a href="http://www.sunjsc.vn/">Sunvn</a></div>
</div>
{{--<script src="js/jquery.min.js"></script>--}}
{{--<script src="js/jquery.ui.custom.js"></script>--}}
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.uniform.js"></script>
@yield('select2js')
<script src="js/jquery.sparkline.js"></script>
<script src="js/matrix.js"></script>
<script src="js/matrix.form_common.js"></script>
<script src="js/wysihtml5-0.3.0.js"></script>
<script src="js/jquery.peity.min.js"></script>
<script src="js/bootstrap-wysihtml5.js"></script>
<script src="js/matrix.tables.js"></script>

<script type="text/javascript">
    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage(newURL) {

        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {

            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-") {
                resetMenu();
            }
            // else, send page to designated URL
            else {
                document.location.href = newURL;
            }
        }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }

    function time() {
        var today = new Date();
        var weekday = new Array(7);
        weekday[0] = "Chủ nhật";
        weekday[1] = "Thứ 2";
        weekday[2] = "Thứ 3";
        weekday[3] = "Thứ 4";
        weekday[4] = "Thứ 5";
        weekday[5] = "Thứ 6";
        weekday[6] = "Thứ 7";
        var day = weekday[today.getDay()];
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        nowTime = h + ":" + m + ":" + s;
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        today = day + ', ' + dd + '/' + mm + '/' + yyyy;

        tmp = '<span class="date">' + today + ' | ' + nowTime + '</span>';

        document.getElementById("clock").innerHTML = tmp;

        clocktime = setTimeout("time()", "1000", "JavaScript");
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
    }
</script>

</body>
</html>
