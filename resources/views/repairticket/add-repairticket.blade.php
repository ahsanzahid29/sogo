@extends('layouts.dashboard')
@section('content')
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Repair Ticket</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Create Repair Ticket</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->

            </div>
            <!--end::Toolbar container-->
        </div>
        <!-- end:Toolbar -->
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card body-->

                        <div class="card-body pt-0">
                            <div class="form-group row mb-5">
                                <div class="col-md-10 mb-5">
                                    <label class="required form-label">Search via Serial Number:</label>
                                    <input type="text" id="serial_number" class="form-control mb-2 mb-md-0" placeholder="Search via Serial Number" required />
                                </div>
                                <div class="col-md-2 mb-5">
                                    <label class="form-label"></label>
                                    <button id="searchsn" class="btn btn-success mt-8">Search</button>
                                </div>
                            </div>
                            <div id="repair_history">
                            </div>


                        </div>
                        <!--end::Card body-->


                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->


            </div>
            <!--end::Content wrapper-->

        </div>
        <!--end::Content wrapper-->
        <!--begin::Footer-->
        <div id="kt_app_footer" class="app-footer">
            <!--begin::Footer container-->
            <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                <!--begin::Copyright-->
                <div class="text-gray-900 order-2 order-md-1">
                    <span class="text-muted fw-semibold me-1"><?php echo date('Y') ?>&copy;</span>
                    <a href="{{  route('dashboard') }}" class="text-gray-800 text-hover-primary">SOGO</a>
                </div>
                <!--end::Copyright-->
            </div>
            <!--end::Footer container-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end:::Main-->
@endsection
@push('scripts_bottom')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#searchsn').click(function() {
            var serial_numberValue = $('#serial_number').val();
            if(serial_numberValue==''){
                alert('Please enter serial number');
                return;
            }
            $.ajax({
                url: "{{ url('/searchserialnoforrepair') }}" ,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),  // Include CSRF token
                    value: serial_numberValue  // Data being sent to the server
                },
                success: function(response) {
                    $('#repair_history').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);     // Log any error
                }
            });
        });

        $('#addSpartBtn').click(function(e) {
            e.preventDefault();  // This stops the default form submission action

            var newRow = '<tr>' +

                '<td><input type="text" name="sale_price[]" placeholder="Net unit price" class="form-control unit-price" readonly></td>' +
                '<td><input type="text" placeholder="Current Stock" class="form-control current-stock " readonly></td>' +
                '<td><button class="btn btn-light-danger btn-xs removeBtn">Remove</button></td>' +
                '</tr>';
            $('#inputRow').append(newRow);
           // updateGrandTotal();
        });

    });

 </script>
@endpush
