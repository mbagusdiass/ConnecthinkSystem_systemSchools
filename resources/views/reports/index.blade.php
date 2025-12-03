@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Repots</h5>
                    <div class="mb-4 d-flex gap-2">
                        <button class="btn btn-outline-primary active filter-btn" data-type="students_by_class">
                            Table Students by Classroms
                        </button>
                        <button class="btn btn-outline-primary filter-btn" data-type="teachers_by_class">
                            Table Teachers by Classroms
                        </button>
                        <button class="btn btn-outline-primary filter-btn" data-type="complete_list">
                            Table Students & Teachers by Classroms
                        </button>
                    </div>
                    <div id="loading" class="text-center d-none py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Fecthing data...</p>
                    </div>
                    <div id="report-container" class="table-responsive">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {

            function loadReport(type) {
                $('#report-container').hide();
                $('#loading').removeClass('d-none');

                $.ajax({
                    url: "{{ route('reports.data') }}",
                    type: "GET",
                    data: { type: type },
                    success: function (response) {
                        $('#loading').addClass('d-none');
                        $('#report-container').html(response.html).fadeIn();
                    },
                    error: function (xhr) {
                        $('#loading').addClass('d-none');
                        alert("Gagal memuat data.");
                        console.log(xhr);
                    }
                });
            }
            loadReport('students_by_class');

            $('.filter-btn').click(function () {
                $('.filter-btn').removeClass('active btn-primary btn-success btn-dark text-white')
                    .addClass('btn-outline-primary btn-outline-success btn-outline-dark');

                $(this).removeClass('btn-outline-primary btn-outline-success btn-outline-dark')
                    .addClass('active text-white');

                if ($(this).data('type') == 'students_by_class') $(this).addClass('btn-primary');
                if ($(this).data('type') == 'teachers_by_class') $(this).addClass('btn-primary');
                if ($(this).data('type') == 'complete_list') $(this).addClass('btn-primary');

                var type = $(this).data('type');
                loadReport(type);
            });
        });
    </script>
@endsection
