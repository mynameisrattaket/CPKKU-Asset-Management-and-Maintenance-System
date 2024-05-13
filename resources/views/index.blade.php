@extends('layoutmenu')

@section('title')
    หน้ารายการครุภัณฑ์
@endsection

@section('contentitle')
    หน้ารายการทั้งงหมด
@endsection

@section('conten')
    <div>
        <button type="button" class="btn  mb-2 btn-success">Export</button>
        <button type="button " class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalCreate" style="float:right;">
            Create
        </button>
    </div>

    <table class="table table-bordered table-centered mb-0">
        <thead>
            <tr>
                <th>NO.</th>
                <th>ชื่อครุภัณฑ์</th>
                <th>ราคาต่อหน่วย</th>
                <th>วันที่เริ่ม</th>
                <th>วันที่สิ้นสุด</th>
                <th>จำนวน</th>
                <th>หมายเหตุ</th>
                <th>หมายเลขครุภัณฑ์</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asset as $karu)
                <tr>
                    <td>{{ $karu->asset_id }}</td>
                    <td>{{ $karu->asset_name }}</td>
                    <td>{{ $karu->asset_price }}</td>
                    <td>{{ $karu->asset_regis_at }}</td>
                    <td>{{ $karu->asset_created_at }}</td>
                    <td>{{ $karu->asset_status_id }}</td>
                    <td>{{ $karu->asset_comment }}</td>
                    <td>{{ $karu->asset_number }}</td>
                    <td>
                        <!-- Button trigger modal -->

                        <button class="btn btn-primary edit-button" 
                        id ="{{ $karu->asset_id }}"
                        data-bs-toggle="modal" data-bs-target="#editmodal">edit</button>

                        <a href="{{ route('delete', $karu->asset_id) }}" class="btn btn-danger"
                            onclick="return confirm('คุณต้องการลบบทความ {{ $karu->asset_name }} หรือไม่ ?')">ลบ
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

    @include('karupan.create')

    @include('karupan.edit')

    @include('karupan.modal')
@endsection


@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function()
    {
        $('.edit-button').click(function(){
        // Get the ID of the associated asset
        var assetId = $(this).attr('id')
        console.log('Asset ID:', assetId);
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
                $('.assetproject').val(response.asset_project)
                $('.assetstatus_id').val(response.asset_status_id)
                // Handle success response
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Handle error response
            }
        });

    });
    });
    // $('#updateForm').submit(function(event){
    //     event.preventDefault(); // Prevent default form submission

    //     // Serialize form data
    //     var formData = $(this).serialize();
    //     console.log(asset_id);
    // $.ajax({
    //         url: 'edit/'+assetId,
    //         method: "POST",
    //         data: formData,
    //         success: function(response) {
    //             console.log(response)
    //         },
    //         error: function(xhr, status, error) {
    //             console,error(error);
    //         }
    //     });
    // });
</script>

@endsection

