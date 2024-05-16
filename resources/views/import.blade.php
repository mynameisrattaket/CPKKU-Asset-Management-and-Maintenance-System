@extends('layoutmenu')

@section('title', 'นำเข้าข้อมูล')

@section('contentitle')
    <h4 class="page-title">นำเข้าข้อมูลครุภัณฑ์</h4>
@endsection
@section('conten')


@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<form action="{{ route('storeAssetFromExcel') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal-body">
    <div class="mb-3">
        <label for="excel_file" class="form-label">อัปโหลดไฟล์ Excel:</label>
        <input type="file" class="form-control" id="excel_file" name="excel_file">
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success">อัปโหลด</button>
</div>
</form>
   
@endsection


