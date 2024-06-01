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
                        <li class="breadcrumb-item text-muted">View Spare Part Request</li>
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
                                <div class="col-md-6 mb-5">
                                    <label class="form-label">Request Number:</label>
                                    <input type="text" class="form-control mb-2 mb-md-0" disabled value="{{ $detail->ticket_number }}" placeholder="Request Number" />
                                </div>
                                <div class="col-md-6 mb-5">
                                    <label class="form-label">Request Date:</label>
                                    <input type="text" class="form-control mb-2 mb-md-0" disabled value="{{ date('d/m/Y',strtotime($detail->created_at)) }}" placeholder="Request Date" />
                                </div>
                            </div>
                            @if(count($neededSpareParts)>0)
                                <div class="form-group row mb-5">
                                    <h2 class="mb-5">Requested Spare Parts</h2>
                                    <hr/>
                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                        <thead>
                                        <tr class="fw-bold fs-6 text-gray-800" >
                                            <th>Spare Part Code</th>
                                            <th>Quantity Needed</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($neededSpareParts)>0)
                                            @foreach($neededSpareParts as $rownsp)
                                                <tr>
                                                    <td> <input type="text" disabled class="form-control" placeholder="Part Name" value="{{ $rownsp->sp_name }}"></td>
                                                    <td> <input type="text" disabled class="form-control" placeholder="Part Name" value="{{ $rownsp->need_qty }}"></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <a href="{{ url('/sparepart-request-list') }}" class="btn btn-secondary">Cancel</a>
                                </div>
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
