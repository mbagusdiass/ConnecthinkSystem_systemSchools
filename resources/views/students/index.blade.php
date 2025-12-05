@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div id="success-alert-container" class="mb-3"></div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-semibold mb-0">Student Management</h5>
                        <button class="btn btn-primary" id="btn-create">Add Student</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">No</th>
                                    <th class="border-bottom-0">NISN</th>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Email</th>
                                    <th class="border-bottom-0">Class</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $s)
                                    <tr id="row_{{ $s->id }}">
                                        <td class="border-bottom-0">{{ $loop->iteration }}</td>
                                        <td class="border-bottom-0">{{ $s->nisn }}</td>
                                        <td class="border-bottom-0">{{ $s->name }}</td>
                                        <td class="border-bottom-0">{{ $s->email }}</td>
                                        <td class="border-bottom-0">{{ $s->classroom->name ?? '-'  }}</td>
                                        <td class="border-bottom-0">
                                            <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $s->id }}">Edit</button>
                                            <button class="btn btn-sm btn-danger delete-btn"
                                                data-id="{{ $s->id }}">Delete</button>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="ajaxForm">
                        @csrf
                        <input type="hidden" id="data_id" name="data_id">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>NISN</label>
                                <input type="number" class="form-control" id="nisn" name="nisn" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Classroom</label>
                                <select class="form-control" id="classroom_id" name="classroom_id" required>
                                    <option value="">-- Select Class --</option>
                                    @foreach($classrooms as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option value="L">Male</option>
                                <option value="P">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <textarea class="form-control" id="address" name="address"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="saveBtn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteModalLabel">
                        <i class="ti ti-alert-triangle me-2"></i> Delete Confirmation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this data? This action cannot be undo.</p>
                    <input type="hidden" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            if (localStorage.getItem('pendingSuccessMessage')) {
                let msg = localStorage.getItem('pendingSuccessMessage');
                showSuccessAlert(msg);
                localStorage.removeItem('pendingSuccessMessage');
            }
            if (localStorage.getItem('pendingErrorMessage')) {
                let msg = localStorage.getItem('pendingErrorMessage');
                showErrorAlert(msg);
                localStorage.removeItem('pendingErrorMessage');
            }
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

            function showSuccessAlert(message) {
                let alertHtml = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
                $('#success-alert-container').html(alertHtml);
                $('html, body').animate({ scrollTop: 0 }, 'fast');
            }
            function showErrorAlert(message) {
                let alertHtml = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle fs-5 me-2"></i> <strong>Error!</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
                $('#alert-container').html(alertHtml);
                $('html, body').animate({ scrollTop: 0 }, 'fast');
            }

            $('#btn-create').click(function () {
                $('#ajaxForm').trigger("reset"); $('#data_id').val('');
                $('#modalTitle').text('Add Student'); $('#saveBtn').text('Save');
                $('#ajaxModal').modal('show');
            });

            $('body').on('click', '.edit-btn', function () {
                var id = $(this).data('id');
                $.get("{{ url('students') }}" + '/' + id + '/edit', function (data) {
                    $('#modalTitle').text('Edit Student'); $('#saveBtn').text('Update');
                    $('#ajaxModal').modal('show');
                    $('#data_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#nisn').val(data.nisn);
                    $('#classroom_id').val(data.classroom_id);
                    $('#gender').val(data.gender);
                    $('#address').val(data.address);
                });
            });

            $('#ajaxForm').submit(function (e) {
                e.preventDefault();
                $('#saveBtn').html('Sending...').prop('disabled', true);
                var id = $('#data_id').val();
                var url = id ? "{{ url('students') }}/" + id : "{{ route('students.store') }}";
                var method = id ? "PUT" : "POST";

                $.ajax({
                    data: $(this).serialize(), url: url, type: method, dataType: 'json',
                    success: function (data) {
                        $('#ajaxForm').trigger("reset"); $('#ajaxModal').modal('hide');
                        localStorage.setItem('pendingSuccessMessage', data.success);
                        location.reload();
                    },
                    error: function (jqXHR) {
                        let msg = "Something went wrong!";
                        if (data.responseJSON && data.responseJSON.errors) {
                            let errors = Object.values(data.responseJSON.errors).flat();
                            msg = errors.join('<br>');
                        } else if (data.responseJSON && data.responseJSON.error) {
                            msg = data.responseJSON.error;
                        } else if (data.status === 419) {
                            msg = "Session expired, please refresh.";
                        }
                        localStorage.setItem('pendingErrorMessage', msg);
                        location.reload();
                    }
                });
            });

            $('body').on('click', '.delete-btn', function () {
                var id = $(this).data('id');
                $('#delete_id').val(id);
                $('#deleteModal').modal('show');
            });
            $('#confirmDeleteBtn').click(function () {
                var id = $('#delete_id').val();
                var $btn = $(this);
                $btn.html('Deleting...').prop('disabled', true);

                $.ajax({
                    type: "DELETE",
                    url: "{{ url('students') }}/" + id,
                    success: function (data) {
                        $('#deleteModal').modal('hide');
                        localStorage.setItem('pendingSuccessMessage', data.success);
                        location.reload();
                    },
                    error: function (data) {
                        let msg = "Something went wrong!";
                        if (data.responseJSON && data.responseJSON.error) {
                            msg = data.responseJSON.error;
                        } else if (data.status === 419) {
                            msg = "Session expired, please refresh.";
                        }
                        localStorage.setItem('pendingErrorMessage', msg);
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
