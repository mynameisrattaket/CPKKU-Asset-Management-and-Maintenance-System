@extends('layoutmenu')

@section('title')
    หน้ารายการครุภัณฑ์
@endsection

@section('contentitle')
    หน้ารายการทั้งงหมด
@endsection
@section('conten')
    <div>
        <button type="button " class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalCreate" style="float:right;">
            Create
        </button>
    </div>
    @if ($message = Session::get('success'))
        <div class="alet alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered table-centered mb-0">
        <thead>
            <tr>
                <th>NO.</th>
                <th>ชื่อครุภัณฑ์</th>
                <th>ราคาต่อหน่วย</th>
                <th>วันที่เริ่ม</th>
                <th>วันที่สิ้นสุด</th>
                <th>จำนวน</th>
                <th>หมายเหตุ</th>
                <th>หมายเลขครุภัณฑ์</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asset as $karu)
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
                            <button type="button" value="{{$karu->asset_id }}" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Edit
                            </button>
                            <a 
                        href="{{route('delete',$karu->asset_id)}}" 
                        class="btn btn-danger"
                        onclick="return confirm('คุณต้องการลบบทความ {{$karu->asset_name}} หรือไม่ ?')"
                        >ลบ
                        </a>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="script.js"></script>
    @include('karupan.create')
    @include('karupan.edit')
@endsection
