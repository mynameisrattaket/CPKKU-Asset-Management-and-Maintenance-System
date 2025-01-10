@extends('layoutmenu')

@section('title', 'ประวัติการยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title text-center">ประวัติการยืมครุภัณฑ์</h4>
@endsection

@section('conten')
<div class="container">
    <!-- ฟอร์มสำหรับค้นหา -->
    <form id="searchForm" action="{{ route('borrowhistory') }}" method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="ค้นหาครุภัณฑ์ (ชื่อ/หมายเลข)" name="searchasset" value="{{ request('searchasset') }}">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="ชื่อ-นามสกุล" name="borrower_name" value="{{ request('borrower_name') }}">
            </div>
            <div class="col-md-3 d-grid">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </div>
        </div>
        <div class="row g-2 mt-3">
            <div class="col-md-6">
                <label for="borrow_date" class="form-label">วันที่ยืม:</label>
                <input type="date" class="form-control" id="borrow_date" name="borrow_date" value="{{ request('borrow_date') }}">
            </div>
            <div class="col-md-6">
                <label for="return_date" class="form-label">วันที่คืน:</label>
                <input type="date" class="form-control" id="return_date" name="return_date" value="{{ request('return_date') }}">
            </div>
        </div>
    </form>

    <!-- ตารางแสดงผลลัพธ์การค้นหา -->
    <div class="table-responsive shadow-sm">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr class="text-center">
                    <th style="width: 5%;">ลำดับ</th>
                    <th style="width: 20%;">หมายเลขครุภัณฑ์</th>
                    <th style="width: 30%;">ชื่อครุภัณฑ์</th>
                    <th style="width: 20%;">ชื่อ-นามสกุล</th>
                    <th style="width: 15%;">วันที่ยืม</th>
                    <th style="width: 15%;">วันที่คืน</th>
                </tr>
            </thead>
            <tbody>
                @if($borrowRequests->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center text-muted">ไม่พบข้อมูล</td>
                    </tr>
                @else
                    @foreach($borrowRequests as $request)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $request->asset->asset_number ?? '-' }}</td>
                        <td>{{ $request->asset->asset_name ?? '-' }}</td>
                        <td>{{ $request->borrower_name }}</td>
                        <td>{{ $request->borrow_date ? \Carbon\Carbon::parse($request->borrow_date)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $request->return_date ? \Carbon\Carbon::parse($request->return_date)->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
