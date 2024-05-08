
<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal fade text-left" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ __('Create New') }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-2">
                                        <div class="form-group my-3">
                                            <strong>No.</strong>
                                            <input type="text" name="asset_id" class="form-control" value="{{$karu->asset_id}}">

                                        </div>
                                    </div>
                                <div class="modal-body">
                                    <div class="col-md-2">
                                        <div class="form-group my-3">
                                            <strong>ชื่อครุภัณฑ์</strong>
                                            <input type="text" name="asset_name" class="form-control" value="{{$karu->asset_name}}">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 form-group">
                                            <strong>ราคาต่อหน่วย</strong>
                                            <input type="text" name="asset_price" class="form-control" value="{{$karu->asset_price}}">


                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 form-group">
                                            <strong>วันที่เริ่ม</strong>
                                            <input type="date" name="asset_regis_at" class="form-control" value="{{$karu->asset_regis_at}}">


                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 form-group">
                                            <strong>วันที่สิ้นสุด</strong>
                                            <input type="date" name="asset_created_at" class="form-control" value="{{$karu->asset_created_at}}">


                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 form-group">
                                            <strong>จำนวน</strong>
                                            <input type="text" name="asset_status_id" class="form-control" value="{{$karu->asset_status_id}}">


                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 form-group">
                                            <strong>หมายเหตุ</strong>
                                            <input type="text" name="asset_comment" class="form-control" value="{{$karu->asset_comment}}">

                                        </div>
                                    <div class="col-md-12">
                                            <div class="mt-3 form-group">
                                                <strong>หมายเลขครุภัณฑ์</strong>
                                                <input type="text" name="asset_number" class="form-control" value="{{$karu->asset_number}}">
    
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="mt-3 btn btn-primary">Submit</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
</body>

</html>
