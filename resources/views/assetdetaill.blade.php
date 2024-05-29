@extends('layoutmenu')

@section('title')
    รายละเอียดครุภัณฑ์
@endsection

@section('breadcrumb')

@endsection

@section('contentitle')
    <h4 class="page-title">รายละเอียดครุภัณฑ์</h4>
@endsection

@section('conten')
    <h2 class="text-center">รายการเเสดงรายละเอียดทรัพย์สิน</h2>
    
    <div class="container">
        <hr>
        <h5>วันที่ลงทะเบียน : {{ $asset->asset_name }}</h5>
        <h5>เเผนงาน : {{ $asset->asset_plan }}</h5>
        <h5>โครงการ : {{ $asset->asset_project }}</h5>
        <h5>กิจกรรม : {{ $asset->asset_activity }}</h5>
        <h5>เเหล่งเงิน : {{ $asset->asset_budget }}</h5>
        <h5>กองทุน : {{ $asset->asset_fund }}</h5>
        <hr>
        <div class="row">
            <div class="col">
                <h5>รหัสทรัพย์สิน : {{ $asset->asset_id }}</h5>
            </div>
            <div class="col">
                {{-- <h5>สถาณะ : {{ $asset->status ? $asset->status->asset_status_name : 'ไม่พบสถาณะ' }}</h5> --}}
                <h5>สถาณะ : {{ $asset->asset_asset_status_id }}</h5>
            </div>
        </div>
    </div>
@endsection