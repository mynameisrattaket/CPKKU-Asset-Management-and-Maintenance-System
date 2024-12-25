@extends('layouts.app')

@section('content')
<div class="container">
    <h2>รายการการยืมครุภัณฑ์</h2>
    <table class="table">
        <thead>
            <tr>
                <th>หมายเลขครุภัณฑ์</th>
                <th>ชื่อครุภัณฑ์</th>
                <th>ชื่อผู้ยืม</th>
                <th>วันที่ยืม</th>
                <th>วันที่คาดว่าจะคืน</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrowRequests as $borrowRequest)
                <tr>
                    <td>{{ $borrowRequest->asset->asset_number }}</td>
                    <td>{{ $borrowRequest->asset->asset_name }}</td>
                    <td>{{ $borrowRequest->borrower_name }}</td>
                    <td>{{ $borrowRequest->borrow_date }}</td>
                    <td>{{ $borrowRequest->return_date }}</td>
                    <td>{{ $borrowRequest->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
