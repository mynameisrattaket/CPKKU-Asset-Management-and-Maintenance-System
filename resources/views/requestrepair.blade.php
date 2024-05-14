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
                <label for="asset_number" class="form-label">หมายเลขอุปกรณ์:</label>
                <input type="text" class="form-control" id="asset_number" name="asset_number">
            </div>
            <div class="mb-3">
                <label for="asset_name" class="form-label">ชื่ออุปกรณ์:</label>
                <input type="text" class="form-control" id="asset_name" name="asset_name">
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
                <input type="text" class="form-control mt-2" id="other_location" name="other_location" style="display: none;" placeholder="กรอกสถานที่เอง">
            </div>

            <script>
                document.getElementById('location').addEventListener('change', function() {
                    var otherLocationInput = document.getElementById('other_location');
                    if (this.value === 'other') {
                        otherLocationInput.style.display = 'block';
                    } else {
                        otherLocationInput.style.display = 'none';
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
