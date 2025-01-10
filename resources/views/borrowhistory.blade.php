@extends('layoutmenu')

@section('title', 'ประวัติการยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title">ประวัติการยืมครุภัณฑ์</h4>
@endsection

@section('conten')
<div class="container">
    <!-- ฟอร์มสำหรับค้นหา -->
    <form id="searchForm" action="{{ route('searchasset') }}" method="GET" class="mb-3">
        <div class="input-group mb-2">
            <input type="text" class="form-control" placeholder="ค้นหาครุภัณฑ์" name="searchasset">
            <button class="btn btn-primary" type="submit">ค้นหา</button>
        </div>
        <div class="row">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="หมายเลขครุภัณฑ์" name="asset_number">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="ชื่อครุภัณฑ์" name="asset_name">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="สถานที่" name="location">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="หมายเหตุ" name="asset_comment">
            </div>
        </div>
    </form>

    <!-- ตารางแสดงผลลัพธ์การค้นหา -->
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 5%;">ลำดับ</th>
                <th style="width: 20%;">หมายเลขครุภัณฑ์</th>
                <th style="width: 30%;">ชื่อครุภัณฑ์</th>
                <th style="width: 20%; text-align: center;">สถานที่</th>
                <th style="width: 25%; text-align: center;">หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @if($assets->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">ไม่พบข้อมูล</td>
                </tr>
            @else
                @foreach($assets as $asset)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $asset->asset_number }}</td>
                    <td>{{ $asset->asset_name }}</td>
                    <td class="text-center">{{ $asset->location }}</td>
                    <td class="text-center">{{ $asset->asset_comment }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

@endsection
