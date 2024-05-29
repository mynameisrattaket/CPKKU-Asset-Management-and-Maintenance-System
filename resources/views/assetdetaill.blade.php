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
            <div class="col-md-6">
                <h5>รหัสทรัพย์สิน : {{ $asset->asset_id }}</h5>
                <h5>รหัสครุภัณฑ์ : {{ $asset->asset_number }}</h5>
                <h5>ชื่อทรัพย์สิน : {{ $asset->asset_name }}</h5>
                <h5>คณะ/ศูนย์/สำนัก : {{ $asset->faculty }}</h5>
                <h5>คณะ/ศูนย์/สำนัก : {{ $asset->faculty }}</h5>
                <h5>หน่วยงานย่อย : {{ $asset->major }}</h5>
                <h5>สถานที่ตั้ง : {{ $asset->asset_location }}</h5>

            </div>
            <div class="col-md-6">
                <h5>สถานะ : {{ $asset->asset_status ? $asset->asset_status->asset_status_name : 'ไม่พบสถานะ' }}</h5>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h5>ประเภทการรับ : {{ $asset->asset_reception_type }}</h5>
                <h5>S/N No. : {{ $asset->asset_sn_number }}</h5>
                <h5>ราคาทรัพย์สิน : {{ $asset->asset_price }}</h5>
                <h5>ค่าเสื่อมราคาสะสม : {{ $asset->deteriorated_total }}</h5>
                <h5>ราคาซาก : {{ $asset->scrap_price }}</h5>
                <h5>บัญชีค่าเสื่อมราคา : {{ $asset->deteriorated_account  }}</h5>
                <h5>ค่าเสื่อม : {{ $asset->deteriorated }}</h5>
                <h5>วันที่เริ่มต้นคำนวณค่าเสื่อมราคา : {{ $asset->deteriorated_at }}</h5>
                <h5>วันที่หยุดการคำนวณค่าเสื่อมราคา : {{ $asset->asset_deteriorated_stop }}</h5>
                <h5>ที่มาของทรัพย์สิน : {{ $asset->asset_get }}</h5>
            </div>
            <div class="col">
                <h5>เลขที่เอกสาร : {{ $asset->asset_document_number }}</h5>
                <h5>หน่วยนับ : {{ $asset->asset_countingunit }}</h5>
                <h5>ค่าเสื่อมราคายกมา : {{ $asset->deteriorated_price }}</h5>
                <h5>ราคาตามบัญชี : {{ $asset->asset_price_account }}</h5>
                <h5>บัญชีทรัพย์สินถาวร : {{ $asset->asset_account }}</h5>
                <h5>บัญชีค่าเสื่อมราคาสะสม : {{ $asset->deteriorated_total_account  }}</h5>
                <h5>อายุการใช้งาน : {{ $asset->asset_live }} ปี</h5>
                <h5>วันที่สิ้นสุดคำนวณค่าเสื่อมราคา : {{ $asset->deteriorated_end }}</h5>
            </div>
        </div>
    </div>
@endsection
