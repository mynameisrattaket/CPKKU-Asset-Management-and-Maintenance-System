@extends('layoutmenu')

@section('title', 'แก้ไขข้อมูลผู้ใช้งาน')

@section('contentitle')
    <h4 class="page-title">แก้ไขข้อมูลผู้ใช้งาน</h4>
@endsection

@section('conten')
    <form action="{{ route('manageuser.update', ['id' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="user_first_name">ชื่อ</label>
            <input type="text" class="form-control" id="user_first_name" name="user_first_name" value="{{ $user->user_first_name }}" required>
        </div>
        <div class="form-group">
            <label for="user_last_name">นามสกุล</label>
            <input type="text" class="form-control" id="user_last_name" name="user_last_name" value="{{ $user->user_last_name }}" required>
        </div>
        <div class="form-group">
            <label for="user_email">อีเมล</label>
            <input type="email" class="form-control" id="user_email" name="user_email" value="{{ $user->user_email }}" required>
        </div>
        <!-- เพิ่มฟิลด์อื่นๆ ตามต้องการ -->

        <button type="submit" class="btn btn-primary">อัปเดตข้อมูล</button>
    </form>
@endsection
