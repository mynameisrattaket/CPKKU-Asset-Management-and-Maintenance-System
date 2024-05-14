@extends('layoutmenu')

@section('title', 'รายการยืมครุภัณฑ์')

@section('contentitle')
    <h4 class="page-title">รายการยืมครุภัณฑ์</h4>
@endsection

@section('conten')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">หมายเลขอุปกรณ์</th>
                <th scope="col">ชื่ออุปกรณ์</th>
                <th scope="col">ชื่อผู้ยืม</th>
                <th scope="col">นามสกุลผู้ยืม</th>
                <th scope="col">วันที่ต้องการคืน</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($borrowRequests as $borrowRequest)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $borrowRequest->asset_number }}</td>
                    <td>{{ $borrowRequest->asset_name }}</td>
                    <td>{{ $borrowRequest->borrower_name }}</td>
                    <td>{{ $borrowRequest->borrower_surname }}</td>
                    <td>{{ $borrowRequest->return_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
