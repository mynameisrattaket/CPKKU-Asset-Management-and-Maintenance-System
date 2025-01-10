@extends('layoutmenu')

@section('title', 'คำร้องทั้งหมดในระบบครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title">คำร้องทั้งหมดในระบบครุภัณฑ์</h4>
@endsection

@section('conten')
<div class="container">
    <!-- ฟอร์มสำหรับค้นหา -->
    <form id="searchForm" action="{{ route('storeborrowrequest') }}" method="GET" class="mb-3">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="ค้นหาคำร้อง" name="searchrequest">
            <button class="btn btn-primary" type="submit">ค้นหา</button>
        </div>
        <div class="row g-2">
            <div class="col-md-3 col-6">
                <input type="text" class="form-control" placeholder="หมายเลขอุปกรณ์" name="asset_number">
            </div>
            <div class="col-md-3 col-6">
                <input type="text" class="form-control" placeholder="ชื่ออุปกรณ์" name="asset_name">
            </div>
            <div class="col-md-3 col-6">
                <input type="text" class="form-control" placeholder="ชื่อผู้ยืม" name="borrower_name">
            </div>
            <div class="col-md-3 col-6">
                <input type="text" class="form-control" placeholder="สถานะคำร้อง" name="status">
            </div>
        </div>
    </form>

    <!-- ตารางแสดงคำร้องทั้งหมด -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">ลำดับ</th>
                    <th style="width: 20%;">หมายเลขอุปกรณ์</th>
                    <th style="width: 20%;">ชื่ออุปกรณ์</th>
                    <th style="width: 15%;">ชื่อผู้ยืม</th>
                    <th style="width: 15%;">วันที่ยืม</th>
                    <th style="width: 15%;">วันที่คืน</th>
                    <th style="width: 10%;">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                @if($borrowRequests->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                    </tr>
                @else
                    @foreach($borrowRequests as $request)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $request->asset->asset_number ?? 'N/A' }}</td>
                        <td>{{ $request->asset->asset_name ?? 'N/A' }}</td>
                        <td>{{ $request->borrower_name ?? 'N/A' }}</td>
                        <td>{{ $request->borrow_date ?? 'N/A' }}</td>
                        <td>{{ $request->return_date ?? 'N/A' }}</td>
                        <td class="text-center">
                            @if($request->status == 'pending')
                                <span class="badge bg-warning">รอดำเนินการ</span>
                            @elseif($request->status == 'approved')
                                <span class="badge bg-success">อนุมัติ</span>
                            @elseif($request->status == 'rejected')
                                <span class="badge bg-danger">ถูกปฏิเสธ</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
