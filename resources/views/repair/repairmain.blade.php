@extends('layoutmenu')

@section('title')
    รายงานการแจ้งซ่อม
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
                <h4 class="text-uppercase mt-0">รายงานการแจ้งซ่อม</h4>
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
                <h2 class="my-2 text-danger">{{ $reportCounts['cancelled'] }}</h2>
                <p class="mb-0 text-muted">
                    <span class="text-success me-2"><span class="mdi mdi-arrow-up-bold"></span> อัปเดตล่าสุด</span>
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
