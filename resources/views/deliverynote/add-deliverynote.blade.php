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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Add Delivery Note</h1>
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
                        <li class="breadcrumb-item text-muted">Add Delivery Note</li>
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
                @error('invalid_csv')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message  }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card body-->
                        <form class="form w-100" method="POST" action="{{ route('deliverynote-save') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body p-12">
                                <div class="form-group row mb-5">
                                    <div class="col-md-6 mb-5">
                                        <label class="required form-label">DO Number:</label>
                                        <input type="text" name="do_number" class="form-control mb-2 mb-md-0" placeholder="DO Number" required />
                                        @error('do_number')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="exampleFormControlInput1" class="required form-label">Dealer</label>
                                        <select id="dealer_user" name="dealer_id" class="form-select form-select-solid" aria-label="Select example" required>
                                            <option value="">Select Dealer</option>
                                            @foreach($dealers as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('dealer_id')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div id="dealer_detail">
                                </div>
                                <div class="row mb-5">
                                    <h2>Dealer Products</h2>
                                    <hr/>
                                    <div class="col-12">
                                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                                            <thead>
                                            <tr class="fw-bold fs-6 text-gray-800" >
                                                <th class="min-w-150px">Product Model</th>
                                                <th>Current Stock</th>
                                                <th>Qty</th>
                                                <th>Upload CSV</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="inputRow">
                                            <tr>
                                                <td>
                                                    <select name="sparepart[]" class="form-control part-dropdown" required>
                                                        <option value="">Select Modal</option>
                                                        @foreach($inverters as $rowp)
                                                            <option value="{{$rowp->id}}">{{ $rowp->modal_number }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="text" placeholder="Current Stock" class="form-control current-stock " readonly></td>
                                                <td><input type="number" name="qty[]" placeholder="Quantity" class="form-control qty" required></td>
                                                <td><input type="file" name="csv_files[]" class="form-control" required></td>
                                                <td><button id="addItemBtn" class="btn btn-light-success">Add</button></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group row mb-5">
                                    <div class="col-md-12 mb-5">
                                        <label class="required form-label">Delivery Notes:</label>
                                        <textarea name="notes" class="form-control mb-2 mb-md-0" placeholder="Delivery Notes" rows="7" cols="7" required></textarea>
                                        @error('notes')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-10">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ url('/deliverynote-list') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card header-->

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
    <script>
        $(document).ready(function() {
            var parts = @json($inverters);
            $('#dealer_user').change(function() {
                var selectedOption = $(this).val();
                if(selectedOption!=0){
                    $.ajax({
                        url: "{{ url('/dealeruser-detail') }}/" + selectedOption,
                        context: document.body,
                        error: function (data, transport) {
                            alert("Sorry, the operation is failed.");
                        },
                        success: function (data) {
                            $('#dealer_detail').html(data);
                        }
                    });
                }
                else{
                    $('#dealer_detail').empty();

                }

            });
            $('#addItemBtn').click(function(e) {
                e.preventDefault();  // This stops the default form submission action
                var selectHtml = '<select name="sparepart[]" class="form-control part-dropdown" required>';
                selectHtml += '<option value="">Select Modal</option>';
                parts.forEach(function(option) {
                    selectHtml += '<option value="' + option.id + '">' + option.modal_number + '</option>';
                });
                selectHtml += '</select>';
                var newRow = '<tr>' +
                    '<td>' + selectHtml + '</td>' +
                    '<td><input type="text" placeholder="Current Stock" class="form-control current-stock " readonly></td>' +
                    '<td><input type="number" name="qty[]" placeholder="Quantity" class="form-control qty" required></td>' +
                    ' <td><input type="file" name="csv_files[]" class="form-control" required></td>'+
                    '<td><button class="btn btn-light-danger btn-xs removeBtn">Remove</button></td>' +
                    '</tr>';
                $('#inputRow').append(newRow);

            });

            // Event delegation to handle click on dynamically created remove buttons
            $('#inputRow').on('click', '.removeBtn', function() {
                $(this).closest('tr').empty(); // This empties the content of the td that contains the clicked button


        });

            $('#inputRow').on('change', '.part-dropdown', function() {
                var selectedModalId = $(this).val();
                var $currentstockField = $(this).closest('tr').find('.current-stock');

                if (selectedModalId) {
                    $.ajax({
                        url: "{{ url('/product-detail-deliverynote') }}",
                        type: 'GET',
                        data: { partId: selectedModalId },
                        success: function(response) {
                            $currentstockField.val(response.currentStock);
                        },
                        error: function(xhr) {
                            console.error('Error fetching tax data:', xhr.responseText);
                        }
                    });
                } else {
                    $currentstockField.val(''); // Clear tax output if no part is selected
                }
            });
    });

    </script>
@endpush
