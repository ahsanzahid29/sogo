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
                            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Edit Product</li>
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
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                        <form class="form w-100" method="POST" action="{{ route('update-inverter') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="recordid" value="{{ $inverter->id }}" />

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                                <div class="form-group row mb-5">
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Model Number :</label>
                                        <input type="text" name="modal_number" class="form-control mb-2 mb-md-0" value="{{$inverter->modal_number}}" placeholder="Model Number" required />
                                    </div>
                                <div class="col-md-4 mb-5">
                                    <label class="required form-label">Product Image:</label>
                                    <input type="file" name="inverter_image" class="form-control mb-2 mb-md-0" />
                                    @if($inverter->inverter_image!=null)
                                    <a target="_blank" href="{{asset('public/files/inverters/'.$inverter->inverter_image)}}">View</a>
                                    @endif
                                    @error('inverter_image')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label for="exampleFormControlInput1" class="required form-label">Packaging</label>
                                    <select name="inverter_packaging" class="form-select form-select-solid" aria-label="Select example" required>
                                        <option value="">Select Packaging</option>
                                        <option value="1" @if($inverter->inverter_packaging==1) selected @endif>Carton</option>
                                        <option value="2" @if($inverter->inverter_packaging==2) selected @endif>Pieces</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group row mb-5">
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Pieces:</label>
                                    <input type="text" name="no_of_pieces" class="form-control mb-2 mb-md-0" value="{{$inverter->no_of_pieces}}" placeholder="Number of pieces" />
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Brand:</label>
                                    <input type="text" name="brand" class="form-control mb-2 mb-md-0" value="{{$inverter->brand}}" placeholder="Enter Inverter Brand" />
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label for="exampleFormControlInput1" class="required form-label">Product Category</label>
                                    <select name="category" class="form-select form-select-solid" aria-label="Select example" required>
                                        <option value="0">Select Category</option>
                                        @foreach($productCategory as $row)
                                            <option value="{{ $row->id }}" @if($inverter->category==$row->id) selected @endif>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group row mb-5">
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Product Warranty (in Years):</label>
                                    <input type="number" name="product_warranty" class="form-control mb-2 mb-md-0" value="{{$inverter->product_warranty}}" placeholder="Product Warranty" />
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Service Warranty (in Years):</label>
                                    <input type="number" name="service_warranty" class="form-control mb-2 mb-md-0" value="{{$inverter->service_warranty}}" placeholder="Service Warranty" />
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Warranty Lag (in Months) :</label>
                                    <input type="number" max="3" name="warranty_lag" class="form-control mb-2 mb-md-0" value="{{$inverter->warranty_lag}}" placeholder="Warranty Lag" />
                                </div>
                            </div>

                            <div class="form-group row mb-5">
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Product Catalog:</label>
                                    <input type="file" name="product_catalog" class="form-control mb-2 mb-md-0" />
                                    @if($inverter->product_catalog!=null)
                                        <a target="_blank" href="{{asset('public/files/invertercatalog/'.$inverter->product_catalog)}}">View</a>
                                    @endif
                                    @error('product_catalog')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Product Manual:</label>
                                    <input type="file" name="product_manual" class="form-control mb-2 mb-md-0" />
                                    @if($inverter->product_manual!=null)
                                        <a target="_blank" href="{{asset('public/files/productmanaual/'.$inverter->product_manual)}}">View</a>
                                        @error('product_manual')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label class="form-label">Troubleshhot Guide :</label>
                                    <input type="file" name="troubleshoot_guide" class="form-control mb-2 mb-md-0" />
                                    @if($inverter->troubleshoot_guide!=null)
                                        <a target="_blank" href="{{asset('public/files/troubleshootguide/'.$inverter->troubleshoot_guide)}}">View</a>
                                    @endif
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-12 mb-5">
                                        <label class="required form-label">Product Description:</label>
                                        <textarea name="inverter_name" class="form-control mb-2 mb-md-0" rows="7" cols="7" placeholder="Product Description" required>{{ $inverter->inverter_name }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-12 mb-5">
                                        <label class="form-label">Technical Notes:</label>
                                        <textarea name="technical_notes" class="form-control mb-2 mb-md-0" rows="7" cols="7" placeholder="Technical Notes">{{ $inverter->technical_notes }}</textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-12">

                                    <button type="submit" class="btn btn-warning">Update</button>
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
                    <!--begin::Card-->

                        <h2 class="mt-4">Spare Parts</h2>

                        <!--end::Card header-->

                            <!--begin::Card body-->
                        <div class="card-body pt-0 mt-3 ">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Factory Code</th>
                                    <th>Dosage</th>
                                    <th>Plugin Location</th>
                                    <th>Action</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                @foreach($inverterSpartsParts as $rowSpm)
                                    <tr>
                                        <td>{{ $rowSpm->factory_code }}</td>
                                        <td>{{ $rowSpm->dosage }}</td>
                                        <td>{{ $rowSpm->plugin }}</td>
                                        <td><a href="{{route('delete-sparepart-from-product',$rowSpm->recordid)}}" class="btn btn-small btn-light-danger"> Delete</a></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
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
        $("#kt_customers_table").DataTable();
    </script>
    <script src="{{asset('public/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('public/assets/js/custom/apps/ecommerce/customers/listing/listing.js')}}"></script>


@endpush
