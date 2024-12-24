@extends('layoutmenu')

@section('title', 'ค้นหาครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title">ค้นหาข้อมูลครุภัณฑ์</h4>
@endsection

@section('conten')
<div class="container">
    <!-- ฟอร์มสำหรับค้นหา -->
    <form id="searchForm" action="{{ route('searchasset') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="ค้นหาข้อมูลครุภัณฑ์" aria-label="ค้นหาข้อมูลครุภัณฑ์" aria-describedby="button-addon2" name="searchasset">
            <button class="btn btn-primary" type="submit" id="button-addon2">ค้นหา</button>
        </div>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="หมายเลขครุภัณฑ์" aria-label="หมายเลขครุภัณฑ์" aria-describedby="button-addon2" name="asset_number">
            <input type="text" class="form-control" placeholder="ราคาต่อหน่วย" aria-label="ราคาต่อหน่วย" aria-describedby="button-addon2" name="asset_price">
            <input type="text" class="form-control" placeholder="สถานะ" aria-label="สถานะ" aria-describedby="button-addon2" name="asset_asset_status_id">
            <input type="text" class="form-control" placeholder="คอมเมนต์" aria-label="คอมเมนต์" aria-describedby="button-addon2" name="asset_comment">
        </div>
    </form>
    <!-- ตารางแสดงผลลัพธ์การค้นหา -->
    <table class="table">
        <thead>
            <tr>
                <th>ชื่อครุภัณฑ์</th>
                <th>หมายเลขครุภัณฑ์</th>
                <th>ราคาต่อหน่วย</th>
                <th>สถานะ</th>
                <th>คอมเมนต์</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asset_main as $karupan)
            <tr>
                <td>{{ $karupan->asset_name }}</td>
                <td>{{ $karupan->asset_number }}</td>
                <td>{{ $karupan->asset_price }}</td>
                <td>{{ $karupan->asset_asset_status_id }}</td>
                <td>{{ $karupan->asset_comment }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
