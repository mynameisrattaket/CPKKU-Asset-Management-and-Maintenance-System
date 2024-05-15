@extends('layoutmenu')

@section('title')
    ยืมครุภัณฑ์
@endsection

@section('breadcrumb')
    
@endsection

@section('contentitle')
    <h4 class="page-title">ภาพรวมระบบยืมครุภัณฑ์</h4>
@endsection

@section('nonconten')
    <div class="col-xl-3 col-lg-6 col-sm-12">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class='uil-notes float-end'></i>
                <h4 class="text-uppercase mt-0">รายการยืมครุภัณฑ์ทั้งหมด</h4>
                <h2 class="my-2 text-primary text-dismissible" id="active-users-count">40</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span>update</span>
                    <span class="text-nowrap">เมื่อ 5 ชัวโมงที่เเล้ว</span>
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <div class="col-xl-3 col-lg-6 col-sm-12">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class=' uil-envelope-alt float-end'></i>
                <h4 class="text-uppercase mt-0">รอดำเนินการ</h4>
                <h2 class="my-2 text-warning" id="active-users-count">8</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span>update</span>
                    <span class="text-nowrap">เมื่อ 1 ชัวโมงที่เเล้ว</span>
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <div class="col-xl-3 col-lg-6 col-sm-12">
        <div class="card tilebox-one">
            <div class="card-body">
                <i class='uil-check-square float-end'></i>
                <h4 class="text-uppercase mt-0">อยู่ระหว่างการยืม</h4>
                <h2 class="my-2 text-warning" id="active-users-count">15</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span>update</span>
                    <span class="text-nowrap">เมื่อ 20 นาทีที่เเล้ว</span>
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <div class="col-xl-3 col-lg-6 col-sm-12">
        
        <div class="card tilebox-one">
            <div class="card-body">
                <i class=' uil-envelope-check float-end'></i>
                <h4 class="text-uppercase mt-0">เสร็จสิ้น</h4>
                <h2 class="my-2 text-success" id="active-users-count">1</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span>update</span>
                    <span class="text-nowrap">เมื่อไม่นานมานี้</span>
                </p>
            </div> <!-- end card-body-->
        </div>
        <!--end card-->
    </div>

    <h4 class="page-title">รายการทั้งหมด</h4>
@endsection


@section('conten')

    <table class="table table-centered mb-0">
        <thead class="table-dark">
            <tr>
                <th>รายการ</th>
                <th>อาการเบื้องต้น</th>
                <th>ระดับการดำเนินการ</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ASOS Ridley High Waist</td>
                <td>FedEx</td>
                <td>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-lg bg-success" role="progressbar" style="width: 100%"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>
                <td><i class="mdi mdi-circle text-success"></i> Delivered</td>
            </tr>
            <tr>
                <td>Marco Lightweight Shirt</td>
                <td>DHL</td>
                <td>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-lg bg-warning" role="progressbar" style="width: 50%"
                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>
                <td><i class="mdi mdi-circle text-warning"></i> Shipped</td>
            </tr>
            <tr>
                <td>Half Sleeve Shirt</td>
                <td>Bright</td>
                <td>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-lg bg-info" role="progressbar" style="width: 25%"
                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>
                <td><i class="mdi mdi-circle text-info"></i> Order Received</td>
            </tr>
            <tr>
                <td>Lightweight Jacket</td>
                <td>FedEx</td>
                <td>
                    <div class="progress progress-sm">
                        <div class="progress-bar progress-lg bg-success" role="progressbar" style="width: 100%"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>
                <td><i class="mdi mdi-circle text-success"></i> Delivered</td>
            </tr>
        </tbody>
    </table>

@endsection
