@extends('layoutmenu')

@section('title')
    รายละเอียดครุภัณฑ์
@endsection

@section('contentitle')
    <h4 class="page-title">รายละเอียดครุภัณฑ์</h4>
@endsection

@section('conten')
    <h2 class="text-center">รายการเเสดงรายละเอียดทรัพย์สิน</h2>

    <div class="container">
        <hr>
        <h5>ชื่อทรัพย์สิน: {{ $asset->asset_name }}</h5>
        <h5>ปีงบประมาณ: {{ $asset->asset_budget }}</h5>
        <h5>หน่วยงาน: {{ $asset->faculty_faculty_id }}</h5>
        <h5>ชื่อหน่วยงาน: {{ $asset->asset_major }}</h5>
        <h5>หน่วยงานย่อย: {{ $asset->room_building_id }}</h5>
        <h5>สถานที่ตั้ง: {{ $asset->asset_location }}</h5>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <h5>หมายเลขครุภัณฑ์: {{ $asset->asset_number }}</h5>
                <h5>สถานะ: {{ $asset->asset_status ? $asset->asset_status->asset_status_name : 'ไม่พบสถานะ' }}</h5>
                <h5>ยี่ห้อ: {{ $asset->asset_brand }}</h5>
            </div>
            <div class="col-md-6">
                <h5>ราคาต่อหน่วย: {{ number_format($asset->asset_price, 2) }}</h5>
                <h5>แหล่งเงิน: {{ $asset->asset_fund }}</h5>
                <h5>วิธีการได้มา: {{ $asset->asset_reception_type }}</h5>
            </div>
        </div>
    </div>
@endsection
