@extends('layoutmenu')

@section('title', 'แจ้งซ่อม')

@section('contentitle')
    <h4 class="page-title">แบบฟอร์มการแจ้งซ่อม</h4>
@endsection

@section('conten')

    @if (Session::has('success'))
        <div class="alert alert-success">
            <p>{{ Session::get('success') }}</p>
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

    <form action="{{ route('addrequestrepair') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="asset_name" class="form-label">ชื่อหรือประเภทของอุปกรณ์:</label>
                <select class="form-select" id="asset_name" name="asset_name">
                    <option value="">-- เลือกประเภทอุปกรณ์ --</option>
                    @foreach ([
                        'เครื่องคอมพิวเตอร์ [ Computer / Case ]',
                        'จอภาพคอมพิวเตอร์ [ Monitor ]',
                        'จอภาพโปรเจคเตอร์ [ Projector ]',
                        'เม้าส์ [ Mouse ]',
                        'คีย์บอร์ด [ Keyboard ]',
                        'ระบบเสียง/ลำโพง [ Sound / Speaker ]',
                        'ไมค์โครโฟน [ Microphone ]',
                        'อินเทอร์เน็ต [ Internet ]',
                        'เครื่องพริ้นเตอร์ [ Printer ]',
                        'ระบบปฏิบัติการ [OS]',
                        'โปรแกรม',
                        'สาย Lan',
                        'Network',
                        'ไฟฟ้า',
                        'น้ำประปา',
                        'ลิฟท์',
                        'ระบบปรับอากาศ',
                        'Other'
                    ] as $option)
                        <option value="{{ $option }}" {{ old('asset_name') == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
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
                    @foreach ([
                        '9226', '9227', '9228', '9421', '9422', '9524', '9525', '6601A', '6601B', '6601C', 'other'
                    ] as $option)
                        <option value="{{ $option }}" {{ old('location') == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                <input type="text" class="form-control mt-2" id="other_location" name="other_location" value="{{ old('other_location') }}" style="display: {{ old('location') == 'other' ? 'block' : 'none' }};" placeholder="กรอกสถานที่...">
            </div>
            <div class="mb-3">
                <label for="asset_number" class="form-label">ค้นหาหมายเลขครุภัณฑ์:</label>
                <input type="text" class="form-control" id="asset_number" name="asset_number" placeholder="ค้นหาหมายเลขครุภัณฑ์" value="{{ old('asset_number') }}">
                <div id="assetList" class="list-group"></div>
            </div>

            <!-- Your other form fields here -->

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const assetNumberInput = document.getElementById('asset_number');
                    const assetListDiv = document.getElementById('assetList');

                    assetNumberInput.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase().trim();

                        fetch(`/search-assets?keyword=${searchTerm}`)
                            .then(response => response.json())
                            .then(data => {
                                assetListDiv.innerHTML = '';
                                data.forEach(asset => {
                                    const option = document.createElement('button');
                                    option.textContent = asset.asset_number;
                                    option.classList.add('list-group-item', 'list-group-item-action', 'asset-option');
                                    option.setAttribute('type', 'button');
                                    option.addEventListener('click', function() {
                                        assetNumberInput.value = asset.asset_number;
                                        assetListDiv.innerHTML = '';
                                    });
                                    assetListDiv.appendChild(option);
                                });
                            })
                            .catch(error => console.error('Error fetching assets:', error));
                    });

                    // Hide assetListDiv when clicking outside of assetNumberInput
                    document.addEventListener('click', function(event) {
                        if (!event.target.closest('#assetList') && event.target !== assetNumberInput) {
                            assetListDiv.innerHTML = '';
                        }
                    });
                });
            </script>

            <div class="mb-3">
                <label for="user_full_name" class="form-label">ชื่อผู้แจ้ง:</label>
                <select class="form-select" id="user_full_name" name="user_full_name">
                    <option value="">-- เลือกชื่อผู้แจ้ง --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->user_id }}">{{ $user->user_first_name }} {{ $user->user_last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="asset_image" class="form-label">อัปโหลดรูปภาพ:</label>
                <input type="file" class="form-control" id="asset_image" name="asset_image[]" multiple>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleOtherInput = (selectElement, otherInput) => {
                otherInput.style.display = selectElement.value.toLowerCase() === 'other' ? 'block' : 'none';
                otherInput.name = otherInput.id;
            };

            const assetNameSelect = document.getElementById('asset_name');
            const otherAssetNameInput = document.getElementById('other_asset_name');
            const locationSelect = document.getElementById('location');
            const otherLocationInput = document.getElementById('other_location');

            assetNameSelect.addEventListener('change', () => toggleOtherInput(assetNameSelect, otherAssetNameInput));
            locationSelect.addEventListener('change', () => toggleOtherInput(locationSelect, otherLocationInput));

            // Initialize on page load
            toggleOtherInput(assetNameSelect, otherAssetNameInput);
            toggleOtherInput(locationSelect, otherLocationInput);
        });
    </script>
@endsection
