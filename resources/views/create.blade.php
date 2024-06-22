@extends('layoutmenu')

@section('title', 'เพิ่มผู้ใช้งานใหม่')

@section('contentitle')
    <h4 class="page-title">เพิ่มผู้ใช้งานใหม่</h4>
@endsection

@section('conten')
    <form action="{{ route('manageuser.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_first_name">ชื่อ</label>
            <input type="text" class="form-control" id="user_first_name" name="user_first_name" required>
        </div>
        <div class="form-group">
            <label for="user_last_name">นามสกุล</label>
            <input type="text" class="form-control" id="user_last_name" name="user_last_name" required>
        </div>
        <div class="form-group">
            <label for="user_email">อีเมล</label>
            <input type="email" class="form-control" id="user_email" name="user_email" required>
        </div>
        <!-- เพิ่มฟิลด์อื่นๆ ตามต้องการ -->

        <button type="submit" class="btn btn-primary">เพิ่มผู้ใช้งาน</button>
    </form>
@endsection
