@extends('layoutmenu')

@section('title', 'หน้ารายการครุภัณฑ์')

@section('contentitle', 'หน้ารายการทั้งหมด')

@section('conten')

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success" id="btn-add">เพิ่มครุภัณฑ์</button>
    </div>

    <table class="table table-centered dt-responsive" id="basic-datatable" style="width: 100%">
        <thead>
            <tr>
                <th>ไอดี</th>
                <th>หมายเลขครุภัณฑ์</th>
                <th>ชื่อครุภัณฑ์</th>
                <th class="text-center">ราคาต่อหน่วย</th>
                <th>ปีงบประมาณ</th>
                <th>สถานที่ตั้ง</th>
                <th>สถานะ</th>
                <th>จัดการข้อมูล</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($asset as $karu)
                <tr data-id="{{ $karu->asset_id }}">
                    <td>{{ $karu->asset_id }}</td>
                    <td>{{ $karu->asset_number }}</td>
                    <td>{{ $karu->asset_name }}</td>
                    <td class="text-center">{{ number_format($karu->asset_price, 2) }}</td>
                    <td>{{ $karu->asset_budget }}</td>
                    <td>{{ $karu->asset_location }}</td>
                    <td>
                        @switch($karu->asset_asset_status_id)
                            @case(1)
                                พร้อมใช้งาน
                                @break
                            @case(2)
                                กำลังถูกยืม
                                @break
                            @case(3)
                                ชำรุด
                                @break
                            @case(4)
                                กำลังซ่อม
                                @break
                            @default
                                ไม่ทราบสถานะ
                        @endswitch
                    </td>
                    <td class="d-inline-flex gap-1">
                        <button class="btn btn-warning btn-edit">แก้ไข</button>
                        <button class="btn btn-danger btn-delete">ลบ</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">ไม่มีข้อมูลครุภัณฑ์</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="assetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- ขยายขนาด modal เป็น extra large -->
            <form id="assetForm">
                @csrf
                <input type="hidden" id="asset_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่ม/แก้ไขข้อมูลครุภัณฑ์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!-- ปุ่มปิดกากาบาท -->
                    </div>
                    <div class="modal-body">
                    <div class="row">
                    <div class="mb-2">
                        <label for="asset_img">รูปภาพของทรัพย์สิน</label>
                        <input type="file" class="form-control" id="asset_img" name="asset_img">
                    </div>
                    <!-- ซ้าย: หมายเลขครุภัณฑ์ (required) -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_name">ชื่อทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_name" name="asset_name">
                        </div>
                    </div>

                    <!-- ขวา: หมายเลขทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_number">หมายเลขทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_number" name="asset_number">
                        </div>
                    </div>

                    <!-- ซ้าย: หมายเลขซีเรียลของทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_sn_number">หมายเลขซีเรียลของทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_sn_number" name="asset_sn_number">
                        </div>
                    </div>

                    <!-- ขวา: หน่วยนับของทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_countingunit">หน่วยนับของทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_countingunit" name="asset_countingunit">
                        </div>
                    </div>

                    <!-- ซ้าย: ราคาทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_price">ราคาทรัพย์สิน</label>
                            <input type="number" class="form-control" id="asset_price" name="asset_price">
                        </div>
                    </div>

                    <!-- ขวา: วันที่ลงทะเบียนทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_regis_at">วันที่ลงทะเบียนทรัพย์สิน</label>
                            <input type="date" class="form-control" id="asset_regis_at" name="asset_regis_at">
                        </div>
                    </div>

                    <!-- ซ้าย: วันที่สร้างทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_created_at">วันที่สร้างทรัพย์สิน</label>
                            <input type="date" class="form-control" id="asset_created_at" name="asset_created_at">
                        </div>
                    </div>

                    <!-- ขวา: สถานะการใช้งานของทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_live">สถานะการใช้งานของทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_live" name="asset_live">
                        </div>
                    </div>

                    <!-- ซ้าย: ราคาของทรัพย์สินที่มีมูลค่าลดลง -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_scrap_price">ราคาของทรัพย์สินที่มีมูลค่าลดลง</label>
                            <input type="number" class="form-control" id="asset_scrap_price" name="asset_scrap_price">
                        </div>
                    </div>

                    <!-- ขวา: มูลค่าทรัพย์สินที่เสื่อมราคา -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated">มูลค่าทรัพย์สินที่เสื่อมราคา</label>
                            <input type="number" class="form-control" id="asset_deteriorated" name="asset_deteriorated">
                        </div>
                    </div>

                    <!-- ซ้าย: ราคาทรัพย์สินที่เสื่อมราคา -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_price">ราคาทรัพย์สินที่เสื่อมราคา</label>
                            <input type="number" class="form-control" id="asset_deteriorated_price" name="asset_deteriorated_price">
                        </div>
                    </div>

                    <!-- ขวา: วันที่ทรัพย์สินเริ่มเสื่อมราคา -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_at">วันที่ทรัพย์สินเริ่มเสื่อมราคา</label>
                            <input type="date" class="form-control" id="asset_deteriorated_at" name="asset_deteriorated_at">
                        </div>
                    </div>

                    <!-- ซ้าย: วันที่สิ้นสุดการเสื่อมราคาของทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_end">วันที่สิ้นสุดการเสื่อมราคาของทรัพย์สิน</label>
                            <input type="date" class="form-control" id="asset_deteriorated_end" name="asset_deteriorated_end">
                        </div>
                    </div>

                    <!-- ขวา: ราคาทรัพย์สินในบัญชี -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_price_account">ราคาทรัพย์สินในบัญชี</label>
                            <input type="number" class="form-control" id="asset_price_account" name="asset_price_account">
                        </div>
                    </div>

                    <!-- ซ้าย: มูลค่ารวมของทรัพย์สินที่เสื่อมราคา -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_total">มูลค่ารวมของทรัพย์สินที่เสื่อมราคา</label>
                            <input type="number" class="form-control" id="asset_deteriorated_total" name="asset_deteriorated_total">
                        </div>
                    </div>

                    <!-- ขวา: บัญชีที่บันทึกการเสื่อมราคาทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_account">บัญชีที่บันทึกการเสื่อมราคาทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_deteriorated_account" name="asset_deteriorated_account">
                        </div>
                    </div>

                    <!-- ซ้าย: บัญชีรวมของการเสื่อมราคาทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_total_account">บัญชีรวมของการเสื่อมราคาทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_deteriorated_total_account" name="asset_deteriorated_total_account">
                        </div>
                    </div>

                    <!-- ขวา: บัญชีทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_account">บัญชีทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_account" name="asset_account">
                        </div>
                    </div>

                    <!-- ซ้าย: รหัสทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_code">รหัสทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_code" name="asset_code">
                        </div>
                    </div>

                    <!-- ขวา: ยี่ห้อของทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_brand">ยี่ห้อของทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_brand" name="asset_brand">
                        </div>
                    </div>

                    <!-- ซ้าย: จำนวนทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_amount">จำนวนทรัพย์สิน</label>
                            <input type="number" class="form-control" id="asset_amount" name="asset_amount">
                        </div>
                    </div>

                    <!-- ขวา: วันที่เริ่มรับประกัน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_warranty_start">วันที่เริ่มรับประกัน</label>
                            <input type="date" class="form-control" id="asset_warranty_start" name="asset_warranty_start">
                        </div>
                    </div>

                    <!-- ซ้าย: วันที่สิ้นสุดการรับประกัน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_warranty_end">วันที่สิ้นสุดการรับประกัน</label>
                            <input type="date" class="form-control" id="asset_warranty_end" name="asset_warranty_end">
                        </div>
                    </div>

                    <!-- ขวา: รหัสสถานะของทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_asset_status_id">สถานะ</label>
                            <select name="asset_asset_status_id" class="form-control" id="asset_asset_status_id" required>
                                <option value="" selected disabled hidden>เลือกสถานะ</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->asset_status_id }}">{{ $status->asset_status_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- ซ้าย: รหัสผู้ใช้งานที่นำเข้าทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="user_import_id">รหัสผู้ใช้งานที่นำเข้าทรัพย์สิน</label>
                            <input type="number" class="form-control" id="user_import_id" name="user_import_id">
                        </div>
                    </div>

                    <!-- ขวา: รายละเอียดของทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_detail">รายละเอียดของทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_detail" name="asset_detail">
                        </div>
                    </div>

                    <!-- ซ้าย: แผนงานที่เกี่ยวข้องกับทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_plan">แผนงานที่เกี่ยวข้องกับทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_plan" name="asset_plan">
                        </div>
                    </div>

                    <!-- ขวา: โครงการที่เกี่ยวข้องกับทรัพย์สิน -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_project">โครงการที่เกี่ยวข้องกับทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_project" name="asset_project">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_activity">กิจกรรมที่เกี่ยวข้องกับทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_activity" name="asset_activity">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_budget">งบประมาณที่ใช้จัดหาทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_budget" name="asset_budget">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_fund">แหล่งทุนที่ใช้จัดหาทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_fund" name="asset_fund">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_major">สาขาวิชาที่รับผิดชอบทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_major" name="asset_major">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_location">ที่ตั้งของทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_location" name="asset_location">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_reception_type">ประเภทการรับทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_reception_type" name="asset_reception_type">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_document_number">หมายเลขเอกสารที่เกี่ยวข้องกับทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_document_number" name="asset_document_number">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_get">วิธีการได้รับทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_get" name="asset_get">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_stop">วันที่หยุดเสื่อมราคาของทรัพย์สิน</label>
                            <input type="date" class="form-control" id="asset_deteriorated_stop" name="asset_deteriorated_stop">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_type">ประเภทของทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_type" name="asset_type">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_comment">ความคิดเห็นเกี่ยวกับทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_comment" name="asset_comment">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_how">วิธีการที่เกี่ยวข้องกับทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_how" name="asset_how">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_company">บริษัทที่จัดหาทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_company" name="asset_company">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_company_address">ที่อยู่ของบริษัทที่จัดหาทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_company_address" name="asset_company_address">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_type_sub">ประเภทย่อยของทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_type_sub" name="asset_type_sub">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_type_main">ประเภทหลักของทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_type_main" name="asset_type_main">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_revenue">รายได้ที่ได้จากทรัพย์สิน</label>
                            <input type="text" class="form-control" id="asset_revenue" name="asset_revenue">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="room_room_id">รหัสห้องที่เก็บทรัพย์สิน</label>
                            <input type="text" class="form-control" id="room_room_id" name="room_room_id">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="room_floor_id">รหัสชั้นที่เก็บทรัพย์สิน</label>
                            <input type="text" class="form-control" id="room_floor_id" name="room_floor_id">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="room_building_id">รหัสอาคารที่เก็บทรัพย์สิน</label>
                            <input type="text" class="form-control" id="room_building_id" name="room_building_id">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="faculty_faculty_id">รหัสคณะเจ้าของทรัพย์สิน</label>
                            <input type="text" class="form-control" id="faculty_faculty_id" name="faculty_faculty_id">
                        </div>
                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button> <!-- ปุ่มยกเลิก -->
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let assetModal = new bootstrap.Modal(document.getElementById('assetModal'));

        // ตรวจสอบ CSRF Token สำหรับ AJAX
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        // เปิด Modal เพิ่มข้อมูล
        $('#btn-add').click(function() {
            $('#assetForm')[0].reset();
            $('#asset_id').val('');
            $('#assetNumberError').text(''); // ล้างข้อความแจ้งเตือน
            assetModal.show();
        });

        // เปิด Modal แก้ไขข้อมูล
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).closest('tr').data('id');
            $.get(`/asset/${id}/edit`, function(data) {
                $('#asset_id').val(data.asset_id);
                $('#asset_number').val(data.asset_number);
                $('#asset_name').val(data.asset_name);
                $('#asset_price').val(data.asset_price);
                $('#asset_budget').val(data.asset_budget);
                $('#asset_location').val(data.asset_location);
                $('#faculty_faculty_id').val(data.faculty_faculty_id);
                $('#asset_major').val(data.asset_major);
                $('#room_building_id').val(data.room_building_id);
                $('#room_room_id').val(data.room_room_id);
                $('#asset_comment').val(data.asset_comment);
                $('#asset_asset_status_id').val(data.asset_asset_status_id);
                $('#asset_brand').val(data.asset_brand);
                $('#asset_fund').val(data.asset_fund);
                $('#asset_reception_type').val(data.asset_reception_type);
                $('#asset_regis_at').val(data.asset_regis_at);
                $('#asset_created_at').val(data.asset_created_at);
                $('#asset_plan').val(data.asset_plan);
                $('#asset_project').val(data.asset_project);
                $('#asset_sn_number').val(data.asset_sn_number);
                $('#asset_activity').val(data.asset_activity);
                $('#asset_deteriorated_total').val(data.asset_deteriorated_total);
                $('#asset_scrap_price').val(data.asset_scrap_price);
                $('#asset_deteriorated_account').val(data.asset_deteriorated_account);
                $('#asset_deteriorated').val(data.asset_deteriorated);
                $('#asset_deteriorated_at').val(data.asset_deteriorated_at);
                $('#asset_deteriorated_stop').val(data.asset_deteriorated_stop);
                $('#asset_get').val(data.asset_get);
                $('#asset_document_number').val(data.asset_document_number);
                $('#asset_countingunit').val(data.asset_countingunit);
                $('#asset_deteriorated_price').val(data.asset_deteriorated_price);
                $('#asset_price_account').val(data.asset_price_account);
                $('#asset_account').val(data.asset_account);
                $('#asset_deteriorated_total_account').val(data.asset_deteriorated_total_account);
                $('#asset_live').val(data.asset_live);
                $('#asset_deteriorated_end').val(data.asset_deteriorated_end);
                $('#asset_code').val(data.asset_code);
                $('#asset_amount').val(data.asset_amount);
                $('#asset_warranty_start').val(data.asset_warranty_start);
                $('#asset_warranty_end').val(data.asset_warranty_end);
                $('#user_import_id').val(data.user_import_id);
                $('#asset_detail').val(data.asset_detail);
                $('#asset_type').val(data.asset_type);
                $('#asset_how').val(data.asset_how);
                $('#asset_company').val(data.asset_company);
                $('#asset_company_address').val(data.asset_company_address);
                $('#asset_type_sub').val(data.asset_type_sub);
                $('#asset_type_main').val(data.asset_type_main);
                $('#asset_revenue').val(data.asset_revenue);
                $('#asset_img').val(data.asset_img);
                $('#room_floor_id').val(data.room_floor_id);
                $('#assetNumberError').text(''); // ล้างข้อความแจ้งเตือน
                assetModal.show();
            }).fail(function() {
                Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถโหลดข้อมูลได้', 'error');
            });
        });

        // ตรวจสอบหมายเลขครุภัณฑ์ซ้ำ (เมื่อพิมพ์)
        $('#asset_number').on('keyup', function() {
            let assetNumber = $(this).val();
            let assetId = $('#asset_id').val(); // ใช้ asset_id เพื่อตรวจสอบว่าเป็นการแก้ไขหรือไม่

            // ตรวจสอบว่า assetNumber มีค่าหรือยัง
            if (assetNumber.length > 0) {
                $.get(`/asset/check-duplicate`, { asset_number: assetNumber, asset_id: assetId }, function(response) {
                    if (response.exists) {
                        $('#assetNumberError').text('หมายเลขครุภัณฑ์นี้มีอยู่แล้ว').css('color', 'red');
                    } else {
                        $('#assetNumberError').text('');
                    }
                }).fail(function() {
                    $('#assetNumberError').text('เกิดข้อผิดพลาดในการตรวจสอบหมายเลขครุภัณฑ์').css('color', 'red');
                });
            } else {
                $('#assetNumberError').text(''); // ถ้าไม่มีค่าจะลบข้อความแจ้งเตือน
            }
        });

        $('#assetForm').submit(function(e) {
            e.preventDefault();

            // ตรวจสอบหมายเลขทรัพย์สิน
            let assetNumber = $('#asset_number').val();
            let assetName = $('#asset_name').val();

            // ถ้าหมายเลขทรัพย์สินยังไม่กรอก
            if (!assetNumber) {
                // แสดง SweetAlert แจ้งเตือน
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณากรอกหมายเลขครุภัณฑ์',
                    text: 'คุณต้องกรอกหมายเลขครุภัณฑ์ก่อนที่จะบันทึกข้อมูล',
                    confirmButtonText: 'ตกลง'
                });

                // เพิ่มกรอบสีแดงรอบช่องกรอกหมายเลขทรัพย์สิน
                $('#asset_number').css('border', '2px solid red');
            } else {
                // ถ้ามีการกรอกหมายเลขแล้ว ให้ลบกรอบสีแดงออก
                $('#asset_number').css('border', '');
            }

            // ถ้าชื่อทรัพย์สินยังไม่กรอก
            if (!assetName) {
                // แสดง SweetAlert แจ้งเตือน
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณากรอกชื่อครุภัณฑ์',
                    text: 'คุณต้องกรอกชื่อครุภัณฑ์ก่อนที่จะบันทึกข้อมูล',
                    confirmButtonText: 'ตกลง'
                });

                // เพิ่มกรอบสีแดงรอบช่องกรอกชื่อทรัพย์สิน
                $('#asset_name').css('border', '2px solid red');
            } else {
                // ถ้ามีการกรอกชื่อแล้ว ให้ลบกรอบสีแดงออก
                $('#asset_name').css('border', '');
            }

            // ถ้าผ่านการตรวจสอบแล้วให้ทำการส่งฟอร์ม
            if (assetNumber && assetName) {
                let id = $('#asset_id').val();
                let url = id ? `/asset/${id}` : '/asset';
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $('#assetForm').serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: response.message
                        }).then(() => {
                            location.reload(); // รีโหลดหน้าเมื่อสำเร็จ
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr); // เช็คว่า response ส่งอะไรมา

                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.status === 'duplicate') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'หมายเลขครุภัณฑ์ซ้ำ!',
                                text: xhr.responseJSON.message // ข้อความที่ส่งจากเซิร์ฟเวอร์
                            });
                            // ทำให้ช่องหมายเลขครุภัณฑ์มีกรอบสีแดง
                            $('#asset_number').css('border', '2px solid red');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: xhr.responseJSON?.message || 'ไม่สามารถบันทึกข้อมูลได้'
                            });
                        }
                    }
                });
            }
        });

        // ลบข้อมูล
        $(document).on('click', '.btn-delete', function() {
            let id = $(this).closest('tr').data('id');
            if (!id) {
                console.error('ไม่พบ asset_id');
                return;
            }

            Swal.fire({
                title: 'ยืนยันการลบ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/asset/${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            Swal.fire('ลบสำเร็จ!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('เกิดข้อผิดพลาด', xhr.responseText, 'error');
                        }
                    });
                }
            });
        });

        $('.btn-close, .btn-secondary').click(function() {
            assetModal.hide();
        });

    });
</script>
@endsection

