@extends('layoutmenu')

@section('title', 'แจ้งซ่อม')

@section('contentitle')
    <h4 class="page-title">แบบฟอร์มการแจ้งซ่อม</h4>
@endsection

@section('conten')

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- เพิ่มฟอร์มตรงนี้ -->
    <form action="{{ route('addrequestrepair') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="asset_name" class="form-label">ชื่อหรือประเภทของอุปกรณ์:</label>
                <select class="form-select" id="asset_name" name="asset_name">
                    <option value="">-- เลือกประเภทอุปกรณ์ --</option>
                    <option value="เครื่องคอมพิวเตอร์ [ Computer / Case ]" {{ old('asset_name') == "เครื่องคอมพิวเตอร์ [ Computer / Case ]" ? 'selected' : '' }}>เครื่องคอมพิวเตอร์ [ Computer / Case ]</option>
                    <option value="จอภาพคอมพิวเตอร์ [ Monitor ]" {{ old('asset_name') == "จอภาพคอมพิวเตอร์ [ Monitor ]" ? 'selected' : '' }}>จอภาพคอมพิวเตอร์ [ Monitor ]</option>
                    <option value="จอภาพโปรเจคเตอร์ [ Projector ]" {{ old('asset_name') == "จอภาพโปรเจคเตอร์ [ Projector ]" ? 'selected' : '' }}>จอภาพโปรเจคเตอร์ [ Projector ]</option>
                    <option value="เม้าส์ [ Mouse ]" {{ old('asset_name') == "เม้าส์ [ Mouse ]" ? 'selected' : '' }}>เม้าส์ [ Mouse ]</option>
                    <option value="คีย์บอร์ด [ Keyboard ]" {{ old('asset_name') == "คีย์บอร์ด [ Keyboard ]" ? 'selected' : '' }}>คีย์บอร์ด [ Keyboard ]</option>
                    <option value="ระบบเสียง/ลำโพง [ Sound / Speaker ]" {{ old('asset_name') == "ระบบเสียง/ลำโพง [ Sound / Speaker ]" ? 'selected' : '' }}>ระบบเสียง/ลำโพง [ Sound / Speaker ]</option>
                    <option value="ไมค์โครโฟน [ Microphone ]" {{ old('asset_name') == "ไมค์โครโฟน [ Microphone ]" ? 'selected' : '' }}>ไมค์โครโฟน [ Microphone ]</option>
                    <option value="อินเทอร์เน็ต [ Internet ]" {{ old('asset_name') == "อินเทอร์เน็ต [ Internet ]" ? 'selected' : '' }}>อินเทอร์เน็ต [ Internet ]</option>
                    <option value="เครื่องพริ้นเตอร์ [ Printer ]" {{ old('asset_name') == "เครื่องพริ้นเตอร์ [ Printer ]" ? 'selected' : '' }}>เครื่องพริ้นเตอร์ [ Printer ]</option>
                    <option value="ระบบปฏิบัติการ [OS]" {{ old('asset_name') == "ระบบปฏิบัติการ [OS]" ? 'selected' : '' }}>ระบบปฏิบัติการ [OS]</option>
                    <option value="โปรแกรม" {{ old('asset_name') == "โปรแกรม" ? 'selected' : '' }}>โปรแกรม</option>
                    <option value="สาย Lan" {{ old('asset_name') == "สาย Lan" ? 'selected' : '' }}>สาย Lan</option>
                    <option value="Network" {{ old('asset_name') == "Network" ? 'selected' : '' }}>Network</option>
                    <option value="ไฟฟ้า" {{ old('asset_name') == "ไฟฟ้า" ? 'selected' : '' }}>ไฟฟ้า</option>
                    <option value="น้ำประปา" {{ old('asset_name') == "น้ำประปา" ? 'selected' : '' }}>น้ำประปา</option>
                    <option value="ลิฟท์" {{ old('asset_name') == "ลิฟท์" ? 'selected' : '' }}>ลิฟท์</option>
                    <option value="ระบบปรับอากาศ" {{ old('asset_name') == "ระบบปรับอากาศ" ? 'selected' : '' }}>ระบบปรับอากาศ</option>
                    <option value="Other" {{ old('asset_name') == "Other" ? 'selected' : '' }}>อื่นๆ</option>
                </select>
                <input type="text" class="form-control mt-2" id="other_asset_name" name="other_asset_name" value="{{ old('other_asset_name') }}" style="display: {{ old('asset_name') == 'Other' ? 'block' : 'none' }};" placeholder="กรอกชื่อหรือประเภทของอุปกรณ์...">
            </div>
            <div class="mb-3">
                <label for="symptom_detail" class="form-label">รายละเอียดอาการเสีย:</label>
                <textarea class="form-control" id="symptom_detail" name="symptom_detail" rows="4">{{ old('symptom_detail') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">สถานที่:</label>
                <select class="form-select" id="location" name="location">
                    <option value="">-- เลือกสถานที่ --</option>
                    <option value="9226" {{ old('location') == "9226" ? 'selected' : '' }}>9226</option>
                    <option value="9227" {{ old('location') == "9227" ? 'selected' : '' }}>9227</option>
                    <option value="9228" {{ old('location') == "9228" ? 'selected' : '' }}>9228</option>
                    <option value="9421" {{ old('location') == "9421" ? 'selected' : '' }}>9421</option>
                    <option value="9422" {{ old('location') == "9422" ? 'selected' : '' }}>9422</option>
                    <option value="9524" {{ old('location') == "9524" ? 'selected' : '' }}>9524</option>
                    <option value="9525" {{ old('location') == "9525" ? 'selected' : '' }}>9525</option>
                    <option value="6601A" {{ old('location') == "6601A" ? 'selected' : '' }}>6601A</option>
                    <option value="6601B" {{ old('location') == "6601B" ? 'selected' : '' }}>6601B</option>
                    <option value="6601C" {{ old('location') == "6601C" ? 'selected' : '' }}>6601C</option>
                    <option value="other" {{ old('location') == "other" ? 'selected' : '' }}>อื่นๆ</option>
                </select>
                <input type="text" class="form-control mt-2" id="other_location" name="other_location" value="{{ old('other_location') }}" style="display: {{ old('location') == 'other' ? 'block' : 'none' }};" placeholder="กรอกสถานที่...">
            </div>
            <div class="mb-3">
                <label for="asset_number" class="form-label">หมายเลขครุภัณฑ์:</label>
                <input type="text" class="form-control" id="asset_number" name="asset_number" placeholder="หมายเลขครุภัณฑ์ถ้ามี" value="{{ old('asset_number') }}">
            </div>
            <div class="mb-3">
                <label for="user_first_name" class="form-label">ชื่อผู้แจ้ง:</label>
                <select class="form-select" id="user_first_name" name="user_first_name">
                    <option value="">-- เลือกชื่อผู้แจ้ง --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->user_id }}">{{ $user->user_first_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="asset_image" class="form-label">อัปโหลดรูปภาพ:</label>
                <input type="file" class="form-control" id="asset_image" name="asset_image[]" multiple>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var assetNameSelect = document.getElementById('asset_name');
                    var otherAssetNameInput = document.getElementById('other_asset_name');
                    var locationSelect = document.getElementById('location');
                    var otherLocationInput = document.getElementById('other_location');

                    function toggleOtherInput(selectElement, otherInput) {
                        if (selectElement.value === 'Other' || selectElement.value === 'other') {
                            otherInput.style.display = 'block';
                            otherInput.setAttribute('name', otherInput.id);
                        } else {
                            otherInput.style.display = 'none';
                            otherInput.removeAttribute('name');
                        }
                    }

                    assetNameSelect.addEventListener('change', function() {
                        toggleOtherInput(assetNameSelect, otherAssetNameInput);
                    });

                    locationSelect.addEventListener('change', function() {
                        toggleOtherInput(locationSelect, otherLocationInput);
                    });

                    // Initialize on page load
                    toggleOtherInput(assetNameSelect, otherAssetNameInput);
                    toggleOtherInput(locationSelect, otherLocationInput);
                });
            </script>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </form>
    <!-- จบฟอร์ม -->

@endsection
