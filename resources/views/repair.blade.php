@extends('layoutmenu')

@section('title')
    หน้ารายการครุภัณฑ์
@endsection

@section('contentitle')
    <h4 class="page-title">ภาพรวมระบบเเจ้งซ่อม</h4>
@endsection

@section('nonconten')

    <div class="col-xl-3 col-lg-6 col-sm-12">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class='uil-notes float-end'></i>
                <h4 class="text-uppercase mt-0">รายงานการเเจ้งซ่อม</h4>
                <h2 class="my-2" id="active-users-count">30</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> 10%</span>
                    <span class="text-nowrap">ล่าสุดเมื่อ 5 ชัวโมงที่เเล้ว</span>
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
                <h2 class="my-2" id="active-users-count">121</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> 5.27%</span>
                    <span class="text-nowrap">ล่าสุดเมื่อ 1 ชัวโมงที่เเล้ว</span>
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
                <h2 class="my-2" id="active-users-count">121</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> 5.27%</span>
                    <span class="text-nowrap">ล่าสุดเมื่อ 20 นาทีที่เเล้ว</span>
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <div class="col-xl-3 col-lg-6 col-sm-12">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class='uil-multiply float-end'></i>
                <h4 class="text-uppercase mt-0">ถูกยกเลิก</h4>
                <h2 class="my-2" id="active-users-count">121</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> 5.27%</span>
                    <span class="text-nowrap">ล่าสุดเมื่อไม่นานมานี้</span>
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

@endsection


@section('conten')
    test
@endsection
