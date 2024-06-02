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
                        <li class="breadcrumb-item text-muted">View Delivery Note</li>
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
                        <div class="card-body p-12">
                            <div class="form-group row mb-5">
                            <div class="col-md-6 mb-5">
                                <label for="exampleFormControlInput1" class="form-label"> Dealer Name</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Dealer Name" value="{{$deliveryNote->username}}" readonly/>
                            </div>
                                <div class="col-md-6 mb-5">
                                <label for="exampleFormControlInput1" class="form-label"> Dealer Email</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Dealer Name" value="{{$deliveryNote->useremail}}" readonly/>
                            </div>
                            </div>
                            <div class="form-group row mb-5">
                                <div class="col-md-6 mb-5">
                                <label for="exampleFormControlInput1" class="form-label"> Dealer Phone</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Dealer Phone" value="{{$deliveryNote->userphone}}" readonly/>
                            </div>
                                <div class="col-md-6 mb-5">
                                    <label for="exampleFormControlInput1" class="form-label">DO Number</label>
                                    <input type="text" class="form-control form-control-solid" placeholder="DO Number" value="{{$deliveryNote->do_no}}" readonly/>
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <div class="col-md-12 mb-5">
                                <label for="exampleFormControlInput1" class="form-label">Delivery Notes</label>
                                <textarea rows="7" cols="7" class="form-control form-control-solid" placeholder="Notes.." name="notes" readonly>{{$deliveryNote->notes}}</textarea>
                            </div>
                            </div>

                            <h2>Delivery Items</h2>
                            <hr/>

                            <div class="row mb-5">
                                <div class="col-12">
                                    <table class="table table-row-dashed table-row-gray-300 gy-7">
                                        <thead>
                                        <tr class="fw-bold fs-6 text-gray-800" >
                                            <th>Modal No</th>
                                            <th>Serial No</th>
                                            <th>Delivery Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($deliveryItems as $row)
                                            <tr>
                                                <td>{{ $row->modalNo }}</td>
                                                <td>{{ $row->sno }}</td>
                                                <td>{{ date('d/m/Y',strtotime($row->delivery_date)) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>




                            <div class="mb-10">
                                <a href="{{ url('/deliverynote-list') }}" class="btn btn-secondary">Cancel</a>
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
