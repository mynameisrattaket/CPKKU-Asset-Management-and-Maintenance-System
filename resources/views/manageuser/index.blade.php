@extends('layoutmenu')

@section('title', 'จัดการข้อมูลผู้ใช้งาน')

@section('contentitle')
    <h4 class="page-title">จัดการข้อมูลผู้ใช้งาน</h4>
@endsection

@section('conten')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- แถวเดียวกัน -->
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <!-- กล่องค้นหาทางซ้าย -->
        <div class="me-2" style="max-width: 250px;">
            <label for="searchUser" class="form-label">ค้นหาผู้ใช้งาน:</label>
            <input type="text" class="form-control" id="searchUser" placeholder="พิมพ์ชื่อหรืออีเมล">
        </div>

        <!-- ปุ่มเพิ่มผู้ใช้งาน -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
            เพิ่มผู้ใช้งาน
        </button>
    </div>

    <!-- Modal สำหรับเพิ่มผู้ใช้งาน -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">เพิ่มข้อมูลผู้ใช้งาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- ฟอร์มสำหรับเพิ่มผู้ใช้งาน -->
                <div class="modal-body">
                    <div id="error-message" style="color: red; display: none; font-weight: bold;"></div> <!-- ข้อความผิดพลาด -->
                    <form id="addUserForm" action="{{ route('manageuser.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            <div id="name-error" style="color: red; display: none;"></div> <!-- ข้อความผิดพลาดของชื่อ -->
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">อีเมล</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            <div id="email-error" style="color: red; display: none;"></div> <!-- ข้อความผิดพลาดของอีเมล -->
                        </div>
                        <div class="mb-3">
                            <label for="user_type_id" class="form-label">สถานะ</label>
                            <select class="form-select" id="user_type_id" name="user_type_id" required>
                                @foreach ($userTypes as $type)
                                    <option value="{{ $type->user_type_id }}" {{ old('user_type_id') == $type->user_type_id ? 'selected' : '' }}>{{ $type->user_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            e.preventDefault(); // ป้องกันการส่งฟอร์มก่อน

            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;

            // ล้างข้อความผิดพลาดก่อนหน้า
            document.getElementById('name-error').style.display = 'none';
            document.getElementById('email-error').style.display = 'none';

            // ส่งคำขอไปตรวจสอบใน backend
            fetch("{{ route('manageuser.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    user_type_id: document.getElementById('user_type_id').value
                })
            })
            .then(response => response.json())
            .then(data => {
                var errorDiv = document.getElementById('error-message'); // Element ที่จะใช้แสดงข้อความผิดพลาด

                // หากมีข้อผิดพลาด
                if (data.error) {
                    errorDiv.textContent = data.error; // แสดงข้อความผิดพลาด
                    errorDiv.style.display = 'block'; // แสดงข้อความผิดพลาด
                } else {
                    errorDiv.style.display = 'none'; // ซ่อนข้อความผิดพลาดเมื่อไม่มีข้อผิดพลาด
                    this.submit(); // ส่งฟอร์มไป
                }
            })
            .catch(error => console.log(error));
        });
    </script>







    <!-- ตัวกรองสถานะ -->
    <div class="mb-3">
        <label for="filterStatus" class="form-label">กรองสถานะ:</label>
        <select class="form-select" id="filterStatus">
            <option value="all" selected>แสดงทั้งหมด</option>
            @foreach ($userTypes as $type)
                <option value="{{ $type->user_type_id }}">{{ $type->user_type_name }}</option>
            @endforeach
            <option value="null">ยังไม่ได้กำหนด</option>
        </select>
    </div>

    <table id="userTable" class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">รหัส</th>
                <th scope="col">ชื่อ</th>
                <th scope="col">อีเมล</th>
                <th scope="col">รหัสผ่าน</th>
                <th scope="col">สาขาวิชา</th>
                <th scope="col">สถานะ</th>
                <th scope="col">จัดการข้อมูล</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr data-status="{{ $user->user_type_id ?? 'null' }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>********</td>
                    <td>{{ $user->user_major }}</td>
                    <td>
                        @php
                            $userType = $user->user_type_name ?? 'ยังไม่ได้กำหนด';
                        @endphp
                        {{ $userType }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-{{ $user->id }}">แก้ไข</button>

                        <form action="{{ route('manageuser.destroy', ['id' => $user->id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('คุณต้องการลบผู้ใช้งานนี้ใช่หรือไม่?')">ลบ</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal แก้ไขข้อมูล -->
                <div class="modal fade" id="editModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel-{{ $user->id }}">แก้ไขข้อมูลผู้ใช้งาน</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('manageuser.update', ['id' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="user_major-{{ $user->id }}" class="form-label">สาขาวิชา</label>
                                        <input type="text" class="form-control" id="user_major-{{ $user->id }}" name="user_major" value="{{ $user->user_major }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="user_type_id-{{ $user->id }}" class="form-label">สถานะ</label>
                                        <select class="form-select" id="user_type_id-{{ $user->id }}" name="user_type_id">
                                            @foreach ($userTypes as $type)
                                                <option value="{{ $type->user_type_id }}" {{ $user->user_type_id == $type->user_type_id ? 'selected' : '' }}>
                                                    {{ $type->user_type_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    @parent

    <script>
        function filterTable(selectedStatus) {
            const rows = document.querySelectorAll('#userTable tbody tr');

            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');

                if (selectedStatus === 'all') {
                    row.style.display = '';
                } else if (selectedStatus === 'null' && rowStatus === 'null') {
                    row.style.display = '';
                } else if (rowStatus == selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const filterDropdown = document.getElementById('filterStatus');
            const selectedValue = filterDropdown.value;
            filterTable(selectedValue);

            filterDropdown.addEventListener('change', function () {
                const selectedValue = this.value;
                filterTable(selectedValue);
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchUser');
            const rows = document.querySelectorAll('#userTable tbody tr');

            searchInput.addEventListener('keyup', function () {
                const query = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const name = row.cells[1].textContent.toLowerCase(); // ชื่อ
                    const email = row.cells[2].textContent.toLowerCase(); // อีเมล

                    if (name.includes(query) || email.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

    </script>
@endsection
