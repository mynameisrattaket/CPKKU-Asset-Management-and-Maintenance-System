@extends('layoutmenu')

@section('title')
    ภาพรวมระบบแจ้งซ่อม
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">ภาพรวมระบบแจ้งซ่อม</h4>
@endsection

@section('nonconten')
    <div class="row">
        <!-- Dropdown for selecting year -->
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-uppercase mt-0">เลือกปี</h4>
                    <select id="year-selector" class="form-select">
                        <option value="">ทั้งหมด</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class='uil-notes float-end'></i>
                    <h4 class="text-uppercase mt-0">รายการแจ้งซ่อมทั้งหมด</h4>
                    <h2 class="my-2 text-primary text-dismissible" id="active-users-count">{{ $reportCounts['total'] }}</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
                        <span class="text-nowrap"> {{ $reportCounts['last_updated'] }}</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class='uil-wrench float-end'></i>
                    <h4 class="text-uppercase mt-0">กำลังดำเนินการ</h4>
                    <h2 class="my-2 text-warning">{{ $reportCounts['in_progress'] }}</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
                        <span class="text-nowrap"> {{ $reportCounts['last_updated_in_progress'] }}</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class='uil-check-square float-end'></i>
                    <h4 class="text-uppercase mt-0">ดำเนินการเสร็จสิ้น</h4>
                    <h2 class="my-2 text-success">{{ $reportCounts['completed'] }}</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
                        <span class="text-nowrap"> {{ $reportCounts['last_updated_completed'] }}</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class='uil-multiply float-end'></i>
                    <h4 class="text-uppercase mt-0">ซ่อมไม่ได้</h4>
                    <h2 class="my-2 text-danger">{{ $reportCounts['cannot_be_repaired'] }}</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
                        <span class="text-nowrap"> {{ $reportCounts['last_updated'] }}</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>
    </div>

    <!-- Displaying total cost -->
    <div class="row">
        <h4 class="page-title">ค่าใช้จ่าย</h4>
        <!-- If no year is selected, show total cost without year-specific data -->
        @if(request('year') == '')
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <div class="card tilebox-two">
                    <div class="card-body">
                        <i class='uil-dollar-sign float-end'></i>
                        <h4 class="text-uppercase mt-0">ค่าใช้จ่ายทั้งหมด</h4>
                        <h2 class="my-2 text-success">{{ number_format($totalCost, 2) }} บาท</h2>
                    </div>
                </div>
            </div>
        @else
            <!-- Display the cost per selected year -->
            @foreach ($costsByYear as $yearData)
                @if(request('year') == $yearData->year)
                    <div class="col-xl-3 col-lg-6 col-sm-12">
                        <div class="card tilebox-two">
                            <div class="card-body">
                                <i class='uil-calendar-alt float-end'></i>
                                <h4 class="text-uppercase mt-0">ปี {{ $yearData->year }}</h4>
                                <h2 class="my-2 text-success">{{ number_format($yearData->total_cost, 2) }} บาท</h2>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    <h4 class="page-title">ภาพรวมการทำงานของช่าง</h4>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" id="repairTable">
                <thead>
                    <tr>
                        <th>ชื่อช่าง</th>
                        <th>งานซ่อมทั้งหมด</th>
                        <th>รอดำเนินการ</th>
                        <th>กำลังดำเนินการ</th>
                        <th>รออะไหล่</th>
                        <th>ดำเนินการเสร็จสิ้น</th>
                        <th>ซ่อมไม่ได้</th>
                        <th>ค่าใช้จ่ายรวม</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($technicianPerformance as $technician)
                        <tr>
                            <td>{{ $technician->technician_name }}</td>
                            <td>{{ $technician->total_tasks }}</td>
                            <td>{{ $technician->pending_tasks }}</td>
                            <td>{{ $technician->in_progress_tasks }}</td>
                            <td>{{ $technician->waiting_parts_tasks }}</td>
                            <td>{{ $technician->completed_tasks }}</td>
                            <td>{{ $technician->cannot_fix_tasks }}</td>
                            <td>{{ number_format($technician->total_cost, 2) }} บาท</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.7/css/jquery.dataTables.min.css">

    <script>
        $(document).ready(function() {
            var table = $('#repairTable').DataTable({
                "language": {
                    "search": "",
                    "searchPlaceholder": "ค้นหา",
                    "lengthMenu": "แสดง _MENU_ รายการ",
                    "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "paginate": {
                        "first": "หน้าแรก",
                        "last": "หน้าสุดท้าย",
                        "next": "ถัดไป",
                        "previous": "ก่อนหน้า"
                    },
                    "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                    "infoEmpty": "ไม่มีรายการ",
                    "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)"
                }
            });

            // Handle year selector change
            $('#year-selector').change(function() {
                var selectedYear = $(this).val();
                var url = new URL(window.location.href);
                if (selectedYear) {
                    url.searchParams.set('year', selectedYear);
                } else {
                    url.searchParams.delete('year');
                }
                window.location.href = url;
            });
        });
    </script>
@endsection
