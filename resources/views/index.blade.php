@extends('layoutmenu')

@section('title')
    หน้ารายการครุภัณฑ์
@endsection

@section('contentitle')
    หน้ารายการทั้งหมด
@endsection

@section('conten')
    <div>
        <button type="button" class="btn  mb-2 btn-success">Export</button>
        <a href="{{ route('create_karupan') }}" class="btn btn-primary"  style="float:right;">
            เพิ่มข้อมูล
        </a>
    </div>

    <table class="table table-bordered table-centered mb-0">
        <thead>
            <tr>
                <th>หมายเลขครุภัณฑ์</th>
                <th>ชื่อครุภัณฑ์</th>
                <th>ราคาต่อหน่วย</th>
                <th>จำนวน</th>
                <th>สถานที่ตั้ง</th>
                <th>หมายเหตุ</th>
                <th>จัดการข้อมูล</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asset as $karu)
                 <tr>
                    <td>{{ $karu->asset_number }}</td>
                    <td>{{ $karu->asset_name }}</td>
                    <td>{{ $karu->asset_price }}</td>
                    <td>{{ $karu->asset_amount }}</td>
                    <td>{{ $karu->asset_location }}</td>
                    <td>{{ $karu->asset_comment }}</td>
                    <td>
                        <!-- Button trigger modal -->
                        <button class="btn btn-primary edit-button"
                        id ="{{ $karu->asset_id }}"
                        data-bs-toggle="modal" data-bs-target="#editmodal">แก้ไขข้อมูล</button>
                        <a href="{{ route('delete', $karu->asset_id) }}" class="btn btn-danger"
                        onclick="return confirm('คุณต้องการลบ {{ $karu->asset_name }} หรือไม่ ?')">ลบ
                        </a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <div class="row">
        <div class="col-lg-12 mt-2">
            {{ $asset->links('pagination::bootstrap-5') }}
        </div>
    </div>


    @include('karupan.edit')


@endsection


@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function()
    {
        $(".edit-button").click(function(){
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
                $('.assetPlan').val(response.asset_paln)
                $('.assetprice').val(response.asset_price)
                $('.assetregis_at').val(response.asset_regis_at)
                $('.assetcreated_at').val(response.asset_created_at)
                $('.assetstatus_id').val(response.asset_status_id)
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


    $('.btn-sendsuccess').click(()=>{
        // Get the ID of the associated asset
        // var assetId = $(this).attr('id')
        // console.log('Asset ID:', assetId);'
        let id = $('.assetGetValue2').val()
        let comment = $('.assecomment').val()
        let getName = $('.assetGetName').val()
        let paln = $('.assetPlan').val()
        let price = $('.assetprice').val()
        let regis_at = $('.assetregis_at').val()
        let create_at = $('.assetcreated_at').val()
        let status_id = $('.assetstatus_id').val()
        let asset_number = $('.assetnumber').val()
        if(price != '' && getName != '' && regis_at != '' && create_at != '' && status_id != '' && asset_number != '') {
        console.log('Asset ID:', id);
        $.ajax({
            url: 'updatedata', // Replace 'editdata' with the correct URL
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}', // Include CSRF token
                assetId: id,
                comment2:comment,
                assetGetName:getName,
                assetPlan:paln,
                assetprice:price,
                assetregis_at:regis_at,
                assetcreated_at:create_at,
                assetstatus_id:status_id,
                assetnumber:asset_number
                // Assuming assetId is a variable containing the asset ID
            },
            success: function(response) {
                console.log(response);
                Swal.fire({
                    title: "ยืนยันเสร็จสิ้น",
                    icon: "success"
                }).then((value) => {
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Handle error response
            }
        });
    }else{
        Swal.fire({
        icon: "error",
        title: "ข้อผิดพลาด",
        text: "มีข้อผิดพลาดเกิดขึ้น โปรดตรวจสอบให้แน่ชัด",
        footer: '<a href="#">Why do I have this issue?</a>'
});
    }
    });


    });
    
</script>

<p id="demo"></p>

<script>
function makeid(length) {
    let randomString = '';
    for (let i = 0; i < length; i++) {
        randomString += Math.floor(Math.random() * 10); // สร้างตัวเลขสุ่ม
    }
    return randomString;
}

var asset_id = makeid(5); // สร้าง asset_id ที่มีความยาว 5 ตัวอักษร

// แสดงผล asset_id ใน HTML
document.getElementById("demo").innerHTML = "Asset ID: " + asset_id;
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

