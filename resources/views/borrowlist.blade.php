@extends('layoutmenu')

@section('title', 'คำร้องทั้งหมดในระบบครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title">คำร้องทั้งหมดในระบบครุภัณฑ์</h4>
@endsection

@section('conten')
<div class="container">
    <!-- ฟอร์มค้นหาและตัวกรองสถานะ -->
    <form id="searchForm" action="{{ route('storeborrowrequest') }}" method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3 col-6">
                <input type="text" class="form-control" placeholder="ค้นหาคำร้อง" name="searchrequest" value="{{ request('searchrequest') }}">
            </div>
            
            <div class="col-md-3 col-6">
                <input type="text" class="form-control" placeholder="ชื่อผู้ยืม" name="borrower_name" value="{{ request('borrower_name') }}">
            </div>
            <div class="col-md-3 col-6">
                <select class="form-select" id="statusFilter" name="status">
                    <option value="" data-url="{{ route('borrowlist') }}">-- สถานะทั้งหมด --</option>
                    <option value="pending" data-url="{{ route('borrowpending') }}" {{ request('status') == 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                    <option value="completed" data-url="{{ route('borrowcompleted') }}" {{ request('status') == 'completed' ? 'selected' : '' }}>อนุมัติ</option>
                    <option value="rejected" data-url="{{ route('borrowrejected') }}" {{ request('status') == 'rejected' ? 'selected' : '' }}>ถูกปฏิเสธ</option>
                </select>
            </div>
        </div>
        <div class="text-end mt-2">
            <button class="btn btn-primary" type="submit">ค้นหา</button>
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
                @forelse ($borrowRequests as $request)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $request->asset->asset_number ?? 'N/A' }}</td>
                        <td>{{ $request->asset->asset_name ?? 'N/A' }}</td>
                        <td>{{ $request->borrower_name ?? 'N/A' }}</td>
                        <td>{{ $request->borrow_date ? \Carbon\Carbon::parse($request->borrow_date)->format('d/m/Y') : 'N/A' }}</td>
                        <td>{{ $request->return_date ? \Carbon\Carbon::parse($request->return_date)->format('d/m/Y') : 'N/A' }}</td>
                        <td class="text-center">
                            @if($request->status == 'pending')
                                <span class="badge bg-warning">รอดำเนินการ</span>
                            @elseif($request->status == 'rejected')
                                <span class="badge bg-danger">ถูกปฏิเสธ</span>
                            @elseif($request->status == 'completed')
                                <span class="badge bg-primary">เสร็จสิ้น</span>
                            @endif
                        </td>
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
            window.location.href = url; // เปลี่ยนหน้าโดยตรงเมื่อเลือกสถานะ
        }
    });
</script>

@endsection
