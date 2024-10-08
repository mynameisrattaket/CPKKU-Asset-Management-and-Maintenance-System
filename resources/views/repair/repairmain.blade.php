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

    <h4 class="page-title">รายการทั้งหมด</h4>

@endsection

@section('conten')
    <table id="repairTable" class="table table-centered mb-0">
        <thead class="table-dark">
            <tr>
                <th>รายการ</th>
                <th>อาการเบื้องต้น</th>
                <th>ระดับการดำเนินการ</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($repairs as $repair)
            <tr>
                <td>{{ $repair->asset_name }}</td>
                <td>{{ $repair->asset_symptom_detail }}</td>
                <td>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-lg {{ $repair->progress_class }}" role="progressbar" style="width: {{ $repair->progress_percentage }}%"
                            aria-valuenow="{{ $repair->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>
                <td><i class="mdi mdi-circle {{ $repair->status_class }}"></i> {{ $repair->repair_status_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
