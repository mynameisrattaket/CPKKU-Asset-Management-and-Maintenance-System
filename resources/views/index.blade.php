@extends('layoutmenu')
@section('title')
    หน้ารายการครุภัณฑ์
@endsection
@section('contentitle')
    หน้ารายการทั้งงหมด
@endsection
@section('conten')
<table class="table table-bordered table-centered mb-0">
    <thead>
        <tr>
            <th>NO.</th>
            <th>ชื่อครุภัณฑ์</th>
            <th>ราคาต่อหน่วย</th>
            <th>วันที่เริ่ม</th>
            <th>วันที่สิ้นสุด</th>
            <th>จำนวน</th>
            <th>ราคาต่อหน่วย</th>
            <th>หมายเลขครุภัณฑ์</th>
            <th>Action</th>
            <th>หมายเหตุ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($karupan as $karu)
                    <tr>
                        <td>{{ $karu->asset_id }}</td>
                        <td>{{ $karu->asset_name }}</td>
                        <td>{{ $karu->asset_price }}</td>
                        <td>{{ $karu->asset_regis_at }}</td>
                        <td>{{ $karu->asset_created_at }}</td>
                        <td>{{ $karu->asset_status_id }}</td>
                        <td>{{ $karu->asset_comment }}</td>
                        <td>{{ $karu->asset_number }}</td>
                        <td>
                            <!-- Button trigger modal -->
                                <button type="button" value="{{ $karu->asset_id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Edit
                                </button>
                           <button type="button" class="btn btn-primary btnn-sm">Delete</button>  
                        </td>
                    
                    </tr>
                    @endforeach
    </tbody>
</table>
{!! $karupan->links('pagination::bootstrap-5') !!}

@endsection