@extends('layouts.main_layout')
@section('title')
    Ao nuôi
@endsection
@section('main_content')
    <?php setlocale(LC_MONETARY, "en_US");?>
    <div class="container-fluid">
        <div class="quick-actions_homepage">
            <ul class="quick-actions">
                @foreach($lakes as $key=>$value)
                    <?php
                    if (!empty($value['start_date'])) {
                        $old_date1 = new DateTime(date('d-m-Y', strtotime($value['start_date'])));
                        $new_date1 = new DateTime(date('d-m-Y', time()));
                        $interval1 = date_diff($new_date1, $old_date1);
                        $format1 = '- ' . $interval1->format('%a');
                    } else {
                        $format1 = "";
                    }

                    ?>
                    <li {{($value['status']==1?'class=bg_lh':'')}}{{($value['status']==2?'class=bg_lh':'')}}{{($value['status']==4?'class=bg_lr':'');}}{{($value['status']==5?'class=bg_lb':'');}}>
                        <a href="/edit-lake?id={{$value['lake_id']}}"> <i class="icon-dashboard"></i>
                            <span class="label label-success">{{number_format($value['amount_brood'],0)}}
                                /{{number_format($value['acreage'],0)}}</span>
                            <h4>{{$value['lake_name']}} ({{$value['seed_source']}} {{$format1}})</h4>
                            @if($value['start_date'] != '')
                                <h6 style="color: #ffffff">{{date('d-m-Y', strtotime($value['start_date']))}}</h6>
                            @else
                                <h6 style="color: #ffffff">&nbsp;</h6>
                            @endif
                            @if($value['status']==1 || $value['status']==2)
                                <span class="badge badge-inverse">Ao chưa nuôi</span>
                            @endif
                            @if($value['status']==4)
                                <span class="badge badge-inverse">Đang đánh thuốc</span>
                            @endif
                            @if($value['status']==5)
                                <span class="badge badge-inverse">Đang nuôi</span>
                            @endif
                            <?php
                                if ($value['drug_start_date'] != ''){
                                    $old_date = new DateTime(date('d-m-Y', strtotime($value['drug_start_date'])));
                                    $new_date = new DateTime(date('d-m-Y', time()));
                                    $interval = date_diff($new_date, $old_date);
                                    $format = $interval->format('%a');
                                }else{
                                    $format = 0;
                            }

                            ?>
                            @if($value['amount_per_kg'] != 0)
                                <h6 style="color: #ffffff">{{$value['amount_per_kg']}} con/kg</h6>
                            @else
                                <h6> &nbsp;</h6>
                            @endif

                            @if($value['drug_start_date'] != '')
                                <h6 style="color: #ffffff">{{$value['drug_start_date']}} - {{$format}} ngày thuốc</h6>
                            @else
                                <h6>&nbsp;</h6>
                            @endif
                            @if(@$notes[$value['lake_id']]['note'] != '')
                                <h6 style="color: #ffffff">{{Pretty::trim_text(@$notes[$value['lake_id']]['note'],70)}}</h6>
                            @else
                                <h6>&nbsp;</h6>
                            @endif
                        </a>
                    </li>
                @endforeach
                <li class="bg_lg"><a href="/form-add-lake"> <i class="icon-plus-sign"></i> <span
                                class="label label-warning"></span> Thêm mới ao nuôi </a>
                </li>
            </ul>
        </div>
    </div>
@endsection