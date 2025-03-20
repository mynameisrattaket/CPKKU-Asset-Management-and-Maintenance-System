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

    <!-- ปุ่มเพิ่มข้อมูลผู้ใช้ -->
    <div class="mb-3">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">เพิ่มข้อมูลผู้ใช้</button>
    </div>

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
                <th scope="col">ไอดี</th>
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
                    <td>{{ $user->user_type_name ?? 'ยังไม่ได้กำหนด' }}</td>
                    <td>
                        <!-- ปุ่มแก้ไขและลบ -->
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-{{ $user->id }}">แก้ไข</button>

                        <form action="{{ route('manageuser.destroy', ['id' => $user->id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('คุณต้องการลบผู้ใช้งานนี้ใช่หรือไม่?')">ลบ</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal เพิ่มข้อมูลผู้ใช้ -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">เพิ่มข้อมูลผู้ใช้งาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('manageuser.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">อีเมล</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">รหัสผ่าน</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_major" class="form-label">สาขาวิชา</label>
                            <input type="text" class="form-control" id="user_major" name="user_major">
                        </div>
                        <div class="mb-3">
                            <label for="user_type_id" class="form-label">สถานะ</label>
                            <select class="form-select" id="user_type_id" name="user_type_id">
                                @foreach ($userTypes as $type)
                                    <option value="{{ $type->user_type_id }}">{{ $type->user_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        // ฟังก์ชันกรองแถวในตาราง
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
    </script>
@endsection
