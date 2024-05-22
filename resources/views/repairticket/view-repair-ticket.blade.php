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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Repair Ticket</h1>
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
                        <li class="breadcrumb-item text-muted">View Repair Ticket</li>
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
                            @if($userRole!=4)
                                <div class="form-group row mb-5">
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Service Center Name:</label>
                                        <input type="text" class="form-control mb-2 mb-md-0" disabled value="{{$detailSc->name}}" placeholder="Service Center Name" />
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Service Center Address:</label>
                                        <input type="text" class="form-control mb-2 mb-md-0" disabled value="{{$detailSc->shipping_address}}" placeholder="Service Center Address" />
                                    </div>
                                </div>

                                @endif
                            <div class="form-group row mb-5">
                            </div>
                            <div class="form-group row mb-5">
                                <div class="col-md-2 mb-5">
                                    <label class="form-label">Repair Status:</label>
                                    @if($repairTicketDetail->status=='pending')
                                    <a href="javascript:void(0);" target="_blank" class=" form-control mb-2 mb-md-0 btn btn-light-warning">Pending</a>
                                    @else
                                        <a href="javascript:void(0);" target="_blank" class=" form-control mb-2 mb-md-0 btn btn-light-success">Completed</a>
                                    @endif
                                </div>
                                <div class="col-md-10 mb-5">
                                    <label class="form-label">Serial Number:</label>
                                    <input type="text" class="form-control mb-2 mb-md-0" disabled value="{{$repairTicketDetail->serial_number}}" placeholder="Search via Serial Number" />
                                </div>
                            </div>
                            @if(!empty($history))

                            <div class="form-group row mb-5">
                                <h2 class="mb-5">Repair History</h2>
                                <hr/>
                                <table class="table table-row-dashed table-row-gray-300 gy-7">
                                    <thead>
                                    <tr class="fw-bold fs-6 text-gray-800" >
                                        <th>Model No</th>
                                        <th>Serial No</th>
                                        <th>Fault Details</th>
                                        <th>Service Center</th>
                                        <th>Repair Date</th>
                                        <th>Used Parts</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($history as $row)
                                        <tr>
                                            <td>{{ $row->inverter_modal }}</td>
                                            <td>{{ $repairTicketDetail->serial_number }}</td>
                                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#fault_detail_{{$row->repairid}}">View Details</a></td>
                                            <td>{{ $row->service_center_name }}</td>
                                            <td>{{ date ('d M, Y',strtotime($row->repair_date)) }}</td>
                                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#part_detail_{{$row->repairid}}">View Parts</a></td>
                                            <td>
                                                @if($row->status=='completed')
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-success">{{ $row->status }}</div>
                                                    <!--end::Badges-->
                                                @elseif($row->status=='pending')
                                                    <!--begin::Badges-->
                                                    <div class="badge badge-light-info">{{ $row->status }}</div>
                                                    <!--end::Badges-->
                                                @else
                                                @endif

                                            </td>
                                        </tr>
                                        <div class="modal fade" tabindex="-1" id="fault_detail_{{$row->repairid}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">Fault Detail</h3>
                                                    </div>

                                                    <div class="modal-body">
                                                        <p>{{ $row->faultdetail }}</p>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" tabindex="-1" id="part_detail_{{$row->repairid}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title">Spare Part Used</h3>
                                                    </div>

                                                    <div class="modal-body">
                                                        <p>{{ $row->sp_name }}</p>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            @endif
                            <div class="form-group row mb-5">
                                <h2 class="mb-5">Fault Details</h2>
                                <hr/>
                                <div class="col-md-6 mb-5">
                                    <label class="form-label">Fault Detail:</label>
                                    <textarea class="form-control mb-2 mb-md-0" disabled placeholder="What is the fault...">{{ $repairTicketDetail->fault_detail }}</textarea>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <label class="form-label">Fault video:</label>
                                    <a href="{{ asset('public/files/repairvideos/'.$repairTicketDetail->fault_video) }}" target="_blank" class=" form-control mb-2 mb-md-0 btn btn-light-primary">View</a>
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <h2 class="mb-5">Spare Part to need</h2>
                                <hr/>
                                <table class="table table-row-dashed table-row-gray-300 gy-7">
                                    <thead>
                                    <tr class="fw-bold fs-6 text-gray-800" >
                                        <th>Part Name</th>
                                        <th>Current Stock</th>
                                        <th>Stock Needed</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($neededSpareParts)>0)
                                    @foreach($neededSpareParts as $rownsp)
                                    <tr>
                                        <td> <input type="text" disabled class="form-control" placeholder="Part Name" value="{{ $rownsp->sp_name }}"></td>
                                        <td> <input type="text" disabled class="form-control" placeholder="Part Name" value="{{ $rownsp->current_qty }}"></td>
                                        <td> <input type="text" disabled class="form-control" placeholder="Part Name" value="{{ $rownsp->need_qty }}"></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group row mb-5">
                                <h2 class="mb-5">Didn't Find the part. Tell us more</h2>
                                <hr/>
                                <div class="col-md-12 mb-5">
                                    <label class="form-label">Explain more:</label>
                                    <textarea class="form-control mb-2 mb-md-0" disabled>{{ $repairTicketDetail->explain_more }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-12">
                                    @if($userRole==1)
                                        @if($repairTicketDetail->status=='pending')
                                            <a href="{{ route('complete-repair-ticket',$repairTicketDetail->id) }}" class="btn btn-success">Mark as completed</a>
                                        @else
                                        @endif
                                    @endif
                                    <a href="{{ url('/all-repairtickets') }}" class="btn btn-secondary">Cancel</a>
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
