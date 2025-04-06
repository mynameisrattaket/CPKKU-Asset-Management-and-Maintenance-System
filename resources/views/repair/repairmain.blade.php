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

<div class="card-body">
    <div class="d-flex justify-content-start align-items-center">
        <!-- Dropdown สำหรับเลือกปีทางซ้าย -->
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-uppercase mt-0 mb-3">เลือกปี</h4>
                    <select id="year-selector" class="form-select form-select-lg">
                        <option value="">ทั้งหมด</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- ปุ่ม export ชิดมุมขวาล่าง -->
    <button id="export-button" class="btn btn-success btn-lg px-4 py-2 shadow-sm rounded-3 border-0 hover-shadow position-absolute bottom-0 end-0 mb-3 me-3">
        <i class="bi bi-file-earmark-arrow-down"></i> Export ข้อมูล
    </button>
</div>

<style>
    /* เพิ่มสไตล์ให้ปุ่ม */
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-lg {
        font-size: 16px;
    }

    /* ปรับแต่ง dropdown */
    .form-select-lg {
        font-size: 16px;
        padding: 0.5rem 1rem;
    }

    .card-body {
        padding: 1rem;
        position: relative; /* เพื่อให้ position absolute ของปุ่มทำงาน */
    }

    /* เพิ่ม hover effect และเงาให้กับปุ่ม */
    .hover-shadow:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Icon สำหรับปุ่ม Export */
    .bi {
        margin-right: 8px;
    }

    .tilebox-one, .tilebox-two {
        min-height: 150px; /* ปรับความสูงตามที่ต้องการ */
    }

</style>




    <div class="row">
        <!-- รายการแจ้งซ่อมทั้งหมด -->
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

        <!-- Pending -->
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class='uil-clock float-end'></i> <!-- เปลี่ยนเป็นนาฬิกาทราย -->
                    <h4 class="text-uppercase mt-0">รอดำเนินการ</h4>
                    <h2 class="my-2 text-warning">{{ $reportCounts['Pending'] }}</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
                        <span class="text-nowrap"> {{ $reportCounts['last_updated_pending'] }}</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>

        <!-- In progress -->
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class="mdi mdi-hammer float-end"></i> <!-- ไอคอนค้อน -->
                    <h4 class="text-uppercase mt-0">กำลังดำเนินการ</h4>
                    <h2 class="my-2 text-warning">{{ $reportCounts['In progress'] }}</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
                        <span class="text-nowrap"> {{ $reportCounts['last_updated_in_progress'] }}</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>

        <!-- Waiting for parts -->
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class='uil-wrench float-end'></i> <!-- เปลี่ยนเป็นเครื่องมือ -->
                    <h4 class="text-uppercase mt-0">รออะไหล่</h4>
                    <h2 class="my-2 text-warning">{{ $reportCounts['Waiting for parts'] }}</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
                        <span class="text-nowrap"> {{ $reportCounts['last_updated_waiting'] }}</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>

        <!-- Completed -->
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class='uil-check-circle float-end'></i> <!-- เปลี่ยนเป็นเครื่องหมายถูก -->
                    <h4 class="text-uppercase mt-0">ดำเนินการเสร็จสิ้น</h4>
                    <h2 class="my-2 text-success">{{ $reportCounts['completed'] }}</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
                        <span class="text-nowrap"> {{ $reportCounts['last_updated_completed'] }}</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>

        <!-- Cannot be repaired -->
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class='uil-times-circle float-end'></i> <!-- เปลี่ยนเป็นวงกลมที่มีเครื่องหมายกากบาท -->
                    <h4 class="text-uppercase mt-0">ซ่อมไม่ได้</h4>
                    <h2 class="my-2 text-danger">{{ $reportCounts['Cannot be repaired'] }}</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
                        <span class="text-nowrap"> {{ $reportCounts['last_updated_cannot_be_repaired'] }}</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>

        <!-- Canceled -->
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-one">
                <div class="card-body">
                    <i class='uil-ban float-end'></i> <!-- เปลี่ยนเป็นสัญลักษณ์ห้าม -->
                    <h4 class="text-uppercase mt-0">ถูกยกเลิก</h4>
                    <h2 class="my-2 text-danger">{{ $reportCounts['Canceled'] }}</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
                        <span class="text-nowrap"> {{ $reportCounts['last_updated_canceled'] }}</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>

        @if(request('year') == '')
            <!-- ค่าใช้จ่ายทั้งหมด -->
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <div class="card tilebox-two">
                    <div class="card-body">
                        <!-- ปรับขนาดไอคอนด้วยการใช้ class 'fs-1' หรือปรับตามต้องการ -->
                        <i class='uil-dollar-sign float-end fs-1'></i>
                        <h4 class="text-uppercase mt-0">ค่าใช้จ่ายทั้งหมด</h4>
                        <h2 class="my-2 text-success">{{ number_format($totalCost, 2) }} บาท</h2>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2"><span class=""></span></span>
                            <span class="text-nowrap"></span>
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Display the cost per selected year -->
            @foreach ($costsByYear as $yearData)
                @if(request('year') == $yearData->year)
                    <div class="col-xl-3 col-lg-6 col-sm-12">
                        <div class="card tilebox-one">
                            <div class="card-body">
                                <i class='uil-dollar-sign float-end fs-1'></i> <!-- ใช้ไอคอนเดิม -->
                                <h4 class="text-uppercase mt-0">ปี {{ $yearData->year }}</h4>
                                <h2 class="my-2 text-success">{{ number_format($yearData->total_cost, 2) }} บาท</h2>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div> <!-- end row -->


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
                        <th>ถูกยกเลิก</th>
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
                            <td>{{ $technician->Canceled }}</td>
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
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script> <!-- เพิ่ม library สำหรับ export Excel -->

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

            // Handle export to Excel
            $('#export-button').click(function() {
                var technicianData = [];
                @foreach ($technicianPerformance as $technician)
                    technicianData.push({
                        'Technician': '{{ $technician->technician_name }}',
                        'Total Tasks': '{{ $technician->total_tasks }}',
                        'Pending Tasks': '{{ $technician->pending_tasks }}',
                        'In Progress Tasks': '{{ $technician->in_progress_tasks }}',
                        'Waiting for Parts': '{{ $technician->waiting_parts_tasks }}',
                        'Completed Tasks': '{{ $technician->completed_tasks }}',
                        'Cannot Fix Tasks': '{{ $technician->cannot_fix_tasks }}',
                        'Canceled Tasks': '{{ $technician->Canceled }}',
                        'Total Cost': '{{ number_format($technician->total_cost, 2) }} บาท'
                    });
                @endforeach

                var reportData = [
                    { 'Label': 'รายการแจ้งซ่อมทั้งหมด', 'Value': '{{ $reportCounts['total'] }}' },
                    { 'Label': 'รอดำเนินการ', 'Value': '{{ $reportCounts['Pending'] }}' },
                    { 'Label': 'กำลังดำเนินการ', 'Value': '{{ $reportCounts['In progress'] }}' },
                    { 'Label': 'รออะไหล่', 'Value': '{{ $reportCounts['Waiting for parts'] }}' },
                    { 'Label': 'ดำเนินการเสร็จสิ้น', 'Value': '{{ $reportCounts['completed'] }}' },
                    { 'Label': 'ซ่อมไม่ได้', 'Value': '{{ $reportCounts['Cannot be repaired'] }}' },
                    { 'Label': 'ถูกยกเลิก', 'Value': '{{ $reportCounts['Canceled'] }}' },
                    { 'Label': 'ค่าใช้จ่ายทั้งหมด', 'Value': '{{ number_format($totalCost, 2) }} บาท' },
                ];

                // สร้างตารางสำหรับข้อมูลการซ่อมทั้งหมด
                var ws1 = XLSX.utils.aoa_to_sheet([
                    ['Label', 'Value'],
                    ...reportData.map(row => [row.Label, row.Value])  // เพิ่มข้อมูลในแถว
                ]);

                // สร้างตารางสำหรับข้อมูลการทำงานของช่าง
                var ws2 = XLSX.utils.aoa_to_sheet([
                    ['ชื่อช่าง', 'งานซ่อมทั้งหมด', 'รอดำเนินการ', 'กำลังดำเนินการ', 'รออะไหล่', 'ดำเนินการเสร็จสิ้น', 'ซ่อมไม่ได้', 'ถูกยกเลิก', 'ค่าใช้จ่ายรวม'],
                    ...technicianData.map(row => [row.Technician, row['Total Tasks'], row['Pending Tasks'], row['In Progress Tasks'], row['Waiting for Parts'], row['Completed Tasks'], row['Cannot Fix Tasks'], row['Canceled Tasks'], row['Total Cost']])
                ]);

                // สร้าง workbook และเพิ่ม sheet ทั้ง 2
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws1, 'Repair Data');
                XLSX.utils.book_append_sheet(wb, ws2, 'Technician Performance');

                // export ไปยังไฟล์ Excel
                XLSX.writeFile(wb, 'repair_report.xlsx');
            });

            // Handle year selection change
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












