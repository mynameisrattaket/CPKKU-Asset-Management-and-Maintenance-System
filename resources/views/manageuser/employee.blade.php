@extends('layoutmenu')

@section('title', 'จัดการข้อมูลพนักงาน')

@section('contentitle')
    <h4 class="page-title">จัดการข้อมูลพนักงาน</h4>
@endsection

@section('conten')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table id="userTable" class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">ไอดี</th>
                <th scope="col">ชื่อ</th>
                <th scope="col">นามสกุล</th>
                <th scope="col">อีเมล</th>
                <th scope="col">รหัสผ่าน</th>
                <th scope="col">สาขาวิชา</th>
                <th scope="col">สถานะ</th>
                <th scope="col">จัดการข้อมูล</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->user_first_name }}</td>
                    <td>{{ $user->user_last_name }}</td>
                    <td>{{ $user->user_email }}</td>
                    <td>{{ $user->user_password }}</td>
                    <td>{{ $user->user_major }}</td>
                    <td>{{ $user->user_type_name }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal-{{ $user->user_id }}">แก้ไข</button>
                        <form action="{{ route('manageuser.destroy', ['id' => $user->user_id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('คุณต้องการลบผู้ใช้งานนี้ใช่หรือไม่?')">ลบ</button>
                        </form>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal-{{ $user->user_id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $user->user_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel-{{ $user->user_id }}">แก้ไขข้อมูลผู้ใช้งาน</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('manageuser.update', ['id' => $user->user_id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="user_first_name-{{ $user->user_id }}" class="form-label">ชื่อ</label>
                                                <input type="text" class="form-control" id="user_first_name-{{ $user->user_id }}" name="user_first_name" value="{{ $user->user_first_name }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="user_last_name-{{ $user->user_id }}" class="form-label">นามสกุล</label>
                                                <input type="text" class="form-control" id="user_last_name-{{ $user->user_id }}" name="user_last_name" value="{{ $user->user_last_name }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="user_email-{{ $user->user_id }}" class="form-label">อีเมล</label>
                                                <input type="email" class="form-control" id="user_email-{{ $user->user_id }}" name="user_email" value="{{ $user->user_email }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="user_password-{{ $user->user_id }}" class="form-label">รหัสผ่าน</label>
                                                <input type="text" class="form-control" id="user_password-{{ $user->user_id }}" name="user_password" value="{{ $user->user_password }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="user_major-{{ $user->user_id }}" class="form-label">สาขาวิชา</label>
                                                <input type="text" class="form-control" id="user_major-{{ $user->user_id }}" name="user_major" value="{{ $user->user_major }}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="user_type_id-{{ $user->user_id }}" class="form-label">สถานะ</label>
                                                <select class="form-select" id="user_type_id-{{ $user->user_id }}" name="user_type_id">
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
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    @parent

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
            var table = $('#userTable').DataTable({
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
