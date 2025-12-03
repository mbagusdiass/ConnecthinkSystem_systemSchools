@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card w-100">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-semibold mb-0">Classroom Management</h5>
                        <button class="btn btn-primary" id="btn-create">Add New Class</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Class Name</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Action</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach($classrooms as $c)
                                    <tr id="row_{{ $c->id }}">
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $c->name }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $c->id }}">Edit</button>
                                            <button class="btn btn-sm btn-danger delete-btn"
                                                data-id="{{ $c->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ajaxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="ajaxForm">
                        @csrf
                        <input type="hidden" id="data_id" name="data_id">
                        <div class="mb-3">
                            <label>Class Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="saveBtn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

            // CREATE
            $('#btn-create').click(function () {
                $('#ajaxForm')[0].reset();
                $('#data_id').val('');
                $('#modalTitle').text('Add Class');
                $('#saveBtn').text('Save');
                $('#ajaxModal').modal('show');
            });

            // EDIT
            $('body').on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                $.get("{{ url('classrooms') }}" + '/' + id + '/edit', function (data) {
                    $('#modalTitle').text('Edit Class');
                    $('#saveBtn').text('Update');
                    $('#ajaxModal').modal('show');
                    $('#data_id').val(data.id);
                    $('#name').val(data.name);
                });
            });

            // STORE / UPDATE
            $('#ajaxForm').submit(function (e) {
                e.preventDefault();
                $('#saveBtn').html('Sending...').prop('disabled', true);
                var id = $('#data_id').val();
                var url = id ? "{{ url('classrooms') }}/" + id : "{{ route('classrooms.store') }}";
                var method = id ? "PUT" : "POST";

                $.ajax({
                    data: $(this).serialize(), url: url, type: method, dataType: 'json',
                    success: function (data) {
                        $('#ajaxForm')[0].reset();
                        $('#ajaxModal').modal('hide');
                        alert(data.success);
                        location.reload();
                    },
                    error: function (data) {
                        $('#saveBtn').html('Save').prop('disabled', false);
                        alert('Error: ' + JSON.stringify(data.responseJSON.errors));
                    }
                });
            });

            // DELETE
            $('body').on('click', '.delete-btn', function () {
                var id = $(this).data('id');
                if (confirm("Delete this class?")) {
                    $.ajax({
                        type: "DELETE", url: "{{ url('classrooms') }}/" + id,
                        success: function (data) { $('#row_' + id).remove(); alert(data.success); },
                        error: function (data) { alert(data.responseJSON.error); }
                    });
                }
            });
        });
    </script>
@endsection
