<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="modal fade text-left" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="editModalLabel">แก้ไขข้อมูลครุภัณฑ์</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="updateAssetForm">
                                @csrf
                                <input type="hidden" name="asset_id" id="asset_id" class="form-control" readonly>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <strong>ชื่อครุภัณฑ์</strong>
                                        <input type="text" name="asset_name" id="asset_name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>ราคาต่อหน่วย</strong>
                                        <input type="number" step="0.01" name="asset_price" id="asset_price" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>สถานะครุภัณฑ์</strong>
                                        <select name="asset_status_id" id="asset_status_id" class="form-control" required>
                                            <option value="1">ใช้งาน</option>
                                            <option value="2">ชำรุด</option>
                                            <option value="3">ซ่อมบำรุง</option>
                                            <option value="4">เลิกใช้งาน</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>หมายเลขครุภัณฑ์</strong>
                                        <input type="text" name="asset_number" id="asset_number" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>หมายเหตุ</strong>
                                        <textarea name="asset_comment" id="asset_comment" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="button" class="mt-3 btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <button type="submit" class="mt-3 btn btn-primary btn-sendsuccess">บันทึก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Load data into modal when clicking the edit button
        $('.btn-edit').on('click', function () {
            var assetId = $(this).data('id');
            $.ajax({
                url: '/edit_karupan',
                method: 'GET',
                data: { assetId: assetId },
                success: function (response) {
                    if (response) {
                        $('#asset_id').val(response.asset_id);
                        $('#asset_name').val(response.asset_name);
                        $('#asset_price').val(response.asset_price);
                        $('#asset_status_id').val(response.asset_status_id);
                        $('#asset_number').val(response.asset_number);
                        $('#asset_comment').val(response.asset_comment);
                        $('#editmodal').modal('show');
                    } else {
                        alert('ไม่พบข้อมูล');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Update asset when form is submitted
        $('#updateAssetForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: '/update_karupan',
                method: 'POST',
                data: formData,
                success: function (response) {
                    alert('แก้ไขข้อมูลสำเร็จ');
                    $('#editmodal').modal('hide');
                    location.reload();
                },
                error: function (xhr) {
                    alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
