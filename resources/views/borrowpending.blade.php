@extends('layoutmenu')

@section('title', 'รายการคำร้องรอดำเนินการ')

@section('contentitle')
    <h4 class="page-title">รายการคำร้องรอดำเนินการ</h4>
@endsection

@section('conten')
<div class="container">
    <!-- ฟอร์มค้นหาและตัวกรอง -->
    <form id="searchForm" action="{{ route('borrowpending') }}" method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3 col-6">
                <input type="text" class="form-control" placeholder="หมายเลขอุปกรณ์" name="asset_number" value="{{ request('asset_number') }}">
            </div>
            <div class="col-md-3 col-6">
                <input type="text" class="form-control" placeholder="ชื่อผู้ยืม" name="borrower_name" value="{{ request('borrower_name') }}">
            </div>
            <div class="col-md-3 col-6">
                <select class="form-select" id="statusFilter" name="status">
                    <option value="" data-url="{{ route('borrowpending') }}">-- สถานะทั้งหมด --</option>
                    <option value="pending" data-url="{{ route('borrowpending', ['status' => 'pending']) }}" {{ request('status') == 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                    <option value="rejected" data-url="{{ route('borrowrejected') }}" {{ request('status') == 'rejected' ? 'selected' : '' }}>ถูกปฏิเสธ</option>
                    <option value="completed" data-url="{{ route('borrowcompleted') }}" {{ request('status') == 'completed' ? 'selected' : '' }}>เสร็จสิ้น</option>
                </select>
            </div>
        </div>
        <div class="text-end mt-2">
            <button class="btn btn-primary" type="submit">ค้นหา</button>
        </div>
    </form>

    <!-- ตารางแสดงรายการคำร้องรอดำเนินการ -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
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
                @forelse ($pendingBorrows as $borrow)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $borrow->asset->asset_number ?? 'N/A' }}</td>
                        <td>{{ $borrow->asset->asset_name ?? 'N/A' }}</td>
                        <td>{{ $borrow->borrower_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrow->return_date)->format('d/m/Y') }}</td>
                        <td><span class="badge bg-warning">รอดำเนินการ</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('statusFilter').addEventListener('change', function() {
        let url = this.options[this.selectedIndex].getAttribute('data-url');
        if (url) {
            window.location.href = url;
        }
    });
</script>

@endsection
