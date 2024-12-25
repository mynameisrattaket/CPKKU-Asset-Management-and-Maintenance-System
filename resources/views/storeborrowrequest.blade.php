@extends('layouts.app')

@section('content')
<div class="container">
    <h2>ฟอร์มยืมครุภัณฑ์</h2>

    <form action="{{ route('storeborrowrequest.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="asset_id">เลือกครุภัณฑ์</label>
            <select name="asset_id" id="asset_id" class="form-control" required>
                <option value="">เลือกครุภัณฑ์</option>
                @foreach($assets as $asset)
                    <option value="{{ $asset->id }}">{{ $asset->asset_number }} - {{ $asset->asset_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="borrower_name">ชื่อผู้ยืม</label>
            <input type="text" name="borrower_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="borrow_date">วันที่ยืม</label>
            <input type="date" name="borrow_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="return_date">วันที่คาดว่าจะคืน</label>
            <input type="date" name="return_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">บันทึกการยืม</button>
    </form>
</div>
@endsection
