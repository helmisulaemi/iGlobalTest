
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                  <div class="container">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-6"><h4>Kelola data Karyawan</h4></div>
                            <div class="col-md-6 text-right"> 
                              <a class="btn btn-success" href="javascript:void(0)" id="createNewEmployee"> Tambah data</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-md-12">
                          <table class="table table-bordered data-table">
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Nama</th>
                                      <th>Alamat</th>
                                      <th width="280px">Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                        </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="formModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="employeeForm" name="employeeForm" class="form-horizontal" type="POST">
                   <input type="hidden" name="employee_id" id="employee_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nama</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama" required>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Alamat</label>
                        <div class="col-sm-12">
                            <textarea id="alamat" name="alamat" placeholder="Masukan Alamat" class="form-control" required></textarea>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(function () {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('employee.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'Nama', name: 'Nama'},
            {data: 'Alamat', name: 'Alamat'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#createNewEmployee').click(function () {
        $('#saveBtn').val("create-employee");
        $('#saveBtn').html('Simpan');
        $('#employee_id').val('');
        $('#employeeForm').trigger("reset");
        $('#modelHeading').html("Tambah Karyawan");
        $('#formModal').modal('show');
    });
    
    $('body').on('click', '.editEmployee', function () {
      var employee_id = $(this).data('id');
      $.get("{{ route('employee.index') }}" +'/' + employee_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Karyawan");
          $('#saveBtn').val("edit-employee");
          $('#saveBtn').html('Update');
          $('#formModal').modal('show');
          $('#employee_id').val(data.id);
          $('#nama').val(data.Nama);
          $('#alamat').val(data.Alamat);
      })
   });
    
    $('#employeeForm').submit(function (e) {
        $('#saveBtn').html('Proses..');
        
        var formData = {
            'employee_id' :  $('#employee_id').val(),
            'nama' : $('#nama').val(),
            'alamat' : $('#alamat').val()
        };
        console.log(formData);
        $.ajax({
          data: formData,
          url: "{{ route('employee.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#employeeForm').trigger("reset");
              $('#formModal').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
          }
        });
        e.preventDefault();
    });
    
    $('body').on('click', '.deleteEmployee', function () {
     
        var employee_id = $(this).data("id");
      
        if(confirm("Apakah Anda ingin menghapus data Karyawan !"))
        {
          $.ajax({
              type: "DELETE",
              url: "{{ route('employee.store') }}"+'/'+employee_id,
              success: function (data) {
                  table.draw();
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        }
        
    });
     
  });
</script>
@endsection