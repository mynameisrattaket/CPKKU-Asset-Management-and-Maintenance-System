@extends('layoutmenu')

@section('title', 'ค้นหาครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title">ค้นหาข้อมูลครุภัณฑ์</h4>
@endsection

@section('conten')
<div class="container">
    <!-- ฟอร์มสำหรับค้นหา -->
    <form id="searchForm" action="{{ route('search') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="ค้นหาข้อมูลครุภัณฑ์" name="searchasset">
            <button class="btn btn-primary" type="submit">ค้นหา</button>
        </div>
        <div class="input-group mt-2">
            <input type="text" class="form-control" placeholder="ไอดี" name="asset_id">
            <input type="text" class="form-control" placeholder="หมายเลขครุภัณฑ์" name="asset_number">
            <input type="text" class="form-control" placeholder="ราคาต่อหน่วย" name="asset_price">
            <input type="text" class="form-control" placeholder="สถานะ" name="asset_asset_status_id">
        </div>
        <div class="input-group mt-2">
            <input type="text" class="form-control" placeholder="ยี่ห้อ" name="asset_brand">
            <input type="text" class="form-control" placeholder="ปีงบประมาณ" name="asset_budget">
        </div>
        <div class="input-group mt-2">
            <input type="text" class="form-control" placeholder="แหล่งเงิน" name="asset_fund">
            <input type="text" class="form-control" placeholder="สถานที่" name="asset_location">
            <input type="text" class="form-control" placeholder="วิธีการได้มา" name="asset_reception_type">
        </div>
    </form>

    <!-- ตารางแสดงผลลัพธ์การค้นหา -->
    <table id="assetTable" class="table table-bordered table-sm mt-4">
        <thead>
            <tr>
                <th>ไอดี</th>
                <th>หมายเลขครุภัณฑ์</th>
                <th>ชื่อครุภัณฑ์</th>
                <th>ราคาต่อหน่วย</th>
                <th>ยี่ห้อ</th>
                <th>สถานะ</th>
                <th>ปีงบประมาณ</th>
                <th>แหล่งเงิน</th>
                <th>สถานที่</th>
                <th>วิธีการได้มา</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asset_main as $karupan)
            <tr>
                <td>{{ $karupan->asset_id }}</td>
                <td>{{ $karupan->asset_number }}</td>
                <td>{{ $karupan->asset_name }}</td>
                <td>{{ $karupan->asset_price }}</td>
                <td>{{ $karupan->asset_brand }}</td>
                <td>{{ $karupan->asset_asset_status_id }}</td>
                <td>{{ $karupan->asset_budget }}</td>
                <td>{{ $karupan->asset_fund }}</td>
                <td>{{ $karupan->asset_location }}</td>
                <td>{{ $karupan->asset_reception_type }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
