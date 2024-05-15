@extends('layoutmenu')

@section('title', 'รายการคำร้องการยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title">รายการคำร้องการยืมครุภัณฑ์</h4>
@endsection

@section('conten')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>หมายเลขอุปกรณ์</th>
                    <th>ชื่ออุปกรณ์</th>
                    <th>ชื่อผู้ยืม</th>
                    <th>นามสกุลผู้ยืม</th>
                    <th>วันที่ต้องการคืน</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->asset_number }}</td>
                        <td>{{ $request->asset_name }}</td>
                        <td>{{ $request->borrower_name }}</td>
                        <td>{{ $request->borrower_surname }}</td>
                        <td>{{ $request->return_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
