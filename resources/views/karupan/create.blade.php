@extends('layoutmenu')

@section('title')
    เพิ่มรายการครุภัณฑ์
@endsection

@section('contentitle')
    เพิ่มข้อมูล
@endsection

@section('conten')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12">
                <form id="assetForm" name="karupanForm" action="insert" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- ฝั่งซ้าย -->
                        <div class="col-md-6 mb-3">
                            <label for="asset_number"><strong>หมายเลขครุภัณฑ์</strong></label>
                            <input type="text" name="asset_number" id="asset_number" class="form-control" placeholder="หมายเลขครุภัณฑ์" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asset_name"><strong>ชื่อครุภัณฑ์</strong></label>
                            <input type="text" name="asset_name" id="asset_name" class="form-control" placeholder="ชื่อครุภัณฑ์" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asset_budget"><strong>ปีงบประมาณ</strong></label>
                            <input type="number" name="asset_budget" id="asset_budget" class="form-control" placeholder="ปีงบประมาณ" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="faculty_faculty_id"><strong>หน่วยงาน</strong></label>
                            <input type="text" name="faculty_faculty_id" id="faculty_faculty_id" class="form-control" placeholder="หน่วยงาน" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asset_major"><strong>ชื่อหน่วยงาน</strong></label>
                            <input type="text" name="asset_major" id="asset_major" class="form-control" placeholder="ชื่อหน่วยงาน" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="room_building_id"><strong>หน่วยงานย่อย</strong></label>
                            <input type="text" name="room_building_id" id="room_building_id" class="form-control" placeholder="หน่วยงานย่อย" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asset_location"><strong>ชื่อหน่วยงานย่อย</strong></label>
                            <input type="text" name="asset_location" id="asset_location" class="form-control" placeholder="ชื่อหน่วยงานย่อย" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="room_room_id"><strong>ใช้ประจำที่</strong></label>
                            <input type="text" name="room_room_id" id="room_room_id" class="form-control" placeholder="ใช้ประจำที่" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asset_comment"><strong>ผลการตรวจสอบครุภัณฑ์</strong></label>
                            <input type="text" name="asset_comment" id="asset_comment" class="form-control" placeholder="ผลการตรวจสอบครุภัณฑ์">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asset_asset_status_id"><strong>ตรวจสอบการใช้งาน</strong></label>
                            <input type="number" name="asset_asset_status_id" id="asset_asset_status_id" class="form-control" placeholder="สถานะการใช้งาน" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asset_brand"><strong>ยี่ห้อ/ชนิดแบบขนาดหมายเลขเครื่อง</strong></label>
                            <input type="text" name="asset_brand" id="asset_brand" class="form-control" placeholder="ยี่ห้อ/ชนิดแบบขนาดหมายเลขเครื่อง" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asset_price"><strong>ราคาต่อหน่วย</strong></label>
                            <input type="number" name="asset_price" id="asset_price" class="form-control" placeholder="ราคาต่อหน่วย" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asset_fund"><strong>แหล่งเงิน</strong></label>
                            <input type="text" name="asset_fund" id="asset_fund" class="form-control" placeholder="แหล่งเงิน" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asset_reception_type"><strong>วิธีการได้มา</strong></label>
                            <input type="text" name="asset_reception_type" id="asset_reception_type" class="form-control" placeholder="วิธีการได้มา" required>
                        </div>
                    </div>

                    <!-- ปุ่มบันทึก -->
                    <div class="col-md-12">
                        <button type="submit" class="mt-3 btn btn-success" style="float:right;">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function checkOtherPrefix() {
            var selectBox = document.getElementById("asset_prefix");
            var otherInput = document.getElementById("other_asset_prefix");
            if (selectBox.value === "other") {
                otherInput.style.display = "block";
            } else {
                otherInput.style.display = "none";
            }
        }
    </script>

    <script>
        document.getElementById('asset_number').addEventListener('input', function() {
            var assetNumber = this.value;
            var assetNumberError = document.getElementById('assetNumberError');
            if (assetNumber.length !== 13) {
                assetNumberError.style.display = 'block';
            } else {
                assetNumberError.style.display = 'none';
            }
        });
    </script>

    <script>
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                if (!this.value.trim()) {
                    this.classList.add('is-invalid');
                    this.nextElementSibling.innerText = 'โปรดกรอกข้อมูลในฟิลด์นี้';
                } else {
                    this.classList.remove('is-invalid');
                    this.nextElementSibling.innerText = '';
                }
            });
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            const invalidInputs = this.querySelectorAll('.form-control.is-invalid');
        });
    </script>

    <script>
        document.getElementById('assetForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const fields = [
                'asset_number',  // หมายเลขครุภัณฑ์
                'asset_name',    // ชื่อครุภัณฑ์
                'asset_budget',  // ปีงบประมาณ
                'faculty_faculty_id',  // หน่วยงาน
                'asset_major',  // ชื่อหน่วยงาน
                'room_building_id',  // หน่วยงานย่อย
                'asset_location',  // ชื่อหน่วยงานย่อย
                'room_room_id',  // ใช้ประจำที่
                'asset_comment',  // ผลการตรวจสอบครุภัณฑ์
                'asset_asset_status_id',  // ตรวจสอบการใช้งาน
                'asset_brand',  // ยี่ห้อ ชนิดแบบขนาดหมายเลขเครื่อง
                'asset_price',  // ราคาต่อหน่วย
                'asset_fund',  // แหล่งเงิน
                'asset_reception_type'  // วิธีการได้มา
            ];

            const fieldNames = {
                'asset_number': 'หมายเลขครุภัณฑ์',
                'asset_name': 'ชื่อครุภัณฑ์',
                'asset_budget': 'ปีงบประมาณ',
                'faculty_faculty_id': 'หน่วยงาน',
                'asset_major': 'ชื่อหน่วยงาน',
                'room_building_id': 'หน่วยงานย่อย',
                'asset_location': 'ชื่อหน่วยงานย่อย',
                'room_room_id': 'ใช้ประจำที่',
                'asset_comment': 'ผลการตรวจสอบครุภัณฑ์',
                'asset_asset_status_id': 'ตรวจสอบการใช้งาน',
                'asset_brand': 'ยี่ห้อ ชนิดแบบขนาดหมายเลขเครื่อง',
                'asset_price': 'ราคาต่อหน่วย',
                'asset_fund': 'แหล่งเงิน',
                'asset_reception_type': 'วิธีการได้มา'
            };


            let isValid = true;
            let missingFields = [];

            fields.forEach(function(field) {
                const input = document.getElementsByName(field)[0];
                if (!input || !input.value) {
                    isValid = false;
                    missingFields.push(fieldNames[field]);
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'กรุณากรอกข้อมูลในฟิลด์ต่อไปนี้ให้ครบถ้วน: ' + missingFields.join(', '),
                });
            } else {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: "Are you sure you want to submit?",
                    text: "You won't be able to change this later.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, submit it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then(function(result) {
                    if (result.isConfirmed) {
                        event.target.submit();
                    }
                });
            }
        });
    </script>
@endsection
