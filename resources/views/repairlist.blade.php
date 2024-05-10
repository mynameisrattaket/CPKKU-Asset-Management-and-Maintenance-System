@extends('layoutmenu')

@section('title')
    รายการเเจ้งซ่อม
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">รายการเเจ้งซ่อม</h4>
@endsection

@section('conten')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>รายการแจ้งซ่อม</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>รายการแจ้งซ่อม</h1>
            <div class="row mb-3">
                <div class="col-6">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRepairModal">แจ้งซ่อม</button>
                </div>
                <div class="col-6 text-end">
                    <form id="searchForm" action="{{ url('/search') }}" method="GET" class="d-flex">
                        <input type="text" id="searchInput" class="form-control me-2 form-control-sm" placeholder="ค้นหารายการแจ้งซ่อม" name="search">
                        <button class="btn btn-primary" type="submit">ค้นหา</button>
                    </form>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">หมายเลขอุปกรณ์</th>
                        <th scope="col">ชื่ออุปกรณ์</th>
                        <th scope="col">รายละเอียด</th>
                        <th scope="col">สถานที่</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($request_detail as $repair)
                    <tr>
                        <th scope="row">{{ $repair->request_detail_id }}</th>
                        <td>{{ $repair->asset_number }}</td>
                        <td>{{ $repair->asset_name }}</td>
                        <td>{{ $repair->asset_symptom_detail }}</td>
                        <td>{{ $repair->location }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="modal fade" id="addRepairModal" tabindex="-1" aria-labelledby="addRepairModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRepairModalLabel">แบบฟอร์มการแจ้งซ่อม</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/store-repair-request') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="asset_number" class="form-label">หมายเลขอุปกรณ์:</label>
                                    <input type="text" class="form-control" id="asset_number" name="asset_number">
                                </div>
                                <div class="mb-3">
                                    <label for="asset_name" class="form-label">ชื่ออุปกรณ์:</label>
                                    <input type="text" class="form-control" id="asset_name" name="asset_name">
                                </div>
                                <div class="mb-3">
                                    <label for="symptom_detail" class="form-label">รายละเอียดอาการเสีย:</label>
                                    <input type="text" class="form-control" id="symptom_detail" name="symptom_detail">
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">สถานที่:</label>
                                    <input type="text" class="form-control" id="location" name="location">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" class="btn btn-success">ยืนยัน</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
@endsection
