<div>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addtec">เพิ่มช่าง</button>

    <table class="table table-centered mb-0">
        <thead class="table-dark">
            <tr>
                <th>ไอดี</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>อีเมล</th>
                <th>ระดับผู้ใช้งาน</th>
                <th>จัดการข้อมูล</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($show as $item)
                <tr>
                    <td>{{ $item->user_id }}</td>
                    <td>{{ $item->user_first_name }}</td>
                    <td>{{ $item->user_last_name }}</td>
                    <td>{{ $item->user_email }}</td>
                    <td>{{ $item->user_type }}</td>
                    <td>
                        <a href="#" class="action-icon text-warning"><i class="mdi mdi-pencil"></i></a>
                        <a href="#" class="action-icon text-danger"><i class="mdi mdi-delete"></i></a>
                        <a href="#" class="action-icon text-primary"><i class="mdi mdi-eye"></i></a>
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>

    <div class="modal fade" id="addtec" tabindex="-1" aria-labelledby="addtec" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addtec">เพิ่มช่าง (กรุนากรอกข้อมูลให้ครบถ้วน)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="">

                        <div class="mb-3">
                            <label for="name" class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" id="firstname" aria-describedby="firstname">
                            <div id="firstname" class="form-text">ชื่อเเละนามสกุลไม่ควรใส่ช่องเดียวกัน</div>
                        </div>

                        <div class="mb-3">
                            <label for="lastname" class="form-label">นามสกุล</label>
                            <input type="text" class="form-control" id="lasttname" aria-describedby="lastname">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">อีเมล</label>
                            <input type="email" class="form-control" id="email" aria-describedby="email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">อีเมล</label>
                            <input type="text" class="form-control" id="password" aria-describedby="password">
                        </div>

                        <fieldset disabled>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">ระดับผู้ใช้งาน</label>
                                <input type="text" class="form-control" id="lasttname" aria-describedby="lastname"
                                    value="ช่างเทคนิค">
                            </div>
                        </fieldset>

                        <div class="mb-3">
                            <label for="text" class="form-label">คณะ</label>
                            <input type="text" class="form-control" id="text" aria-describedby="f">
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">สาขา</label>
                            <input type="text" class="form-control" id="text" aria-describedby="cs">
                        </div>

                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary">ยืนยัน</button>
                </div>

            </div>
        </div>
    </div>

</div>
