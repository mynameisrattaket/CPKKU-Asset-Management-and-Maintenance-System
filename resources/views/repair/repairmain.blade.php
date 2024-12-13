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
        <!--end card-->
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
        <!--end card-->
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
        <!--end card-->
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
        <!--end card-->
    </div>

    <!-- Displaying total cost -->

    <!-- Displaying yearly costs and counts -->
    <div class="row">
        <h4 class="page-title">ค่าใช้จ่ายและจำนวนการซ่อมต่อปี</h4>
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <div class="card tilebox-two">
                <div class="card-body">
                    <i class='uil-dollar-sign float-end'></i>
                    <h4 class="text-uppercase mt-0">ค่าใช้จ่ายทั้งหมด</h4>
                    <h2 class="my-2 text-success">{{ number_format($totalCost, 2) }} บาท</h2>
                </div>
            </div>
        </div>
        @foreach ($costsByYear as $yearData)
            <div class="col-xl-3 col-lg-6 col-sm-12">
                <div class="card tilebox-two">
                    <div class="card-body">
                        <i class='uil-calendar-alt float-end'></i>
                        <h4 class="text-uppercase mt-0">ปี {{ $yearData->year }}</h4>
                        <h2 class="my-2 text-success">{{ number_format($yearData->total_cost, 2) }} บาท</h2>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> จำนวนการแจ้งซ่อม</span>
                            <span class="text-nowrap">{{ $yearData->total_reports }} ครั้ง</span>
                        </p>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> จำนวนการซ่อมที่เสร็จสิ้น</span>
                            <span class="text-nowrap">{{ $yearData->completed_repairs }} ครั้ง</span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <h4 class="page-title">ภาพรวมการทำงานของช่าง</h4>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
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
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Include DataTables JS and CSS -->
    <script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.7/css/jquery.dataTables.min.css">

    <style>
        /* Style for the search box */
        .dataTables_filter {
            float: left;
        }

        /* Style for the list display */
        .dataTables_info, .dataTables_paginate {
            float: right;
        }
        .card.tilebox-two {
            min-height: 90%; /* กำหนดความสูงขั้นต่ำ */
        }
    </style>

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

            // Move the search box and list display to the desired location
            var searchInput = table.container().find('.dataTables_filter');
            var listDisplay = table.container().find('.dataTables_info, .dataTables_paginate');
            listDisplay.after(searchInput);
        });
    </script>
@endsection
