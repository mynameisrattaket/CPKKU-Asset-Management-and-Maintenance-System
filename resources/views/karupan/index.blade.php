@extends('layoutmenu')

@section('title', 'หน้ารายการครุภัณฑ์')

@section('contentitle', 'หน้ารายการทั้งหมด')

@section('conten')
    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-outline-success btn-sm rounded-3 px-4" id="exportAssets">
            <i class="fas fa-file-excel"></i> Export ข้อมูล
        </button>

        @if (auth()->check() && in_array(auth()->user()->user_type_id, [2, 6])) <!-- Check if user is logged in and has user_type_id 2 or 6 -->
            <button class="btn btn-outline-primary btn-sm rounded-3 px-4" id="btn-add">
                <i class="fas fa-plus"></i> เพิ่มครุภัณฑ์
            </button>
        @endif
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
                        @if (auth()->check() && in_array(auth()->user()->user_type_id, [2, 6])) <!-- Check if user is logged in and has user_type_id 2 or 6 -->
                            <button class="btn btn-warning btn-edit">แก้ไข</button>
                            <button class="btn btn-danger btn-delete">ลบ</button>
                        @else
                            <span class="text-danger">คุณไม่มีสิทธิ์แก้ไขข้อมูล</span> <!-- Show message if no permission -->
                        @endif
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
            <form id="assetForm" enctype="multipart/form-data">
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
                            <label for="asset_img">รูปภาพของครุภัณฑ์</label>

                            <!-- แสดงรูปถ้ามีอยู่ในฐานข้อมูล -->
                            <div id="asset_img_container" style="display: none;">
                                <img id="asset_img_preview" src="" alt="Asset Image" style="max-width: 500px; max-height: 500px;">
                                <button type="button" onclick="removeImage()">ลบรูปภาพ</button>
                            </div>

                            <!-- ช่องอัปโหลดไฟล์ -->
                            <input type="file" class="form-control" id="asset_img" name="asset_img" onchange="previewImage(event)">

                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                let assetImgSrc = ""; // ใส่ URL ของรูปจากฐานข้อมูลที่ดึงมา
                                let imgPreview = document.getElementById("asset_img_preview");
                                let imgContainer = document.getElementById("asset_img_container");
                                let fileInput = document.getElementById("asset_img");

                                if (assetImgSrc) {
                                    imgPreview.src = assetImgSrc;
                                    imgContainer.style.display = "block";
                                    fileInput.style.display = "none";
                                } else {
                                    imgContainer.style.display = "none";
                                    fileInput.style.display = "block";
                                }
                            });

                            function previewImage(event) {
                                let imgPreview = document.getElementById("asset_img_preview");
                                let imgContainer = document.getElementById("asset_img_container");
                                let file = event.target.files[0];

                                if (file) {
                                    let reader = new FileReader();
                                    reader.onload = function (e) {
                                        imgPreview.src = e.target.result;
                                        imgContainer.style.display = "block";
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }

                            function removeImage() {
                                document.getElementById("asset_img_preview").src = "";
                                document.getElementById("asset_img_container").style.display = "none";
                                document.getElementById("asset_img").style.display = "block";
                                document.getElementById("asset_img").value = "";
                            }
                        </script>

                    <!-- ซ้าย: หมายเลขครุภัณฑ์ (required) -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_name">ชื่อครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_name" name="asset_name">
                        </div>
                    </div>

                    <!-- ขวา: หมายเลขครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_number">หมายเลขครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_number" name="asset_number">
                        </div>
                    </div>

                    <!-- ซ้าย: หมายเลขซีเรียลของครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_sn_number">หมายเลขซีเรียลของครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_sn_number" name="asset_sn_number">
                        </div>
                    </div>

                    <!-- ขวา: หน่วยนับของครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_countingunit">หน่วยนับของครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_countingunit" name="asset_countingunit">
                        </div>
                    </div>

                    <!-- ซ้าย: ราคาครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_price">ราคาครุภัณฑ์</label>
                            <input type="number" class="form-control" id="asset_price" name="asset_price">
                        </div>
                    </div>

                    <!-- ขวา: วันที่ลงทะเบียนครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_regis_at">วันที่ลงทะเบียนครุภัณฑ์</label>
                            <input type="date" class="form-control" id="asset_regis_at" name="asset_regis_at">
                        </div>
                    </div>

                    <!-- ซ้าย: วันที่สร้างครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_created_at">วันที่สร้างครุภัณฑ์</label>
                            <input type="date" class="form-control" id="asset_created_at" name="asset_created_at">
                        </div>
                    </div>

                    <!-- ขวา: สถานะการใช้งานของครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_live">สถานะการใช้งานของครุภัณฑ์</label>
                            <input type="number" class="form-control" id="asset_live" name="asset_live">
                        </div>
                    </div>

                    <!-- ซ้าย: ราคาของครุภัณฑ์ที่มีมูลค่าลดลง -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_scrap_price">ราคาของครุภัณฑ์ที่มีมูลค่าลดลง</label>
                            <input type="number" class="form-control" id="asset_scrap_price" name="asset_scrap_price">
                        </div>
                    </div>

                    <!-- ขวา: มูลค่าครุภัณฑ์ที่เสื่อมราคา -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated">มูลค่าครุภัณฑ์ที่เสื่อมราคา</label>
                            <input type="number" class="form-control" id="asset_deteriorated" name="asset_deteriorated">
                        </div>
                    </div>

                    <!-- ซ้าย: ราคาครุภัณฑ์ที่เสื่อมราคา -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_price">ราคาครุภัณฑ์ที่เสื่อมราคา</label>
                            <input type="number" class="form-control" id="asset_deteriorated_price" name="asset_deteriorated_price">
                        </div>
                    </div>

                    <!-- ขวา: วันที่ครุภัณฑ์เริ่มเสื่อมราคา -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_at">วันที่ครุภัณฑ์เริ่มเสื่อมราคา</label>
                            <input type="date" class="form-control" id="asset_deteriorated_at" name="asset_deteriorated_at">
                        </div>
                    </div>

                    <!-- ซ้าย: วันที่สิ้นสุดการเสื่อมราคาของครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_end">วันที่สิ้นสุดการเสื่อมราคาของครุภัณฑ์</label>
                            <input type="date" class="form-control" id="asset_deteriorated_end" name="asset_deteriorated_end">
                        </div>
                    </div>

                    <!-- ขวา: ราคาครุภัณฑ์ในบัญชี -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_price_account">ราคาครุภัณฑ์ในบัญชี</label>
                            <input type="number" class="form-control" id="asset_price_account" name="asset_price_account">
                        </div>
                    </div>

                    <!-- ซ้าย: มูลค่ารวมของครุภัณฑ์ที่เสื่อมราคา -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_total">มูลค่ารวมของครุภัณฑ์ที่เสื่อมราคา</label>
                            <input type="number" class="form-control" id="asset_deteriorated_total" name="asset_deteriorated_total">
                        </div>
                    </div>

                    <!-- ขวา: บัญชีที่บันทึกการเสื่อมราคาครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_account">บัญชีที่บันทึกการเสื่อมราคาครุภัณฑ์</label>
                            <input type="number" class="form-control" id="asset_deteriorated_account" name="asset_deteriorated_account">
                        </div>
                    </div>

                    <!-- ซ้าย: บัญชีรวมของการเสื่อมราคาครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_total_account">บัญชีรวมของการเสื่อมราคาครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_deteriorated_total_account" name="asset_deteriorated_total_account">
                        </div>
                    </div>

                    <!-- ขวา: บัญชีครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_account">บัญชีครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_account" name="asset_account">
                        </div>
                    </div>

                    <!-- ซ้าย: รหัสครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_code">รหัสครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_code" name="asset_code">
                        </div>
                    </div>

                    <!-- ขวา: ยี่ห้อของครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_brand">ยี่ห้อของครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_brand" name="asset_brand">
                        </div>
                    </div>

                    <!-- ซ้าย: จำนวนครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_amount">จำนวนครุภัณฑ์</label>
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

                    <!-- ขวา: รหัสสถานะของครุภัณฑ์ -->
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

                    <!-- ซ้าย: รหัสผู้ใช้งานที่นำเข้าครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="user_import_id">รหัสผู้ใช้งานที่นำเข้าครุภัณฑ์</label>
                            <input type="number" class="form-control" id="user_import_id" name="user_import_id">
                        </div>
                    </div>

                    <!-- ขวา: รายละเอียดของครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_detail">รายละเอียดของครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_detail" name="asset_detail">
                        </div>
                    </div>

                    <!-- ซ้าย: แผนงานที่เกี่ยวข้องกับครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_plan">แผนงานที่เกี่ยวข้องกับครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_plan" name="asset_plan">
                        </div>
                    </div>

                    <!-- ขวา: โครงการที่เกี่ยวข้องกับครุภัณฑ์ -->
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_project">โครงการที่เกี่ยวข้องกับครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_project" name="asset_project">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_activity">กิจกรรมที่เกี่ยวข้องกับครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_activity" name="asset_activity">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_budget">งบประมาณที่ใช้จัดหาครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_budget" name="asset_budget">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_fund">แหล่งทุนที่ใช้จัดหาครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_fund" name="asset_fund">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_major">สาขาวิชาที่รับผิดชอบครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_major" name="asset_major">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_location">ที่ตั้งของครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_location" name="asset_location">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_reception_type">ประเภทการรับครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_reception_type" name="asset_reception_type">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_document_number">หมายเลขเอกสารที่เกี่ยวข้องกับครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_document_number" name="asset_document_number">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_get">วิธีการได้รับครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_get" name="asset_get">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_deteriorated_stop">วันที่หยุดเสื่อมราคาของครุภัณฑ์</label>
                            <input type="date" class="form-control" id="asset_deteriorated_stop" name="asset_deteriorated_stop">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_type">ประเภทของครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_type" name="asset_type">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_comment">หมายเหตุ</label>
                            <input type="text" class="form-control" id="asset_comment" name="asset_comment">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_how">วิธีการที่เกี่ยวข้องกับครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_how" name="asset_how">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_company">บริษัทที่จัดหาครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_company" name="asset_company">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_company_address">ที่อยู่ของบริษัทที่จัดหาครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_company_address" name="asset_company_address">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_type_sub">ประเภทย่อยของครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_type_sub" name="asset_type_sub">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_type_main">ประเภทหลักของครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_type_main" name="asset_type_main">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="asset_revenue">รายได้ที่ได้จากครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_revenue" name="asset_revenue">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="room_room_id">รหัสห้องที่เก็บครุภัณฑ์</label>
                            <input type="text" class="form-control" id="room_room_id" name="room_room_id">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="room_floor_id">รหัสชั้นที่เก็บครุภัณฑ์</label>
                            <input type="text" class="form-control" id="room_floor_id" name="room_floor_id">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="room_building_id">รหัสอาคารที่เก็บครุภัณฑ์</label>
                            <input type="text" class="form-control" id="room_building_id" name="room_building_id">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-2">
                            <label for="faculty_faculty_id">รหัสคณะเจ้าของครุภัณฑ์</label>
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
                $('#asset_id').val(data.asset_id); // ตรวจสอบว่าได้ค่า asset_id แล้ว
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

                // ถ้ามีรูปภาพแสดง
                if (data.asset_img) {
                                        $('#asset_img_preview').attr('src', '{{ asset('uploads/assets/') }}' + '/' + data.asset_img);
                                        $('#asset_img_container').show(); // แสดงภาพ
                                        $('#asset_img').hide(); // ซ่อนช่องให้เลือกไฟล์
                                    } else {
                                        $('#asset_img_container').hide(); // ซ่อนตัวแสดงรูปภาพ
                                        $('#asset_img').show(); // แสดงช่องให้เลือกไฟล์
                                    }
                $('#room_floor_id').val(data.room_floor_id);
                $('#assetNumberError').text(''); // ล้างข้อความแจ้งเตือน
                assetModal.show();
            }).fail(function() {
                Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถโหลดข้อมูลได้', 'error');
            });
        });

                            // ฟังก์ชันแสดงตัวอย่างรูปภาพเมื่อเลือกไฟล์
                            function previewImage(event) {
                                var reader = new FileReader();
                                reader.onload = function() {
                                    var output = document.getElementById('asset_img_preview');
                                    output.src = reader.result;
                                    document.getElementById('asset_img_container').style.display = 'block'; // แสดงภาพ
                                }
                                reader.readAsDataURL(event.target.files[0]);
                            }


        // ตรวจสอบหมายเลขครุภัณฑ์ซ้ำ (เมื่อพิมพ์)
        $('#asset_number').on('keyup', function() {
            let assetNumber = $(this).val();
            let assetId = $('#asset_id').val(); // ใช้ asset_id เพื่อตรวจสอบว่าเป็นการแก้ไขหรือไม่

            // ตรวจสอบว่า assetNumber มีค่าหรือยัง
            if (assetNumber.length > 0) {
                $.get(`/asset/check-duplicate`, { asset_number: assetNumber, asset_id: assetId }, function(response) {
                    if (response.status === 'duplicate') {
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


        // ตรวจสอบและส่งฟอร์ม
        $('#assetForm').submit(function (e) {
            e.preventDefault();

            let isFormValid = true;
            let assetNumber = $('#asset_number').val();
            let assetName = $('#asset_name').val();

            // ตรวจหมายเลขครุภัณฑ์
            if (!assetNumber) {
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณากรอกหมายเลขครุภัณฑ์',
                    text: 'คุณต้องกรอกหมายเลขครุภัณฑ์ก่อนที่จะบันทึกข้อมูล',
                    confirmButtonText: 'ตกลง'
                });
                $('#asset_number').css('border', '2px solid red');
                isFormValid = false;
            } else {
                $('#asset_number').css('border', '');
            }

            // ตรวจชื่อครุภัณฑ์
            if (!assetName) {
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณากรอกชื่อครุภัณฑ์',
                    text: 'คุณต้องกรอกชื่อครุภัณฑ์ก่อนที่จะบันทึกข้อมูล',
                    confirmButtonText: 'ตกลง'
                });
                $('#asset_name').css('border', '2px solid red');
                isFormValid = false;
            } else {
                $('#asset_name').css('border', '');
            }

            // ถ้าฟอร์มถูกต้อง
            if (isFormValid) {
                let id = $('#asset_id').val();
                let url = id ? `/asset/${id}` : '/asset';
                let method = id ? 'PUT' : 'POST';

                // ใช้ FormData สำหรับส่งข้อมูล
                let formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    contentType: false, // สำคัญเมื่อใช้ FormData
                    processData: false, // สำคัญเมื่อใช้ FormData
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: response.message
                        }).then(() => {
                            // รีโหลดเฉพาะบางส่วนของหน้า เช่น ตาราง หรือข้อมูลที่เปลี่ยนไป
                            location.reload(); // ใช้ถ้าต้องการรีเฟรชทั้งหน้า
                            $('#assetModal').modal('hide'); // ปิด modal ถ้าคุณใช้ modal
                            // หรือการอัปเดตข้อมูลบนหน้าเอง เช่น การอัปเดตตาราง
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr); // ตรวจสอบ response จากเซิร์ฟเวอร์

                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.status === 'duplicate') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'หมายเลขครุภัณฑ์ซ้ำ!',
                                text: xhr.responseJSON.message // ข้อความจากเซิร์ฟเวอร์
                            });
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

        // ปิด Modal
        $('.btn-close, .btn-secondary').click(function() {
            assetModal.hide();
        });


        document.getElementById('exportAssets').addEventListener('click', function () {
            fetch('/export-assets')
                .then(response => response.blob())
                .then(blob => {
                    let url = window.URL.createObjectURL(blob);
                    let a = document.createElement('a');
                    a.href = url;
                    a.download = "assets_data.xlsx";
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => console.error('Export failed:', error));
        });


    });
</script>
@endsection


