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
                                    option.innerHTML = `${asset.asset_name} [${asset.asset_number}]`;
                                    option.classList.add('list-group-item', 'list-group-item-action', 'asset-option');
                                    option.setAttribute('type', 'button');
                                    option.addEventListener('click', function() {
                                        assetNumberInput.value = asset.asset_number; // เก็บเฉพาะหมายเลขครุภัณฑ์
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
    <div class="dropdown">
        <input type="text" id="user_search" class="form-control" placeholder="ค้นหาชื่อผู้แจ้ง" onkeyup="filterUsers()" autocomplete="off">
        <div id="user_dropdown" class="dropdown-menu" style="max-height: 200px; overflow-y: auto; display: none;">
            @foreach ($users as $user)
                <div class="dropdown-item" onclick="selectUser('{{ $user->id }}', '{{ $user->name }}')">{{ $user->name }}</div>
            @endforeach
        </div>
    </div>
    <input type="hidden" name="user_full_name" id="user_full_name" value=""> <!-- Hidden field for user ID -->
</div>

<div class="mb-3">
    <label for="technician_id" class="form-label">ช่างที่รับผิดชอบงาน:</label>
    <div class="dropdown">
        <input type="text" id="technician_search" class="form-control" placeholder="ค้นหาช่างที่รับผิดชอบงาน" onkeyup="filterTechnicians()" autocomplete="off" style="width: 100%;">
        <div id="technician_dropdown" class="dropdown-menu" style="max-height: 200px; overflow-y: auto; display: none;">
            @foreach ($technicians as $technician)
                <div class="dropdown-item" onclick="selectTechnician('{{ $technician->id }}', '{{ $technician->name }}')">{{ $technician->name }}</div>
            @endforeach
        </div>
    </div>
    <input type="hidden" name="technician_id" id="technician_id" value=""> <!-- Hidden field for technician ID -->
</div>

<script>
    function filterUsers() {
        const input = document.getElementById('user_search').value.toLowerCase();
        const userDropdown = document.getElementById('user_dropdown');
        const items = userDropdown.getElementsByClassName('dropdown-item');

        userDropdown.style.display = 'block'; // Show dropdown

        let hasResults = false;
        for (let i = 0; i < items.length; i++) {
            const userName = items[i].textContent.toLowerCase();
            if (userName.includes(input)) {
                items[i].style.display = ''; // Show item if it matches the input
                hasResults = true;
            } else {
                items[i].style.display = 'none'; // Hide item if it doesn't match
            }
        }

        // If no results, hide the dropdown
        if (!hasResults) {
            userDropdown.style.display = 'none';
        }
    }

    function selectUser(id, name) {
        document.getElementById('user_search').value = name || '';
        document.getElementById('user_full_name').value = id; // Set hidden input value
        document.getElementById('user_dropdown').style.display = 'none'; // Hide dropdown
    }

    function filterTechnicians() {
        const input = document.getElementById('technician_search').value.toLowerCase();
        const technicianDropdown = document.getElementById('technician_dropdown');
        const items = technicianDropdown.getElementsByClassName('dropdown-item');

        technicianDropdown.style.display = 'block'; // Show dropdown

        let hasResults = false;
        for (let i = 0; i < items.length; i++) {
            const technicianName = items[i].textContent.toLowerCase();
            if (technicianName.includes(input)) {
                items[i].style.display = ''; // Show item if it matches the input
                hasResults = true;
            } else {
                items[i].style.display = 'none'; // Hide item if it doesn't match
            }
        }

        // If no results, hide the dropdown
        if (!hasResults) {
            technicianDropdown.style.display = 'none';
        }
    }

    function selectTechnician(id, name) {
        document.getElementById('technician_search').value = name || '';
        document.getElementById('technician_id').value = id; // Set hidden input value
        document.getElementById('technician_dropdown').style.display = 'none'; // Hide dropdown
    }

    // Hide dropdown if clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.matches('#user_search') && !event.target.matches('.dropdown-item')) {
            document.getElementById('user_dropdown').style.display = 'none';
        }
        if (!event.target.matches('#technician_search') && !event.target.matches('.dropdown-item')) {
            document.getElementById('technician_dropdown').style.display = 'none';
        }
    });

    // Show the dropdown when the input is focused
    document.getElementById('user_search').addEventListener('focus', function() {
        document.getElementById('user_dropdown').style.display = 'block';
    });
    document.getElementById('technician_search').addEventListener('focus', function() {
        document.getElementById('technician_dropdown').style.display = 'block';
    });
</script>





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
