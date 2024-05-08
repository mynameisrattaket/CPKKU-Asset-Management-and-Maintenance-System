
<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="insert" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog"
                        aria-labelledby="ModalCreateLabel" aria-hidden="true">
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
                                            <strong>ชื่อครุภัณฑ์</strong>
                                            <input type="text" name="asset_name" class="form-control"
                                                placeholder="ชื่อครุภัณฑ์">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 form-group">
                                            <strong>ราคาต่อหน่วย</strong>
                                            <input type="text" name="asset_price" class="form-control"
                                                placeholder="ราคาต่อหน่วย">


                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 form-group">
                                            <strong>วันที่เริ่ม</strong>
                                            <input type="date" name="asset_regis_at" class="form-control"
                                                placeholder="วันที่เริ่ม">


                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 form-group">
                                            <strong>วันที่สิ้นสุด</strong>
                                            <input type="date" name="asset_created_at" class="form-control"
                                                placeholder="วันที่สิ้นสุด">


                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 form-group">
                                            <strong>จำนวน</strong>
                                            <input type="text" name="asset_status_id" class="form-control"
                                                placeholder="จำนวน">


                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-3 form-group">
                                            <strong>หมายเหตุ</strong>
                                            <input type="text" name="asset_comment" class="form-control"
                                                placeholder="หมายเหตุ">

                                        </div>
                                    <div class="col-md-12">
                                            <div class="mt-3 form-group">
                                                <strong>หมายเลขครุภัณฑ์</strong>
                                                <input type="text" name="asset_number" class="form-control"
                                                    placeholder="หมายเลขครุภัณฑ์">
    
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
