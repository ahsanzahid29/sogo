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
                        <li class="breadcrumb-item text-muted">View Invoice</li>
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
                            <form class="form w-100" method="POST" action="{{ route('deliver-invoice') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="recordid" value="{{$invoiceId}}" />
                            <div class="card-body p-12">
                                <div class="form-group row mb-5">
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">FOC:</label>
                                        <input type="text" disabled class="form-control mb-2 mb-md-0" value="{{ ucwords(strtolower($invoiceDetail->foc)) }}" placeholder="FOC" />
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Service Center Contact Name:</label>
                                        <input type="text" disabled class="form-control mb-2 mb-md-0" value="{{$invoiceDetail->name}}" placeholder="Name" />
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Service Center Contact Number:</label>
                                        <input type="text" disabled class="form-control mb-2 mb-md-0" value="{{$invoiceDetail->phone}}" placeholder="Phone" />
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Service Center Contact Address:</label>
                                        <textarea disabled class="form-control mb-2 mb-md-0">{{ $invoiceDetail->shipping_address }}</textarea>
                                    </div>
                                </div>
                                <h2>Invoice Items</h2>
                                <hr/>

                                <div class="row mb-5">
                                    <div class="col-12">
                                        <table class="table table-row-dashed table-row-gray-300 gy-7">
                                            <thead>
                                            <tr class="fw-bold fs-6 text-gray-800" >
                                                <th>Factory Code</th>
                                                <th>Net Unit Price</th>
                                                <th>Qty</th>
                                                <th>Tax (%)</th>
                                                <th>Discount</th>
                                                <th>Subtotal</th>
                                            </tr>
                                            </thead>
                                            <tbody id="inputRow">
                                            @foreach($invoiceItems as $row)
                                            <tr>
                                                <td> <input type="text" value="{{$row->sparepart}}" disabled  class="form-control"></td>
                                                <td> <input type="text" value="{{$row->itemunitprice}}" disabled  class="form-control"></td>
                                                <td> <input type="text" value="{{$row->itemqty}}" disabled  class="form-control"></td>
                                                <td> <input type="text" value="{{$row->itemtax}}" disabled  class="form-control"></td>
                                                <td> <input type="text" value="{{$row->itemdiscount}}" disabled  class="form-control"></td>
                                                <td> <input type="text" value="{{$row->itemtotal}}" disabled  class="form-control"></td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Form inputs -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="discount">Invoice Discount</label>
                                            <input name="discount" placeholder="Invoice Discount" value="{{$invoiceDetail->discount}}" type="text" disabled class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Totals summary -->
                                <div class="row">
                                    <div class="col-md-4 offset-md-8">
                                        <table class="table">
                                            <tr>
                                                <th>Grand Total:</th>
                                                <td id="grandTotal">PKR {{$invoiceDetail->total}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <input type="hidden" name="total" id="invoice_total" />

                                <div class="form-group row mb-5">
                                    <div class="col-md-4 mb-5">
                                        <label class="form-label">Courier Service:</label>
                                        <input type="text" name="courier_service"  class="form-control mb-2 mb-md-0" value="{{$invoiceDetail->courier_service}}" placeholder="Courier Service" />
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="form-label">Attach Reciept:</label>
                                        <input type="file" name="invoice_receipt" class="form-control mb-2 mb-md-0" />
                                        @if($invoiceDetail->invoice_receipt!=null)
                                            <a target="_blank" href="{{asset('public/files/invoicereceipts/'.$invoiceDetail->invoice_receipt)}}">View</a>
                                        @endif
                                        @error('invoice_receipt')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="form-label">Tracking ID:</label>
                                        <input type="text" name="tracking_id"  class="form-control mb-2 mb-md-0" value="{{$invoiceDetail->tracking_id}}" placeholder="Invoice Tracking ID" />
                                    </div>
                                </div>
                                <!-- Submit button -->
                                <div class="row">
                                    <div class="col-12 text-right">
                                        @if($invoiceDetail->focStatus=='FOC Approval Pending' && $userRole==1)
                                        <a href="{{ route('change-invoice',$invoiceId) }}" class="btn btn-success">Change FOC Status</a>
                                        @endif
                                            @if($invoiceDetail->status=='out for delivery')
                                                <button type="submit" class="btn btn-light-success">Mark as Delivered</button>
                                            @endif
                                            @if($invoiceDetail->status=='delivered')
                                                <button type="submit" class="btn btn-light-info">Update Invoice</button>
                                            @endif

                                        <a href="{{ url('/invoice-list') }}" class="btn btn-secondary">Go Back</a>
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

