<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<form adtion="{{route('karupan.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-labelledby="ModalCreateLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('Create New')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-2">
                        <div class="form-group my-3">
                            <strong>ปีงบประมาณ</strong>
                            <input type="text" name="asset_name" class="form-control" placeholder="ปีงบประมาณ">
                            @error('Yesr')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>    
                    <div class="col-md-12">
                        <div class="mt-3 form-group">
                            <strong>ชื่อหน่วยงาน</strong>
                            <input type="text" name="asset_price" class="form-control" placeholder="ชื่อหน่วยงาน">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mt-3 form-group">
                            <strong>หมายเลขครุภัณฑ์</strong>
                            <input type="text" name="asset_regis_at " class="form-control" placeholder="หมายเลขครุภัณฑ์">
                            @error('หมายเลขครุภัณฑ์')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mt-3 form-group">
                            <strong>ชื่อครุภัณฑ์</strong>
                            <input type="text" name="asset_created_at" class="form-control" placeholder="ชื่อครุภัณฑ์">
                            @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mt-3 form-group">
                            <strong>สถานะ</strong>
                            <input type="text" name="asset_status_id" class="form-control" placeholder="ชื่อครุภัณฑ์">
                            @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mt-3 form-group">
                            <strong>หมายเหตุ</strong>
                            <input type="text" name="asset_comment" class="form-control" placeholder="ชื่อครุภัณฑ์">
                            @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    div class="col-md-12">
                        <div class="mt-3 form-group">
                            <strong>แหล่งเงิน</strong>
                            <input type="text" name="asset_number" class="form-control" placeholder="ชื่อครุภัณฑ์">
                            @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="mt-3 btn btn-primary">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

  </div>
</body>
</html>