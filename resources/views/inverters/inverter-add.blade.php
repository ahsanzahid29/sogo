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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Add Product</h1>
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
                        <li class="breadcrumb-item text-muted">Add Product</li>
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
                        <form class="form w-100" method="POST" action="{{ route('inverter-add') }}" enctype="multipart/form-data">
                            @csrf

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                                <div class="form-group row mb-5">
                                    <div class="col-md-4 mb-5">
                                        <label class=" required form-label">Model Number :</label>
                                        <input type="text" name="modal_number" class="form-control mb-2 mb-md-0" placeholder="Model Number" required />
                                        @error('modal_number')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                <div class="col-md-4 mb-5">
                                    <label class="required form-label">Product Image:</label>
                                    <input type="file" name="inverter_image" class="form-control mb-2 mb-md-0" />
                                    @error('inverter_image')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label for="exampleFormControlInput1" class="required form-label">Packaging</label>
                                    <select id="packaging" name="inverter_packaging" class="form-select form-select-solid" aria-label="Select example" required>
                                        <option value="">Select Packaging</option>
                                        <option value="1">Carton</option>
                                        <option value="2">Pieces</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group row mb-5">
                                <div class="col-md-4 mb-5" id="pieces" style="display: none;">
                                    <label class="form-label">Pieces:</label>
                                    <input type="text" name="no_of_pieces" class="form-control mb-2 mb-md-0" placeholder="Number of pieces" />
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Brand:</label>
                                    <input type="text" name="brand" class="form-control mb-2 mb-md-0" placeholder="Enter Inverter Brand" />
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label for="exampleFormControlInput1" class="required form-label">Product Category</label>
                                    <select name="category" class="form-select form-select-solid" aria-label="Select example" required>
                                        <option value="0">Select Category</option>
                                        @foreach($productCategory as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group row mb-5">
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Product Warranty (in Years):</label>
                                    <input type="number" name="product_warranty" class="form-control mb-2 mb-md-0" placeholder="Product Warranty" />
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Service Warranty (in Years):</label>
                                    <input type="number" name="service_warranty" class="form-control mb-2 mb-md-0" placeholder="Service Warranty" />
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Warranty Lag (in Months) :</label>
                                    <input type="number" max="3" name="warranty_lag" class="form-control mb-2 mb-md-0" placeholder="Warranty Lag" />
                                </div>
                            </div>

                            <div class="form-group row mb-5">
                                <div class="col-md-4 mb-5">
                                    <label class="required form-label">Product Catalog:</label>
                                    <input type="file" name="product_catalog" class="form-control mb-2 mb-md-0" />
                                    @error('product_catalog')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="required form-label">Product Manual:</label>
                                    <input type="file" name="product_manual" class="form-control mb-2 mb-md-0" />
                                    @error('product_manual')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Troubleshhot Guide :</label>
                                    <input type="file" name="troubleshoot_guide" class="form-control mb-2 mb-md-0" />
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <div class="col-md-12 mb-5">
                                    <label class="required form-label">Product Description:</label>
                                    <textarea name="inverter_name" class="form-control mb-2 mb-md-0" rows="7" cols="7" placeholder="Product Description" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <div class="col-md-12 mb-5">
                                    <label class="form-label">Technical Notes:</label>
                                    <textarea name="technical_notes" class="form-control mb-2 mb-md-0" rows="7" cols="7" placeholder="Technical Notes"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <div class="col-md-9 mb-5">
                                    <label class="form-label">Spare Part File CSV:</label>
                                    <input type="file" accept=".csv" name="sparepart_file" class="form-control mb-2 mb-md-0" />
                                    @error('sparepart_file')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-5">
                                    <label class="form-label mb-2">Demo File</label>
                                    <a target="_blank" style="color:blue" class="form-control mb-2 mb-md-0" href="{{asset('public/files/csv/sparepart-in-inverter.csv')}}">View Demo</a>

                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-12">

                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ url('/inverters-list') }}" class="btn btn-secondary">Cancel</a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#packaging').change(function() {
            var selectedOption = $(this).val();

            // Show text field if the selected option value is '3'
            if(selectedOption === '1') {
                $('#pieces').show();
            } else {
                $('#pieces').hide();
            }
        });
    });
</script>
@endpush
