@extends('layoutmenu')

@section('title', 'จัดการข้อมูลผู้ใช้งาน')

@section('contentitle')
    <h4 class="page-title">จัดการข้อมูลผู้ใช้งาน</h4>
@endsection

@section('conten')
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('usermain.create') }}" class="btn btn-primary">เพิ่มผู้ใช้งานใหม่</a>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Last Login At</th>
                <th scope="col">Faculty ID</th>
                <th scope="col">Major</th>
                <th scope="col">User Type ID</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->user_first_name }}</td>
                    <td>{{ $user->user_last_name }}</td>
                    <td>{{ $user->user_email }}</td>
                    <td>{{ $user->user_Last_login_at }}</td>
                    <td>{{ $user->faculty_faculty_id }}</td>
                    <td>{{ $user->user_major }}</td>
                    <td>{{ $user->user_type_id }}</td>
                    <td>
                        <a href="{{ route('usermain.edit', ['id' => $user->user_id]) }}" class="btn btn-sm btn-primary">แก้ไข</a>
                        <form action="{{ route('usermain.delete', ['id' => $user->user_id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('คุณต้องการลบผู้ใช้งานนี้ใช่หรือไม่?')">ลบ</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
