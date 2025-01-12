@extends('layoutmenu')

@section('title', 'รายการยืมเสร็จสิ้น')

@section('contentitle')
    <h4 class="page-title">รายการการยืมเสร็จสิ้น</h4>
@endsection

@section('conten')
<div class="container">
    <table id="completedBorrowTable" class="table table-bordered mb-0">
        <thead class="table-dark">
            <tr>
                <th>ลำดับ</th>
                <th>หมายเลขอุปกรณ์</th>
                <th>ชื่ออุปกรณ์</th>
                <th>ชื่อผู้ยืม</th>
                <th>วันที่ยืม</th>
                <th>วันที่คืน</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($completedBorrows as $borrow)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $borrow->asset->asset_number ?? 'N/A' }}</td>
                    <td>{{ $borrow->asset->asset_name ?? 'N/A' }}</td>
                    <td>{{ $borrow->borrower_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->return_date)->format('d/m/Y') }}</td>
                    <td><span class="badge bg-success">เสร็จสิ้น</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
