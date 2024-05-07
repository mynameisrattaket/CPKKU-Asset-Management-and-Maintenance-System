<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
          <div class="col-md-2">
            <div class="form-group my-3">
                <strong>ปีงบประมาณ</strong>
                <input type="text" name="Yesr" class="form-control" placeholder="ปีงบประมาณ">
                @error('Yesr')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>    
        <div class="col-md-12">
            <div class="mt-3 form-group">
                <strong>ชื่อหน่วยงาน</strong>
                <input type="text" name="X" class="form-control" placeholder="ชื่อหน่วยงาน">
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="mt-3 form-group">
                <strong>หมายเลขครุภัณฑ์</strong>
                <input type="text" name="C" class="form-control" placeholder="หมายเลขครุภัณฑ์">
                @error('หมายเลขครุภัณฑ์')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="mt-3 form-group">
                <strong>ชื่อครุภัณฑ์</strong>
                <input type="text" name="C" class="form-control" placeholder="ชื่อครุภัณฑ์">
                @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <button type="submit" class="mt-3 btn btn-primary">Submit</button>
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>