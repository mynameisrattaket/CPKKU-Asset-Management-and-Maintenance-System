@extends('layoutmenu')

@section('title')
    หน้ารายการครุภัณฑ์
@endsection

@section('contentitle')
    หน้ารายการทั้งหมด
@endsection

@section('conten')

    <table class="table table-centered dt-responsive " id="basic-datatable" style="width: 100%">
        <thead>
            <tr>
                <th style="width: 0%">ไอดี</th>
                <th style="width: 25%">หมายเลขครุภัณฑ์</th>
                <th style="width: 25%">ชื่อครุภัณฑ์</th>
                <th style="width: 10%">ราคาต่อหน่วย</th>
                <th style="width: 5%">ปีงบประมาณ</th>
                <th style="width: 10%">สถานที่ตั้ง</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asset as $karu)
                <tr>
                    <td>{{ $karu->asset_id }}</td>
                    <td>{{ $karu->asset_number }}</td>
                    <td>{{ $karu->asset_name }}</td>
                    <td class="text-center">{{ $karu->asset_price }}</td>
                    <td>{{ $karu->asset_budget }}</td>
                    <td>{{ $karu->asset_location }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

@endsection


@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".edit-button").click(function() {
                // Get the ID of the associated asset
                var assetId = $(this).attr('id')
                console.log('Assadset ID:', assetId);
                $.ajax({
                    url: 'viewpreeditdata', // Replace 'editdata' with the correct URL
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        assetId: assetId // Assuming assetId is a variable containing the asset ID
                    },
                    success: function(response) {
                        console.log(response.asset_id);
                        $('.assetGetValue2').val(response.asset_id)
                        $('.assetGetName').val(response.asset_name)
                        $('.assetPlan').val(response.asset_plan)
                        $('.assetprice').val(response.asset_price)
                        $('.assetregis_at').val(response.asset_regis_at)
                        $('.assetcreated_at').val(response.asset_created_at)
                        $('.assetstatus_id').val(response.asset_asset_status_id)
                        $('.assecomment').val(response.asset_comment)
                        $('.assetnumber').val(response.asset_number)
                        // Handle success response
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Handle error response
                    }
                });

            });

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
