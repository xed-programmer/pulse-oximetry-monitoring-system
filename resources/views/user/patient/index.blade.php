@extends('layouts.admin')

@push('links')
<x-data-table-links />
@endpush

@section('header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Patient</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Patient</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">              
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Patients</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">
                    Add Patient
                </button>
                <table id="patientTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>PATIENT NUMBER</th>
                            <th>NAME</th>
                            <th>CONTROL</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <h4 class="modal-title">Add Patient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('user.patient.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Patient Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Patient Name">
                    </div>               
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-light">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content bg-warning">
            <div class="modal-header">
                <h4 class="modal-title">Update Patient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('user.patient.update') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="text" class="form-control" id="patient_id" name="id" hidden>
                    <div class="form-group">
                        <label for="edit_name">Patient Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name">
                    </div>           
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-dark">Save</button>
                </div>
            </form>
        </div>        
    </div>    
</div>
@endsection

@push('scripts')
<script>
    $(function(){
        $('body').on('click', '#btn_edit_patient', function(){
            var patient_id = $(this).data('patient-id')
            $('#patient_id').val("")
            $('#edit_name').val("")
            $.when($.ajax({
                method:"GET",
                url: "{{ route('user.patient.edit') }}",
                data:{
                    id: patient_id
                }
            }))
            .then((data,textStatus,jqXHR)=>{
                $('#patient_id').val(data['id'])
                $('#edit_name').val(data['name'])                
            })
        })
    })
</script>
<x-data-table-scripts/>
<script>
    $(function () {
        $("#patientTable").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,order:[],
          ajax:{
            method:"POST",
            url: "{{ route('patient.data') }}",
            data:{
              api_key:"tPmAT5Ab3j7F9"
            }
          },
          columns:[
            {'data': 1},
            {'data': 2},
            {
              'data': 0,
              'render':function(data,type,row,meta){
                return `<form action="{{ route("user.patient.delete") }}" method="POST" onsubmit="return confirm('Do you want to delete this patient?');"> @csrf @method("DELETE") <input type="hidden" name="id" value="${data}"> <a class="btn bg-success" href="{{ route('user.patient.show') }}?id=${data}">View</a> <input type="button" id="btn_edit_patient" data-toggle="modal" data-target="#modal-edit" data-patient-id="${data}" class="btn bg-warning" value="Edit"> <input type="submit" class="btn bg-danger" value="Delete"> </form>`
              }
            },
          ]
        });

        setInterval(() => {            
            $("#patientTable").DataTable().ajax.reload();
        }, 3000);
      });    
</script>
@endpush