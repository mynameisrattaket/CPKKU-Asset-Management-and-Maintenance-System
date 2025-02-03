<!-- Edit Asset Modal -->
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="modal fade text-left" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">แก้ไขข้อมูลครุภัณฑ์</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="updateAssetForm">
                                @csrf
                                <input type="hidden" name="asset_id" id="asset_id" class="form-control" readonly>

                                <div class="form-group">
                                    <label for="asset_name"><strong>ชื่อครุภัณฑ์</strong></label>
                                    <input type="text" name="asset_name" id="asset_name" class="form-control" required>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="asset_price"><strong>ราคาต่อหน่วย</strong></label>
                                    <input type="number" step="0.01" name="asset_price" id="asset_price" class="form-control" required>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="asset_status_id"><strong>สถานะครุภัณฑ์</strong></label>
                                    <select name="asset_status_id" id="asset_status_id" class="form-control" required>
                                        <option value="1">ใช้งาน</option>
                                        <option value="2">ชำรุด</option>
                                        <option value="3">ซ่อมบำรุง</option>
                                        <option value="4">เลิกใช้งาน</option>
                                    </select>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="asset_number"><strong>หมายเลขครุภัณฑ์</strong></label>
                                    <input type="text" name="asset_number" id="asset_number" class="form-control" required>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="asset_comment"><strong>หมายเหตุ</strong></label>
                                    <textarea name="asset_comment" id="asset_comment" class="form-control" rows="3"></textarea>
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

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // เปิด Modal และโหลดข้อมูล
        $('#editmodal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let assetId = button.data('id');

            $.get("/assets/" + assetId, function (data) {
                $("#asset_id").val(data.asset_id);
                $("#asset_name").val(data.asset_name);
                $("#asset_price").val(data.asset_price);
                $("#asset_status_id").val(data.asset_status_id);
                $("#asset_number").val(data.asset_number);
                $("#asset_comment").val(data.asset_comment);
            });
        });

        // ส่งฟอร์มผ่าน AJAX
        $("#updateAssetForm").on("submit", function (e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $(".btn-sendsuccess").html("กำลังบันทึก...").attr("disabled", true);

            $.ajax({
                url: "/assets/update",
                type: "POST",
                data: formData,
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                success: function (response) {
                    alert("บันทึกข้อมูลสำเร็จ!");
                    $("#editmodal").modal("hide");
                    location.reload();
                },
                error: function () {
                    alert("เกิดข้อผิดพลาดในการบันทึกข้อมูล!");
                },
                complete: function () {
                    $(".btn-sendsuccess").html("บันทึก").attr("disabled", false);
                }
            });
        });
    });
</script>
