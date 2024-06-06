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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Spare Part Request</h1>
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
                        <li class="breadcrumb-item text-muted">Spare Part Request</li>
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
                @if(session('status'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
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
                                <div class="col-md-6 mb-5">
                                    <label class="form-label">Request Number:</label>
                                    <input type="text" class="form-control mb-2 mb-md-0" disabled value="{{ $randomString }}" placeholder="Request Number" />
                                </div>
                                <div class="col-md-6 mb-5">
                                    <label class="form-label">Request Date:</label>
                                    <input type="text" class="form-control mb-2 mb-md-0" disabled value="{{ date('d/m/Y') }}" placeholder="Request Date" />
                                </div>
                            </div>
                            <div class="form-group row mb-5" >
                                <div class="col-md-6 mb-5">
                                    <button id="addSpartBtn" class="btn btn-light-success">Add</button>
                                </div>
                            </div>
                            <form class="form w-100" method="POST" action="{{ url('/spare-part-request-items') }}">
                                @csrf
                                <input type="hidden" name="request_number" value="{{ $randomString }}" />
                                <div class="form-group row mb-5">
                                    <h2 class="mb-5">Request Spare Parts</h2>
                                    <hr/>
                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                        <thead>
                                        <tr class="fw-bold fs-6 text-gray-800" >
                                            <th>Spare Part Code</th>
                                            <th>Quantity Required</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="inputRow">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-dark">Request Items</button>
                                        <a href="{{ url('/sparepart-request-list') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>
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
    <script type="text/javascript">
        $(document).ready(function() {
            var parts = @json($allSpareParts);

            $('#addSpartBtn').click(function(e) {
                e.preventDefault();  // This stops the default form submission action
                var selectHtml = '<select name="sparepart[]" class="form-control part-dropdown" required>';
                selectHtml += '<option value="">Select Spare Part</option>';
                parts.forEach(function(option) {
                    selectHtml += '<option value="' + option.id + '">' + option.factory_code + '</option>';
                });
                selectHtml += '</select>';
                var newRow = '<tr>' +
                    '<td>' + selectHtml + '</td>' +
                    '<td><input type="text" placeholder="Quantity Required" name="needed_stock[]" class="form-control need-stock" required></td>' +
                    '<td><button class="btn btn-light-danger btn-xs removeBtn">Remove</button></td>' +
                    '</tr>';
                $('#inputRow').append(newRow);
                // updateGrandTotal();
            });
            // Event delegation to handle click on dynamically created remove buttons
            $('#inputRow').on('click', '.removeBtn', function() {
                $(this).closest('tr').empty(); // This empties the content of the td that contains the clicked button
            });
        });
    </script>
@endpush
