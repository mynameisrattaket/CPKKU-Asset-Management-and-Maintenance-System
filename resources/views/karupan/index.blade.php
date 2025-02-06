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
        <div class="modal-dialog modal-lg"> <!-- ขยายขนาด modal -->
            <form id="assetForm">
                @csrf
                <input type="hidden" id="asset_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่ม/แก้ไขข้อมูลครุภัณฑ์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- ซ้าย: หมายเลขครุภัณฑ์ (required) -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_number">หมายเลขครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="asset_number" name="asset_number" required>
                                </div>
                            </div>

                            <!-- ขวา: ชื่อครุภัณฑ์ (required) -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_name">ชื่อครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="asset_name" name="asset_name" required>
                                </div>
                            </div>

                            <!-- ซ้าย: ปีงบประมาณ -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_budget">ปีงบประมาณ</label>
                                    <input type="number" class="form-control" id="asset_budget" name="asset_budget">
                                </div>
                            </div>

                            <!-- ขวา: หน่วยงาน -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="faculty_faculty_id">หน่วยงาน</label>
                                    <input type="text" class="form-control" id="faculty_faculty_id" name="faculty_faculty_id">
                                </div>
                            </div>

                            <!-- ซ้าย: ชื่อหน่วยงาน -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_major">ชื่อหน่วยงาน</label>
                                    <input type="text" class="form-control" id="asset_major" name="asset_major">
                                </div>
                            </div>

                            <!-- ขวา: หน่วยงานย่อย -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="room_building_id">หน่วยงานย่อย</label>
                                    <input type="text" class="form-control" id="room_building_id" name="room_building_id">
                                </div>
                            </div>

                            <!-- ซ้าย: ชื่อหน่วยงานย่อย -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_location">ชื่อหน่วยงานย่อย</label>
                                    <input type="text" class="form-control" id="asset_location" name="asset_location">
                                </div>
                            </div>

                            <!-- ขวา: ใช้ประจำที่ -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="room_room_id">ใช้ประจำที่</label>
                                    <input type="text" class="form-control" id="room_room_id" name="room_room_id">
                                </div>
                            </div>

                            <!-- ซ้าย: ผลการตรวจสอบครุภัณฑ์ -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_comment">ผลการตรวจสอบครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="asset_comment" name="asset_comment">
                                </div>
                            </div>

                            <!-- ขวา: ตรวจสอบการใช้งาน (required) -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_asset_status_id">ตรวจสอบการใช้งาน</label>
                                    <input type="number" class="form-control" id="asset_asset_status_id" name="asset_asset_status_id" required>
                                </div>
                            </div>

                            <!-- ซ้าย: ยี่ห้อ/ชนิดแบบขนาดหมายเลขเครื่อง -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_brand">ยี่ห้อ/ชนิดแบบขนาดหมายเลขเครื่อง</label>
                                    <input type="text" class="form-control" id="asset_brand" name="asset_brand">
                                </div>
                            </div>

                            <!-- ขวา: ราคาต่อหน่วย -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_price">ราคาต่อหน่วย</label>
                                    <input type="number" class="form-control" id="asset_price" name="asset_price">
                                </div>
                            </div>

                            <!-- ซ้าย: แหล่งเงิน -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_fund">แหล่งเงิน</label>
                                    <input type="text" class="form-control" id="asset_fund" name="asset_fund">
                                </div>
                            </div>

                            <!-- ขวา: วิธีการได้มา -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <label for="asset_reception_type">วิธีการได้มา</label>
                                    <input type="text" class="form-control" id="asset_reception_type" name="asset_reception_type">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
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
                    $('#faculty_faculty_id').val(data.faculty_faculty_id); // เพิ่มฟิลด์ใหม่
                    $('#asset_major').val(data.asset_major); // เพิ่มฟิลด์ใหม่
                    $('#room_building_id').val(data.room_building_id); // เพิ่มฟิลด์ใหม่
                    $('#room_room_id').val(data.room_room_id); // เพิ่มฟิลด์ใหม่
                    $('#asset_comment').val(data.asset_comment); // เพิ่มฟิลด์ใหม่
                    $('#asset_asset_status_id').val(data.asset_asset_status_id); // เพิ่มฟิลด์ใหม่
                    $('#asset_brand').val(data.asset_brand); // เพิ่มฟิลด์ใหม่
                    $('#asset_fund').val(data.asset_fund); // เพิ่มฟิลด์ใหม่
                    $('#asset_reception_type').val(data.asset_reception_type); // เพิ่มฟิลด์ใหม่
                    assetModal.show();
                }).fail(function() {
                    alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                });
            });

            // บันทึกหรืออัปเดตข้อมูล
            $('#assetForm').submit(function(e) {
                e.preventDefault();
                let id = $('#asset_id').val();
                let url = id ? `/asset/${id}` : '/asset';
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $('#assetForm').serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('เกิดข้อผิดพลาด: ' + xhr.responseText);
                    }
                });
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
        });
    </script>
@endsection
