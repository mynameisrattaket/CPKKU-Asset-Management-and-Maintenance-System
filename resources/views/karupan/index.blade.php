@extends('layoutmenu')

@section('title', 'หน้ารายการครุภัณฑ์')

@section('contentitle', 'หน้ารายการทั้งหมด')

@section('conten')
    <table class="table table-centered dt-responsive" id="basic-datatable" style="width: 100%">
        <thead>
            <tr>
                <th>ไอดี</th>
                <th>หมายเลขครุภัณฑ์</th>
                <th>ชื่อครุภัณฑ์</th>
                <th class="text-center">ราคาต่อหน่วย</th>
                <th>ปีงบประมาณ</th>
                <th>สถานที่ตั้ง</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($asset as $karu)
                <tr>
                    <td>{{ $karu->asset_id }}</td>
                    <td>{{ $karu->asset_number }}</td>
                    <td>{{ $karu->asset_name }}</td>
                    <td class="text-center">{{ number_format($karu->asset_price, 2) }}</td>
                    <td>{{ $karu->asset_budget }}</td>
                    <td>{{ $karu->asset_location }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">ไม่มีข้อมูลครุภัณฑ์</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
