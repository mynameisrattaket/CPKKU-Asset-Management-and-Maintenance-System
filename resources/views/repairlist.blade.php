@extends('layoutmenu')

@section('title', 'รายการแจ้งซ่อม')

@section('contentitle')
    <h4 class="page-title">รายการแจ้งซ่อม</h4>
@endsection

@section('conten')
    <div class="col-3 text-end mb-2 mt-2">
        <form id="searchForm" action="{{ route('repairlistsearch') }}" method="POST" class="d-flex">
            @csrf
            <input type="text" id="searchInput" class="form-control me-2 form-control-sm"
                placeholder="ค้นหารายการแจ้งซ่อม" name="search">
            <button class="btn btn-primary" type="submit">ค้นหา</button>
        </form>
    </div>
    <table class="table table-centered mb-0">
        <thead class="table-dark" >
            <tr>
                <th scope="col">ID</th>
                <th scope="col">ชื่อหรือประเภทของอุปกรณ์</th>
                <th scope="col">รายละเอียดอาการเสีย</th>
                <th scope="col">สถานที่</th>
                <th scope="col">หมายเลขครุภัณฑ์</th>
                <th scope="col">วันเวลาที่เเจ้ง</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($request as $repair)
                <tr>
                    <th scope="row">{{ $repair->request_detail_id }}</th>
                    <td>{{ $repair->asset_name }}</td>
                    <td>{{ $repair->asset_symptom_detail }}</td>
                    <td>{{ $repair->location }}</td>
                    <td>{{ $repair->asset_number }}</td>
                    <td>{{ $repair->request_time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
