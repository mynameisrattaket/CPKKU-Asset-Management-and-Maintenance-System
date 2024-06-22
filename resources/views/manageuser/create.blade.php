@extends('layoutmenu')

@section('title', 'เพิ่มผู้ใช้งานใหม่')

@section('contentitle')
    <h4 class="page-title">เพิ่มผู้ใช้งานใหม่</h4>
@endsection

@section('conten')
    <form action="{{ route('manageuser.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user_first_name" class="form-label">ชื่อ</label>
            <input type="text" class="form-control" id="user_first_name" name="user_first_name" required>
            <!-- สำหรับการรับข้อมูลชื่อผู้ใช้ โดยจำเป็นต้องมีการกรอก -->
        </div>
        <div class="mb-3">
            <label for="user_last_name" class="form-label">นามสกุล</label>
            <input type="text" class="form-control" id="user_last_name" name="user_last_name" required>
            <!-- สำหรับการรับข้อมูลนามสกุลผู้ใช้ โดยจำเป็นต้องมีการกรอก -->
        </div>
        <div class="mb-3">
            <label for="user_email" class="form-label">อีเมล</label>
            <input type="email" class="form-control" id="user_email" name="user_email" required>
            <!-- สำหรับการรับข้อมูลอีเมลผู้ใช้ โดยจำเป็นต้องมีการกรอก และต้องเป็นรูปแบบอีเมลที่ถูกต้อง -->
        </div>
        <div class="mb-3">
            <label for="user_password" class="form-label">รหัสผ่าน</label>
            <input type="password" class="form-control" id="user_password" name="user_password" required>
            <!-- สำหรับการรับข้อมูลรหัสผ่านผู้ใช้ โดยจำเป็นต้องมีการกรอก -->
        </div>
        <div class="mb-3">
            <label for="faculty_faculty_id" class="form-label">คณะ</label>
            <input type="text" class="form-control" id="faculty_faculty_id" name="faculty_faculty_id" required>
            <!-- สำหรับการรับข้อมูลรหัสคณะ โดยจำเป็นต้องมีการกรอก -->
        </div>
        <div class="mb-3">
            <label for="user_major" class="form-label">สาขาวิชา</label>
            <input type="text" class="form-control" id="user_major" name="user_major" required>
            <!-- สำหรับการรับข้อมูลสาขาวิชา โดยจำเป็นต้องมีการกรอก -->
        </div>
        <div class="mb-3">
            <label for="user_type_id" class="form-label">สถานะ</label>
            <input type="text" class="form-control" id="user_type_id" name="user_type_id" required>
            <!-- สำหรับการรับข้อมูลสถานะผู้ใช้ โดยจำเป็นต้องมีการกรอก -->
        </div>

        <button type="submit" class="btn btn-primary">เพิ่มผู้ใช้งาน</button>
    </form>
@endsection
