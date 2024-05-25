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
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">

                        </div>
                        <!--end::Card title-->

                        <!--begin::Card body-->
                        <form class="form w-100" method="POST" action="{{ route('deliverynote-save') }}">
                            @csrf
                        <div class="card-body pt-0">
                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="required form-label">Select Dealer</label>
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
                            <div id="dealer_detail">
                            </div>
                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="required form-label">Product Model</label>
                                <select id="product_model" name="inverter_id" class="form-select form-select-solid" aria-label="Select example" required>
                                    <option value="">Select Product</option>
                                    @foreach($inverters as $row)
                                        <option value="{{ $row->id }}">{{ $row->modal_number }}</option>
                                    @endforeach
                                </select>
                                @error('inverter_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="inverter_detail">
                            </div>
                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="required form-label">Quantity</label>
                                <input type="type" class="form-control form-control-solid" placeholder="Quantity" name="quantity"/>
                                @error('quantity')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="form-label">Delivery Notes</label>
                                <textarea class="form-control form-control-solid" placeholder="Notes.." name="notes"></textarea>
                                @error('notes')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
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
                    <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">SOGO</a>
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
            $('#product_model').change(function() {
                var selectedOption = $(this).val();
                if(selectedOption!=0){
                    $.ajax({
                        url: "{{ url('/product-detail-deliverynote') }}/" + selectedOption,
                        context: document.body,
                        error: function (data, transport) {
                            alert("Sorry, the operation is failed.");
                        },
                        success: function (data) {
                            $('#inverter_detail').html(data);
                        }
                    });
                }
                else{
                    $('#inverter_detail').empty();

                }

            });
    });

    </script>
@endpush
