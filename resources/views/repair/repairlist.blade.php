@extends('layoutmenu')

@section('title', 'รายการแจ้งซ่อม')

@section('contentitle')
    <h4 class="page-title">รายการแจ้งซ่อม</h4>
@endsection

@section('conten')
    <div class="col-3 ms-auto text-end mb-2 mt-2">
        <!-- Dropdown for filtering by repair status -->
        <form method="GET" action="{{ route('repairlist') }}">
            <div class="d-flex align-items-center">
                <label for="statusFilter" class="form-label me-2">กรองสถานะการซ่อม</label>
                <select class="form-select" name="status" id="statusFilter" onchange="this.form.submit()">
                    <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>ทั้งหมด</option>
                    <option value="1" {{ $statusFilter == 1 ? 'selected' : '' }}>รอดำเนินการ</option>
                    <option value="2" {{ $statusFilter == 2 ? 'selected' : '' }}>กำลังดำเนินการ</option>
                    <option value="3" {{ $statusFilter == 3 ? 'selected' : '' }}>รออะไหล่</option>
                    <option value="4" {{ $statusFilter == 4 ? 'selected' : '' }}>ดำเนินการเสร็จสิ้น</option>
                    <option value="5" {{ $statusFilter == 5 ? 'selected' : '' }}>ซ่อมไม่ได้</option>
                    <option value="6" {{ $statusFilter == 6 ? 'selected' : '' }}>ถูกยกเลิก</option>
                </select>
            </div>
        </form>
    </div>


    <table id="repairTable" class="table table-bordered mb-0">
        <thead class="table-dark">
            <tr>
                <th scope="col">ไอดี</th>
                <th scope="col">ชื่อหรือประเภทของอุปกรณ์</th>
                <th scope="col">รายละเอียดอาการเสีย</th>
                <th scope="col">สถานที่</th>
                <th scope="col">หมายเลขครุภัณฑ์</th>
                <th scope="col">วันที่แจ้งซ่อม</th>
                <th scope="col">สถานะการซ่อม</th>
                <th scope="col">รายละเอียดเพิ่มเติม</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($repairs as $repair)
                <tr>
                    <td>{{ $repair->request_detail_id }}</td>
                    <td>{{ $repair->asset_name }}</td>
                    <td>{{ $repair->asset_symptom_detail }}</td>
                    <td>{{ $repair->location }}</td>
                    <td>{{ $repair->asset_number }}</td>
                    <td>{{ $repair->request_repair_at }}</td>
                    <td>{{ $repair->repair_status_name }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#repairModal{{ $repair->request_detail_id }}">เเก้ไขรายละเอียด</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach ($repairs as $repair)
        <div class="modal fade" id="repairModal{{ $repair->request_detail_id }}" tabindex="-1" aria-labelledby="repairModalLabel{{ $repair->request_detail_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="repairModalLabel{{ $repair->request_detail_id }}">รายละเอียดการแจ้งซ่อม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('updateRepairStatus', $repair->request_detail_id) }}">
                            @csrf
                            @method('PUT')
                            <div id="carouselExampleIndicators{{ $repair->request_detail_id }}" class="carousel slide mb-2" data-bs-ride="carousel">
                                @php
                                    $images = json_decode($repair->asset_image, true);
                                @endphp
                                @if(!empty($images) && is_array($images))
                                    <ol class="carousel-indicators">
                                        @foreach($images as $index => $image)
                                            <li data-target="#carouselExampleIndicators{{ $repair->request_detail_id }}" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                        @endforeach
                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach($images as $index => $image)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('images/' . $image) }}" alt="Asset Image" style="width: 100%; height: 450px; object-fit: scale-down; ">
                                            </div>
                                        @endforeach
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators{{ $repair->request_detail_id }}" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only"></span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators{{ $repair->request_detail_id }}" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only"></span>
                                    </a>
                                @else
                                    ไม่มีรูปภาพ
                                @endif
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="order{{ $loop->index + 1 }}" class="form-label">ไอดี</label>
                                    <input type="text" class="form-control" id="order{{ $loop->index + 1 }}" value="{{ $loop->index + 1 }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="assetName{{ $repair->request_detail_id }}" class="form-label">ชื่อหรือประเภทของอุปกรณ์</label>
                                    <input type="text" class="form-control" id="assetName{{ $repair->request_detail_id }}" value="{{ $repair->asset_name }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="assetSymptomDetail{{ $repair->request_detail_id }}" class="form-label">รายละเอียดอาการเสีย</label>
                                    <input type="text" class="form-control" id="assetSymptomDetail{{ $repair->request_detail_id }}" value="{{ $repair->asset_symptom_detail }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="location{{ $repair->request_detail_id }}" class="form-label">สถานที่</label>
                                    <input type="text" class="form-control" id="location{{ $repair->request_detail_id }}" value="{{ $repair->location }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="assetNumber{{ $repair->request_detail_id }}" class="form-label">หมายเลขครุภัณฑ์</label>
                                    <input type="text" class="form-control" id="assetNumber{{ $repair->request_detail_id }}" value="{{ $repair->asset_number }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="technicianName{{ $repair->request_detail_id }}" class="form-label">ช่างที่รับผิดชอบงาน</label>
                                    <input type="text" class="form-control" id="technicianName{{ $repair->request_detail_id }}" value="{{ $repair->technician_first_name }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="time{{ $repair->request_repair_at }}" class="form-label">วันที่แจ้งซ่อม</label>
                                    <input type="text" class="form-control" id="time{{ $repair->request_repair_at }}" value="{{ $repair->request_repair_at }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="technicianId{{ $repair->request_detail_id }}" class="form-label">ช่างที่รับผิดชอบงาน</label>
                                    <input type="text" id="technician_search{{ $repair->request_detail_id }}" class="form-control" onkeyup="filterTechnicians('{{ $repair->request_detail_id }}')" placeholder="ค้นหาช่าง">
                                    <div id="technician_dropdown{{ $repair->request_detail_id }}" class="dropdown-menu" style="display: none;">
                                        @foreach($technicians as $technician)
                                        <a href="#" class="dropdown-item" onclick="selectTechnician('{{ $repair->request_detail_id }}', '{{ $technician->id }}', '{{ $technician->name }}')">{{ $technician->name }}</a>
                                        @endforeach
                                    </div>
                                    <input type="hidden" id="technicianId{{ $repair->request_detail_id }}" name="technician_id" value="">
                                </div>

                                <script>
                                    function filterTechnicians(requestDetailId) {
                                        const input = document.getElementById('technician_search' + requestDetailId).value.toLowerCase();
                                        const technicianDropdown = document.getElementById('technician_dropdown' + requestDetailId);
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

                                    function selectTechnician(requestDetailId, id, name) {
                                        document.getElementById('technician_search' + requestDetailId).value = name || 'เลือกช่าง'; // Change input value
                                        document.getElementById('technicianId' + requestDetailId).value = id; // Set hidden input value
                                        document.getElementById('technician_dropdown' + requestDetailId).style.display = 'none'; // Hide dropdown
                                    }

                                    // Hide dropdown if clicking outside
                                    document.addEventListener('click', function(event) {
                                        const technicianDropdowns = document.querySelectorAll('.dropdown-menu');
                                        technicianDropdowns.forEach(function(dropdown) {
                                            if (!dropdown.contains(event.target) && !event.target.closest('.col-md-6')) {
                                                dropdown.style.display = 'none';
                                            }
                                        });
                                    });

                                    // Show the dropdown when the input is focused
                                    document.querySelectorAll('[id^="technician_search"]').forEach(function(input) {
                                        input.addEventListener('focus', function() {
                                            const requestDetailId = input.id.replace('technician_search', '');
                                            document.getElementById('technician_dropdown' + requestDetailId).style.display = 'block';
                                        });
                                    });
                                </script>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="requesterName{{ $repair->request_detail_id }}" class="form-label">ชื่อผู้แจ้ง</label>
                                    <input type="text" class="form-control" id="requesterName{{ $repair->request_detail_id }}" value="{{ $repair->requester_first_name }} " readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="requesterType{{ $repair->request_detail_id }}" class="form-label">สถานะผู้แจ้ง</label>
                                    <input type="text" class="form-control" id="requesterType{{ $repair->request_detail_id }}" value="{{ $repair->requester_type_name }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="repairStatus{{ $repair->request_detail_id }}" class="form-label">สถานะการซ่อม</label>
                                    <select class="form-select" id="repairStatus{{ $repair->request_detail_id }}" name="repair_status_id">
                                        <option value="1" {{ $repair->repair_status_id == 1 ? 'selected' : '' }}>รอดำเนินการ</option>
                                        <option value="2" {{ $repair->repair_status_id == 2 ? 'selected' : '' }}>กำลังดำเนินการ</option>
                                        <option value="3" {{ $repair->repair_status_id == 3 ? 'selected' : '' }}>รออะไหล่</option>
                                        <option value="4" {{ $repair->repair_status_id == 4 ? 'selected' : '' }}>ดำเนินการเสร็จสิ้น</option>
                                        <option value="5" {{ $repair->repair_status_id == 5 ? 'selected' : '' }}>ซ่อมไม่ได้</option>
                                        <option value="6" {{ $repair->repair_status_id == 6 ? 'selected' : '' }}>ถูกยกเลิก</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="repairnote{{ $repair->request_detail_id }}" class="form-label">บันทึกการซ่อม</label>
                                    <textarea class="form-control" id="repairnote{{ $repair->request_detail_id }}" name="request_repair_note" rows="3">{{ $repair->request_repair_note }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@section('scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Include DataTables JS and CSS -->
    <script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

    <style>
        /* Style for the search box */
        .search-box {
            float: left;
        }

        /* Style for the list display */
        .list-display {
            float: right;
        }
    </style>

    <script>
        $(document).ready(function() {
            var table = $('#repairTable').DataTable({
                "language": {
                    "search": "",
                    "searchPlaceholder": "ค้นหา",
                    "lengthMenu": "แสดง _MENU_ รายการ",
                    "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "paginate": {
                        "first": "หน้าแรก",
                        "last": "หน้าสุดท้าย",
                        "next": "ถัดไป",
                        "previous": "ก่อนหน้า"
                    },
                    "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                    "infoEmpty": "ไม่มีรายการ",
                    "infoFiltered": "(กรองจากทั้งหมด _MAX_ รายการ)"
                }
            });

            // Get the search input element
            var searchInput = table.container().find('.dataTables_filter input');

            // Get the list display element
            var listDisplay = table.container().find('.dataTables_info, .dataTables_paginate');

            // Append the search input element after the list display
            listDisplay.after(searchInput.parent());
        });
    </script>
@endsection
