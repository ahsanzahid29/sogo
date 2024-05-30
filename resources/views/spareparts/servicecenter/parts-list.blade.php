@extends('layouts.dashboard')
@push('scripts_top')
    <link href="{{asset('public/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Spare Part Listing</h1>
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
                            <li class="breadcrumb-item text-muted">Spare Part List</li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->

                </div>
                <!--end::Toolbar container-->
            </div>
            <!-- end:Toolbar -->
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
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
                                <!--begin::Search-->
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Spare Part" />
                                </div>
                                <!--end::Search-->
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">

                                <!--begin::Group actions-->
                                <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                                    <div class="fw-bold me-5">
                                        <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div>
                                    <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
                                </div>
                                <!--end::Group actions-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        @php
                            use Illuminate\Support\Str;
                        @endphp
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                                <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>S. No</th>
                                    <th>Part Description</th>
                                    <th class="min-w-125px">Factory Code</th>
                                    <th class="min-w-125px">Part Type</th>
                                    <th class="min-w-125px">Sale Price</th>
                                    <th class="min-w-125px">Pieces</th>
                                    <th class="text-end min-w-70px">Action</th>
                                </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                @foreach($sparePartsForSc as $row)
                                <tr>
                                    <td>{{ $count ++ }}</td>
                                    <td><a href="javascript:void(0);" title="{{ $row->partname }}" style="text-decoration: none;color:#99a1b7">{{ Str::limit($row->partname, 20, '...') }}</a></td>
                                    <td>{{ $row->factorycode }}</td>
                                    <td>{{ $row->category }}</td>
                                    <td>{{ $row->saleprice }}</td>
                                    <td>{{ $row->pieces }}</td>
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
                <!--end::Content container-->
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
    </div>

@endsection

@push('scripts_bottom')
    <script type="text/javascript">
        $("#kt_customers_table").DataTable();
    </script>
    <script src="{{asset('public/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('public/assets/js/custom/apps/ecommerce/customers/listing/listing.js')}}"></script>


@endpush
