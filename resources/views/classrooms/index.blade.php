@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div id="success-alert-container" class="mb-3"></div>
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
                        localStorage.setItem('pendingSuccessMessage', data.success);
                        location.reload();
                    },
                    error: function (data) {
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

            // DELETE
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
                    url: "{{ url('classrooms') }}/" + id,
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
