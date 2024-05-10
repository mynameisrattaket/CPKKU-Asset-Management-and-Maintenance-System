<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12">

            <form action="insert" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel">Create New</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-2">
                                    <div class="form-group my-3">
                                        <strong>ชื่อครุภัณฑ์</strong>
                                        <input type="text" name="asset_name" class="form-control"
                                            placeholder="ชื่อครุภัณฑ์">

                                    </div>
                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>แผนงาน</strong>
                                        <input type="text" name="asset_plan" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>โครงการ</strong>
                                        <input type="text" name="asset_project" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>กิจกรรม</strong>
                                        <input type="text" name="asset_activity" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>แหล่งเงิน</strong>
                                        <input type="text" name="asset_baget" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>กองทุน</strong>
                                        <input type="text" name="asset_fund" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>คณะ/ศูนย์/สำนัก</strong>
                                        <input type="text" name="asset_faculty" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>หน่วยงานย่อย</strong>
                                        <input type="text" name="asset_major" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>สถานที่ตั้ง</strong>
                                        <input type="text" name="asset_location" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>ประเภทการรับ</strong>
                                        <input type="text" name="asset_reception_type" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>ค่าเสื่อมราคาสะสม</strong>
                                        <input type="text" name="deteriorated_total" class="form-control"
                                            placeholder="ค่าเสื่อมราคาสะสม">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>ราคาซาก</strong>
                                        <input type="text" name="scrap_price" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>บัญชีค่าเสื่อมราคา</strong>
                                        <input type="text" name="deteriorated_account" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>ค่าเสื่อม</strong>
                                        <input type="text" name="deteriorated" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>วันที่เริ่มต้นการคำนวณค่าเสื่อมราคา</strong>
                                        <input type="text" name="deteriorated_at" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>วันที่หยุดการคำนวณค่าเสื่อมราคา</strong>
                                        <input type="text" name="asset_deteriorated_stop" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>ที่มาของทรัพย์สิน</strong>
                                        <input type="text" name="asset_get" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>สถานะ</strong>
                                        <input type="text" name="asset_status" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>เลขที่เอกสาร</strong>
                                        <input type="text" name="asset_document_number" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>หน่วยนับ</strong>
                                        <input type="text" name="asset_countingunit" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>ค่าเสื่อมราคายกมา</strong>
                                        <input type="text" name="deteriorated_price" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>ราคาตามบัญชี</strong>
                                        <input type="text" name="asset_price_account" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>บัญชีทรัพย์สินถาวร</strong>
                                        <input type="text" name="asset_account" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>บัญชีค่าเสื่อมราคาสะสม</strong>
                                        <input type="text" name="deteriorated_total_account" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>อายุการใช้งาน(ปี)</strong>
                                        <input type="text" name="asset_live" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>วันที่สิ้นสุดการคำนวณค่าเสื่อมราคา</strong>
                                        <input type="text" name="deteriorated_end" class="form-control"
                                            placeholder="ราคาต่อหน่วย">

                                    </div>
                                </div> --}}
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
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3 form-group">
                                        <strong>หมายเลขครุภัณฑ์</strong>
                                        <input type="text" name="asset_number" class="form-control"
                                            placeholder="หมายเลขครุภัณฑ์">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="mt-3 btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="mt-3 btn btn-primary">Submit</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
