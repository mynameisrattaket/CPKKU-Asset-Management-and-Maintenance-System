@extends('layoutmenu')

@section('title', 'แก้ไขข้อมูลผู้ใช้งาน')

@section('contentitle')
    <h4 class="page-title">แก้ไขข้อมูลผู้ใช้งาน</h4>
@endsection

@section('conten')
    <form action="{{ route('manageuser.update', ['id' => $user->user_id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="user_first_name" class="form-label">ชื่อ</label>
            <input type="text" class="form-control" id="user_first_name" name="user_first_name" value="{{ $user->user_first_name }}">
        </div>

        <div class="mb-3">
            <label for="user_last_name" class="form-label">นามสกุล</label>
            <input type="text" class="form-control" id="user_last_name" name="user_last_name" value="{{ $user->user_last_name }}">
        </div>

        <div class="mb-3">
            <label for="user_email" class="form-label">อีเมล</label>
            <input type="email" class="form-control" id="user_email" name="user_email" value="{{ $user->user_email }}">
        </div>

        <div class="mb-3">
            <label for="user_password" class="form-label">รหัสผ่าน</label>
            <input type="text" class="form-control" id="user_password" name="user_password" value="{{ $user->user_password }}">
        </div>

        <div class="mb-3">
            <label for="faculty_faculty_id" class="form-label">คณะ</label>
            <input type="text" class="form-control" id="faculty_faculty_id" name="faculty_faculty_id" value="{{ $user->faculty_faculty_id }}">
        </div>

        <div class="mb-3">
            <label for="user_major" class="form-label">สาขาวิชา</label>
            <input type="text" class="form-control" id="user_major" name="user_major" value="{{ $user->user_major }}">
        </div>

        <div class="mb-3">
            <label for="user_type_id" class="form-label">สถานะ</label>
            <input type="text" class="form-control" id="user_type_id" name="user_type_id" value="{{ $user->user_type_id }}">
        </div>

        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
@endsection
