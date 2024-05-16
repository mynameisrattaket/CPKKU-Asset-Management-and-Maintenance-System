// View
@extends('layoutmenu')

@section('title', 'รายการครุภัณฑ์ที่อัปโหลด')

@section('contentitle')
    <h4 class="page-title">รายการครุภัณฑ์ที่อัปโหลด</h4>
@endsection

@section('content')
    <!-- เนื้อหารายการครุภัณฑ์ที่อัปโหลด -->
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

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อ</th>
                <th>รายละเอียด</th>
                <!-- เพิ่มคอลัมน์ตามที่ต้องการ -->
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $asset)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->description }}</td>
                    <!-- แสดงข้อมูลเพิ่มเติมตามคอลัมน์ที่มีอยู่ในโมเดล Asset -->
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
