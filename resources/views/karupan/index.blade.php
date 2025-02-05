@extends('layoutmenu')

@section('title', 'หน้ารายการครุภัณฑ์')

@section('contentitle', 'หน้ารายการทั้งหมด')

@section('conten')

    <!-- ปุ่มเพิ่มข้อมูล (ย้ายไปขวา) -->
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success" id="btn-add">เพิ่มครุภัณฑ์</button>
    </div>

    <table class="table table-centered dt-responsive" id="basic-datatable" style="width: 100%">
        <thead>
            <tr>
                <th>ไอดี</th>
                <th>หมายเลขครุภัณฑ์</th>
                <th>ชื่อครุภัณฑ์</th>
                <th class="text-center">ราคาต่อหน่วย</th>
                <th>ปีงบประมาณ</th>
                <th>สถานที่ตั้ง</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($asset as $karu)
                <tr data-id="{{ $karu->asset_id }}">
                    <td>{{ $karu->asset_id }}</td>
                    <td>{{ $karu->asset_number }}</td>
                    <td>{{ $karu->asset_name }}</td>
                    <td class="text-center">{{ number_format($karu->asset_price, 2) }}</td>
                    <td>{{ $karu->asset_budget }}</td>
                    <td>{{ $karu->asset_location }}</td>
                    <td class="d-inline-flex gap-1">
                        <button class="btn btn-warning btn-edit">แก้ไข</button>
                        <button class="btn btn-danger btn-delete">ลบ</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">ไม่มีข้อมูลครุภัณฑ์</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="assetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="assetForm">
                @csrf
                <input type="hidden" id="asset_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่ม/แก้ไขครุภัณฑ์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>หมายเลขครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_number" required>
                        </div>
                        <div class="mb-2">
                            <label>ชื่อครุภัณฑ์</label>
                            <input type="text" class="form-control" id="asset_name" required>
                        </div>
                        <div class="mb-2">
                            <label>ราคาต่อหน่วย</label>
                            <input type="number" class="form-control" id="asset_price" required>
                        </div>
                        <div class="mb-2">
                            <label>ปีงบประมาณ</label>
                            <input type="text" class="form-control" id="asset_budget" required>
                        </div>
                        <div class="mb-2">
                            <label>สถานที่ตั้ง</label>
                            <input type="text" class="form-control" id="asset_location" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let assetModal = new bootstrap.Modal($('#assetModal'));

            $('#btn-add').click(function() {
                $('#assetForm')[0].reset();
                $('#asset_id').val('');
                assetModal.show();
            });

            $('.btn-edit').click(function() {
                let id = $(this).closest('tr').data('id');
                $.get(`/asset/${id}/edit`, function(data) {
                    $('#asset_id').val(data.asset_id);
                    $('#asset_number').val(data.asset_number);
                    $('#asset_name').val(data.asset_name);
                    $('#asset_price').val(data.asset_price);
                    $('#asset_budget').val(data.asset_budget);
                    $('#asset_location').val(data.asset_location);
                    assetModal.show();
                });
            });

            $('#assetForm').submit(function(e) {
                e.preventDefault();
                let id = $('#asset_id').val();
                let url = id ? `/asset/${id}` : '/asset';
                let method = id ? 'PUT' : 'POST';
                let formData = {
                    asset_number: $('#asset_number').val(),
                    asset_name: $('#asset_name').val(),
                    asset_price: $('#asset_price').val(),
                    asset_budget: $('#asset_budget').val(),
                    asset_location: $('#asset_location').val(),
                    _token: $('input[name=_token]').val()
                };

                $.ajax({ url, type: method, data: formData, success: function() {
                    location.reload();
                }});
            });

            $('.btn-delete').click(function() {
                let id = $(this).closest('tr').data('id');
                Swal.fire({
                    title: 'ยืนยันการลบ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({ url: `/asset/${id}`, type: 'DELETE', data: { _token: '{{ csrf_token() }}' }, success: function() {
                            location.reload();
                        }});
                    }
                });
            });
        });
    </script>
@endsection
