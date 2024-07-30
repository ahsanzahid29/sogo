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
                        <li class="breadcrumb-item text-muted">Spare Part Receiving Note Detail</li>
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
                        <form class="form w-100" method="POST" action="{{ route('update-sparepart-inventory') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="record_id" value="{{ $detail->id }}" />
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="form-group row mb-5">
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Principle Invoice No:</label>
                                        <input type="text" class="form-control mb-2 mb-md-0"  placeholder="Principle Invoice No" value="{{ $detail->principle_invoice_no }}" disabled />
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Principle Invoice Date:</label>
                                        <input type="text" class="form-control mb-2 mb-md-0"  value="{{ date('d/m/Y',strtotime($detail->principle_invoice_date)) }}" disabled />
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">GRN:</label>
                                        <input type="text" class="form-control mb-2 mb-md-0"  placeholder="GRN" value="{{ $detail->grn }}" disabled />
                                        @error('grn')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Receiving Date:</label>
                                        <input type="text" value="{{ date('d/m/Y',strtotime($detail->receiving_invoice_date)) }}" class="form-control mb-2 mb-md-0"  disabled />
                                    </div>
                                </div>


                                <div id="form-container">
                                    @foreach($sp_inventory as $row)
                                        <input type="hidden" name="inventory_ids[]" value="{{ $row->inv_id }}">
                                    <div class="form-group row mb-5">
                                        <div class="col-md-4 mb-5 mt-2">
                                            <label for="exampleFormControlInput1" class="form-label">Spare Part Factory Code</label>
                                            <input type="text"  disabled value="{{ $row->factory_code }}"  class="form-control mb-2 mb-md-0" />
                                        </div>
                                        <div class="col-md-4 mb-5">
                                            <label class="form-label">Description :</label>
                                            <textarea  disabled class="form-control mb-2 mb-md-0">{{ $row->spname }}</textarea>
                                        </div>
                                        <div class="col-md-4 mb-5">
                                            <label class="form-label">Required Quantity :</label>
                                            <input type="number" value="{{ $row->qty }}" placeholder="Required Quantity" class="form-control mb-2 mb-md-0" disabled />
                                        </div>
                                        @if($detail->status=='pending' && $role==1)
                                            <div class="col-md-4 mb-5">
                                                <label class="required form-label">Purchase Price :</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">Rs.</span>
                                                    <input type="number" name="purchase_price[]" value="{{$row->pprice}}" placeholder="Purchase Price" class="form-control mb-2 mb-md-0" required />
                                                </div>
                                            </div>
{{--                                        <div class="col-md-4 mb-5">--}}
{{--                                            <label class="required form-label">Purchase Price :</label>--}}
{{--                                            <input type="number" name="purchase_price[]" value="{{$row->pprice}}" placeholder="Purchase Price" class="form-control mb-2 mb-md-0" required />--}}
{{--                                        </div>--}}
                                        @else
                                            <div class="col-md-4 mb-5">
                                                <label class=" form-label">Purchase Price :</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">Rs.</span>
                                                    <input type="text" value="{{$row->pprice}}" placeholder="Purchase Price" class="form-control mb-2 mb-md-0" disabled />
                                                </div>
                                            </div>
{{--                                            <div class="col-md-4 mb-5">--}}
{{--                                                <label class="form-label">Purchase Price :</label>--}}
{{--                                                <input type="text" value="{{$row->pprice}}" placeholder="Purchase Price" class="form-control mb-2 mb-md-0" disabled />--}}
{{--                                            </div>--}}
                                        @endif
                                    </div>
                                        <hr/>
                                    @endforeach
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-12 mb-5">
                                        <label class="form-label">Remarks:</label>
                                        <textarea class="form-control mb-2 mb-md-0" disabled rows="7" cols="7">{{ $detail->remarks }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        @if($detail->status=='pending' && $role==1)
                                        <button type="submit" class="btn btn-warning">Update</button>
                                        @endif
                                        <a href="{{ route('list-sparepart-inventory') }}" class="btn btn-secondary">Cancel</a>
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
