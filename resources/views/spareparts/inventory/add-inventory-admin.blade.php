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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Add Spare Part Receiving Note</h1>
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
                        <li class="breadcrumb-item text-muted">Add Spare Part Receiving Note</li>
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
                        <form class="form w-100" method="POST" action="{{ route('save-sparepart-inventory') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="serial_no" value="{{ $inentory_serial_no }}" />

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="form-group row mb-5">
                                    <div class="col-md-6 mb-5">
                                        <label class=" required form-label">Principle Invoice No:</label>
                                        <input type="text" class="form-control mb-2 mb-md-0" name="principle_invoice_no" placeholder="Principle Invoice No" required />
                                        @error('principle_invoice_no')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class=" required form-label">Principle Invoice Date:</label>
                                        <input type="date" class="form-control mb-2 mb-md-0" name="principle_invoice_date" required />
                                        @error('principle_invoice_date')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-6 mb-5">
                                        <label class=" required form-label">GRN:</label>
                                        <input type="text" value="{{ $randomString }}" class="form-control mb-2 mb-md-0" name="grn" placeholder="GRN" readonly />
                                        @error('grn')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class=" required form-label">Receiving Date:</label>
                                        <input type="text" value="{{ date('d/m/Y') }}" class="form-control mb-2 mb-md-0" name="receiving_invoice_date" placeholder="GRN" disabled />
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-12 mb-5">
                                        <label class="form-label">Remarks:</label>
                                        <textarea class="form-control mb-2 mb-md-0" name="remarks" rows="7" cols="7"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-12 mb-5 mt-7">
                                        <button id="add-button" type="button" class="btn btn-success add-form">Add Spare Parts</button>
                                    </div>
                                </div>
                                <div id="form-container">
                                    <div class="form-group row mb-5 repeatable-section">
                                        <div class="col-md-4 mb-5 mt-2">
                                            <label for="exampleFormControlInput1" class=" required form-label">Spare Parts</label>
                                            <select name="parts[]" class="form-select myselect form-select-solid spare-part-dropdown" required>
                                                <option value="" selected>Select Spare Part</option>
                                                @foreach($spareParts as $row)
                                                    <option value="{{$row->id}}">{{ $row->factory_code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-5">
                                            <label class=" required form-label">Description :</label>
                                            <textarea id="description" disabled class="form-control mb-2 mb-md-0 description-box"></textarea>
                                        </div>
                                        <div class="col-md-4 mb-5">
                                            <label class=" required form-label">Current Stock :</label>
                                            <input type="text" id="current_stock" disabled placeholder="Current Stock" class="form-control mb-2 mb-md-0 current-stock-box" />
                                        </div>
                                        <div class="col-md-4 mb-5">
                                            <label class=" required form-label">Required Quantity :</label>
                                            <input type="number" name="qty[]" placeholder="Required Quantity" class="form-control mb-2 mb-md-0" />
                                        </div>
                                        <div class="col-md-4 mb-5">
                                            <label class=" form-label">Purchase Price :</label>
                                            <input type="text" disabled placeholder="Purchase Price" class="form-control mb-2 mb-md-0" />
                                        </div>
                                        <div class="col-md-4 mb-5">
                                            <label class="form-label">Previous Purchase Price :</label>
                                            <input type="text" id="previous_purchase_price" disabled placeholder="Previous Purchase Price" class="form-control mb-2 mb-md-0 previous-purchase-price-box" />
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <a href="{{ route('list-inverter-inventory') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </form>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.myselect').select2();
            // Function to handle the AJAX call and update text boxes
            function handleDropdownChange(dropdown) {
                var selectedValue = $(dropdown).val();
                var row = $(dropdown).closest('.repeatable-section');
                var descriptionBox = row.find('.description-box');
                var currentStockBox = row.find('.current-stock-box');
                var previousPurchasePriceBox = row.find('.previous-purchase-price-box');

                $.ajax({
                    url: "{{ url('/spare-part-detail-for-inventory') }}",
                    method: 'GET',
                    data: { id: selectedValue },
                    success: function(response) {
                        // Update the text boxes with the response data
                        descriptionBox.val(response.description);
                        currentStockBox.val(response.current_stock);
                        previousPurchasePriceBox.val(response.previous_purchase_price);
                    },
                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                    }
                });
            }

            // Attach change event handler to the existing dropdown
            $(document).on('change', '.spare-part-dropdown', function() {
                handleDropdownChange(this);
            });

            // Function to add new rows
            $('#add-button').on('click', function() {
                var originalSection = $('.repeatable-section').first();
                var clone = originalSection.clone(true);

                // Clear input values in the cloned section
                clone.find('input').val('');
                clone.find('textarea').val('');
                clone.find('select').prop('selectedIndex', 0);

                // Add remove button to cloned section
                var removeButton = $('<button type="button" class="btn btn-danger remove-button">Remove</button>');
                removeButton.on('click', function() {
                    clone.prev('hr').remove(); // Remove the preceding hr
                    clone.remove();
                });

                var buttonContainer = $('<div class="col-md-4 mb-5"></div>').append(removeButton);
                clone.append(buttonContainer);

                // Create an hr element
                var hr = $('<hr>');

                // Append the hr element and the cloned section to the form container
                $('#form-container').append(hr).append(clone);
            });
        });
    </script>

@endpush
