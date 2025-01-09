@extends('layouts.app')

@section('content')
<div class="container">
    <h1>รายการการยืมครุภัณฑ์</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อครุภัณฑ์</th>
                <th>ชื่อผู้ยืม</th>
                <th>วันที่ยืม</th>
                <th>วันที่คืน</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($borrowRequests as $request)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $request->asset->asset_name }}</td>
                    <td>{{ $request->borrower_name }}</td>
                    <td>{{ $request->borrow_date }}</td>
                    <td>{{ $request->return_date }}</td>
                    <td>{{ $request->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
