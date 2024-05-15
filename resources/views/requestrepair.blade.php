@extends('layoutmenu')

@section('title', 'แจ้งซ่อม')

@section('contentitle')
    <h4 class="page-title">แบบฟอร์มการแจ้งซ่อม</h4>
@endsection

@section('conten')
    <!-- เพิ่มฟอร์มตรงนี้ -->
    <form action="{{ route('addrequestrepair') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="asset_name" class="form-label">ชื่อหรือประเภทของอุปกรณ์:</label>
                <select class="form-select" id="asset_name" name="asset_name">
                    <option value="">-- เลือกประเภทอุปกรณ์ --</option>
                    <option value="เครื่องคอมพิวเตอร์ [ Computer / Case ]">เครื่องคอมพิวเตอร์ [ Computer / Case ]</option>
                    <option value="จอภาพคอมพิวเตอร์ [ Monitor ]">จอภาพคอมพิวเตอร์ [ Monitor ]</option>
                    <option value="จอภาพโปรเจคเตอร์ [ Projector ]">จอภาพโปรเจคเตอร์ [ Projector ]</option>
                    <option value="เม้าส์ [ Mouse ]">เม้าส์ [ Mouse ]</option>
                    <option value="คีย์บอร์ด [ Keyboard ]">คีย์บอร์ด [ Keyboard ]</option>
                    <option value="ระบบเสียง/ลำโพง [ Sound / Speaker ]">ระบบเสียง/ลำโพง [ Sound / Speaker ]</option>
                    <option value="ไมค์โครโฟน [ Microphone ]">ไมค์โครโฟน [ Microphone ]</option>
                    <option value="อินเทอร์เน็ต [ Internet ]">อินเทอร์เน็ต [ Internet ]</option>
                    <option value="เครื่องพริ้นเตอร์ [ Printer ]">เครื่องพริ้นเตอร์ [ Printer ]</option>
                    <option value="ระบบปฏิบัติการ [OS]">ระบบปฏิบัติการ [OS]</option>
                    <option value="โปรแกรม">โปรแกรม</option>
                    <option value="สาย Lan">สาย Lan</option>
                    <option value="Network">Network</option>
                    <option value="ไฟฟ้า">ไฟฟ้า</option>
                    <option value="น้ำประปา">น้ำประปา</option>
                    <option value="ลิฟท์">ลิฟท์</option>
                    <option value="ระบบปรับอากาศ">ระบบปรับอากาศ</option>
                    <option value="Other">อื่นๆ</option>
                </select>
                <input type="text" class="form-control mt-2" id="other_asset_name" name="other_asset_name" style="display: none;" placeholder="กรอกชื่อหรือประเภทของอุปกรณ์...">
            </div>
            <div class="mb-3">
                <label for="symptom_detail" class="form-label">รายละเอียดอาการเสีย:</label>
                <textarea class="form-control" id="symptom_detail" name="symptom_detail" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">สถานที่:</label>
                <select class="form-select" id="location" name="location">
                    <option value="">-- เลือกสถานที่ --</option>
                    <option value="9226">9226</option>
                    <option value="9227">9227</option>
                    <option value="9228">9228</option>
                    <option value="9421">9421</option>
                    <option value="9422">9422</option>
                    <option value="9524">9524</option>
                    <option value="9525">9525</option>
                    <option value="6601A">6601A</option>
                    <option value="6601B">6601B</option>
                    <option value="6601C">6601C</option>
                    <option value="other">อื่นๆ</option>
                </select>
                <input type="text" class="form-control mt-2" id="other_location" name="other_location" style="display: none;" placeholder="กรอกสถานที่...">
            </div>
            <div class="mb-3">
                <label for="asset_number" class="form-label">หมายเลขครุภัณฑ์:</label>
                <input type="text" class="form-control" id="asset_number" name="asset_number" placeholder="หมายเลขครุภัณฑ์ถ้ามี">
            </div>

            <script>
                document.getElementById('asset_name').addEventListener('change', function() {
                    var otherAssetNameInput = document.getElementById('other_asset_name');
                    if (this.value === 'Other') {
                        otherAssetNameInput.style.display = 'block';
                        otherAssetNameInput.setAttribute('name', 'other_asset_name');
                    } else {
                        otherAssetNameInput.style.display = 'none';
                        otherAssetNameInput.removeAttribute('name');
                    }
                });

                document.getElementById('location').addEventListener('change', function() {
                    var otherLocationInput = document.getElementById('other_location');
                    if (this.value === 'other') {
                        otherLocationInput.style.display = 'block';
                        otherLocationInput.setAttribute('name', 'other_location');
                    } else {
                        otherLocationInput.style.display = 'none';
                        otherLocationInput.removeAttribute('name');
                    }
                });
            </script>


        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </form>
    <!-- จบฟอร์ม -->
@endsection
