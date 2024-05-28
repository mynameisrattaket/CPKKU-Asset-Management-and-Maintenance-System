<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="storage/app/public/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Karupan</h2>
            </div>
            <div>
            <button type="button "  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalCreate" style="float:right;">
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
                        <th>ราคาต่อหน่วย</th>
                        <th>หมายเลขครุภัณฑ์</th>
                        <th>Action</th>
                        <th>หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($karupan as $karu)
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
                                <button type="button" value="{{ $karu->asset_id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Edit
                                </button>
                           <button type="button" class="btn btn-primary btnn-sm">Delete</button>  
                        </td>
                    
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $karupan->links('pagination::bootstrap-5') !!}
        </div>
    </div>
    @include('karupan.create')
    @include('karupan.modal')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>