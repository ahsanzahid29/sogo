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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Add Invoice</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('/dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Add Invoice</li>
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
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-lg-row">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid mb-12 mb-lg-0 me-lg-7 me-xl-10">
                        <!--begin::Card-->
                        <div class="card">

                            <!--begin::Card body-->
                            <form class="form w-100" method="POST" action="{{ url('/invoice-save') }}">
                                @csrf
                            <div class="card-body p-12">
                                <div class="form-group row mb-5">
                                    <div class="col-md-6 mb-5">
                                        <label for="exampleFormControlInput1" class="required form-label">FOC</label>
                                        <select id="foc" name="foc" class="form-select form-select-solid" aria-label="Select example" required>
                                            <option value="">Select FOC</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                        @error('foc')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="exampleFormControlInput1" class="required form-label">Service Center</label>
                                        <select id="service_user" name="service_user" class="form-select form-select-solid" aria-label="Select example" required>
                                            <option value="">Select User</option>
                                            @foreach($serviceCenterUser as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('service_user')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div id="sc_detail">

                                </div>
{{--                                <div class="form-group row mb-5">--}}
{{--                                    <div class="col-md-6 mb-5">--}}
{{--                                <button id="addItemBtn" class="btn btn-light-success">Add</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="row mb-5">
                                    <div class="col-12">
                                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                                            <thead>
                                            <tr class="fw-bold fs-6 text-gray-800" >
                                                <th>Factory Code</th>
                                                <th>Net Unit Price</th>
                                                <th>Current Stock</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="inputRow">
                                            <tr>
                                                <td>
                                                    <select name="sparepart[]" class="form-control myselect part-dropdown" required>
                                                        <option value="">Select Spare Part</option>
                                                        @foreach($spareParts as $rowspp)
                                                            <option value="{{$rowspp->id}}">{{ $rowspp->factory_code }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="text" name="sale_price[]" placeholder="Net unit price" class="form-control unit-price" readonly></td>
                                                <td><input type="text" placeholder="Current Stock" class="form-control current-stock " readonly></td>
                                                <td><input type="number" name="qty[]" placeholder="Quantity" class="form-control qty" required></td>
                                                <td><input type="text" name="item_total[]" placeholder="Sub Total" class="form-control total-cost"></td>
                                                <td><button id="addItemBtn" class="btn btn-light-success">Add</button></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Form inputs -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="discount">Invoice Discount</label>
                                            <input name="discount" placeholder="Invoice Discount" type="text" id="discount" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Totals summary -->
                                <div class="row">
                                    <div class="col-md-4 offset-md-8">
                                        <table class="table">
                                            <tr>
                                                <th>Grand Total:</th>
                                                <td id="grandTotal">PKR 0.00</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <input type="hidden" name="total" id="invoice_total" />
                                <!-- Submit button -->
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{ url('/invoice-list') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Layout-->
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.myselect').select2();
            var parts = @json($spareParts);
            $('#service_user').change(function() {
                var selectedOption = $(this).val();
                if(selectedOption!=0){
                    $.ajax({
                        url: "{{ url('/serviceuser-detail') }}/" + selectedOption,
                        context: document.body,
                        error: function (data, transport) {
                            alert("Sorry, the operation is failed.");
                        },
                        success: function (data) {
                            $('#sc_detail').html(data);
                        }
                    });
                }
                else{
                    $('#sc_detail').empty();

                }

            });
            $('#addItemBtn').click(function(e) {
                e.preventDefault();  // This stops the default form submission action
                var selectHtml = '<select name="sparepart[]" class="form-control part-dropdown" required>';
                selectHtml += '<option value="">Select Spare Part</option>';
                parts.forEach(function(option) {
                    selectHtml += '<option value="' + option.id + '">' + option.factory_code + '</option>';
                });
                selectHtml += '</select>';
                var newRow = '<tr>' +
                    '<td>' + selectHtml + '</td>' +
                    '<td><input type="text" name="sale_price[]" placeholder="Net unit price" class="form-control unit-price" readonly></td>' +
                    '<td><input type="text" placeholder="Current Stock" class="form-control current-stock " readonly></td>' +
                    '<td><input type="number" name="qty[]" placeholder="Quantity" class="form-control qty" required></td>' +
                    '<td><input type="text" name="item_total[]" placeholder="Sub Total" class="form-control total-cost"></td>' +
                    '<td><button class="btn btn-light-danger btn-xs removeBtn">Remove</button></td>' +
                    '</tr>';
                $('#inputRow').append(newRow);
                updateGrandTotal();
            });

            // Event delegation to handle click on dynamically created remove buttons
            $('#inputRow').on('click', '.removeBtn', function() {
                $(this).closest('tr').empty(); // This empties the content of the td that contains the clicked button
                updateGrandTotal();
            });

            $('#inputRow').on('change', '.part-dropdown', function() {
                var selectedPartId = $(this).val();
                var $unitPriceField = $(this).closest('tr').find('.unit-price');
                var $currentstockField = $(this).closest('tr').find('.current-stock');

                if (selectedPartId) {
                    $.ajax({
                        url: "{{ url('/part-detail') }}",
                        type: 'GET',
                        data: { partId: selectedPartId },
                        success: function(response) {
                            $unitPriceField.val(response.netPrice);
                            $currentstockField.val(response.currentStock);
                        },
                        error: function(xhr) {
                            console.error('Error fetching tax data:', xhr.responseText);
                        }
                    });
                } else {
                    $unitPriceField.val(''); // Clear tax output if no part is selected
                }
            });
            $('#inputRow').on('input', '.qty', function() {
                var $row = $(this).closest('tr');
                var focVal  = $('#foc').val();
                
                if(focVal==1){
                    var taxRate = 0;
                    var discount = 0;
                    var subtotal = 0;
                    var totalCost = 0;  // Calculate total cost including tax
                    var costwithDiscount = 0;
                }
                else{
                    var quantity = parseFloat($row.find('.qty').val()) || 0;
                    var price = parseFloat($row.find('.unit-price').val()) || 0;
                    var subtotal = quantity * price;
                    var totalCost = subtotal ;  // Calculate total cost including tax
                  
                }
                $row.find('.total-cost').val(totalCost.toFixed(2));  // Display total cost, formatted to 2 decimal places
                updateGrandTotal();
            });

            // Event handler for discount changes
            $('#discount').on('input', function() {
                updateGrandTotal();
            });

        });
        function updateGrandTotal() {
            var total = 0;
            $('.total-cost').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            var discount = parseFloat($('#discount').val()) || 0;
            var grandTotal = total - discount;
            $('#grandTotal').text('PKR ' + grandTotal.toFixed(2));
            $('#invoice_total').val(grandTotal.toFixed(2)); // Display formatted grand total

        }
    </script>
@endpush
