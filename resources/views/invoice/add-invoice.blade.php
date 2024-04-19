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
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                                            <thead>
                                            <tr class="fw-bold fs-6 text-gray-800" >
                                                <th>Product Name</th>
                                                <th>Net Unit Price</th>
                                                <th>Current Stock</th>
                                                <th>Qty</th>
                                                <th>Discount</th>
                                                <th>Tax</th>
                                                <th>Subtotal</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td><button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                                        <i class="ki-duotone ki-trash fs-3">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>
                                                    </button></td>
                                            </tr>
                                            <tr>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td> <input type="text" id="orderTax" class="form-control"></td>
                                                <td><button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                                                        <i class="ki-duotone ki-trash fs-3">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>
                                                    </button></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Form inputs -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="orderTax">Order Tax</label>
                                            <input type="text" id="orderTax" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="discount">Discount</label>
                                            <input type="text" id="discount" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shipping">Shipping</label>
                                            <select class="form-control" id="shipping">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <!-- More options -->
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Totals summary -->
                                <div class="row">
                                    <div class="col-md-4 offset-md-8">
                                        <table class="table">
                                            <tr>
                                                <th>Grand Total:</th>
                                                <td>PKR 0.00</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
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
