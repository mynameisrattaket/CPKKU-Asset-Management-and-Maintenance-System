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
    <div class="table-responsive">
        <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>รูปภาพ</th>
                    <th>รายการ</th>
                    <th>อาการเบื้องต้น</th>
                    <th>เลขครุภัณฑ์</th>
                    <th>ตำเเหน่ง</th>
                    <th>สถานะ</th>
                    <th>การเเก้ไข</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>12</td>
                    <td><img src="/img/mate_s.jpg" alt="" class="rounded me-3" height="60"></td>
                    <td>คอมพิวเตอร์ตั้งโต๊ะ HP</td>
                    <td>
                        อาการจอฟ้าเปิดไม่ติดมีเสียงตี๊ดๆๆดังๆ
                    </td>
                    <td>643021335-2</td>
                    <td>ตึก9 ห้อง9426</td>
                    <td><span class="badge bg-success p-1">เสร็จสิ้น</span></td>
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
    </div>
@endsection
