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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Add User</h1>
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
                        <li class="breadcrumb-item text-muted">Edit User</li>
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
                        <form class="form w-100" method="POST" action="{{ route('update-user') }}">
                            @csrf
                            <input type="hidden" name="recordid" value="{{ $user->id }}" />
                            <div class="card-body pt-0">
                                <div class="form-group row mb-5">
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Name:</label>
                                        <input type="text" name="name" class="form-control form-control-solid" value="{{$user->name}}" placeholder="Name"/>
                                        @error('name')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Email:</label>
                                        <input type="email" name="email" class="form-control form-control-solid" placeholder="User Email" value="{{$user->email}}" disabled/>
                                        @error('email')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Phone No 1:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Phone No 1" value="{{ $user->phoneno_1 }}" name ="phoneno_1"/>
                                        @error('phoneno_1')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Phone No 2:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Phone No 2" value="{{ $user->phoneno_2 }}" name ="phoneno_2"/>
                                        @error('phoneno_2')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Address:</label>
                                        <textarea class="form-control form-control-solid" placeholder="Address" name ="address">{{ $user->address }}</textarea>
                                        @error('address')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Billing Address:</label>
                                        <textarea class="form-control form-control-solid" placeholder="Billing Address" name ="billing_address">{{ $user->billing_address }}</textarea>
                                        @error('billing_address')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-5">
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Shipping Address:</label>
                                        <textarea class="form-control form-control-solid" placeholder="Shipping Address" name ="shipping_address">{{ $user->shipping_address }}</textarea>
                                        @error('shipping_address')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Working Hours:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Working Hours" name ="working_hours" value="{{$user->working_hours}}"/>
                                        @error('working_hours')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">User Role:</label>
                                        <select class="form-select form-select-solid" name="role" aria-label="Select example" >
                                            <option value="0">Select Role</option>
                                            <option value="2" @if($user->role_id==2) selected @endif>Admin</option>
                                            <option value="3" @if($user->role_id==3) selected @endif>Dealer</option>
                                            <option value="4" @if($user->role_id==4) selected @endif>Service Center</option>
                                        </select>
                                        @error('role')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <h2 class="mb-3">Working Hours</h2>
                                <hr/>
                                <div class="form-group row mb-5 mt-5">
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Monday Timing:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Monday Timing" name ="monday_timing" value="{{$user->monday_timing}}"/>
                                        @error('monday_timing')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Tuesday Timing:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Tuesday Timing" name ="tuesday_timing" value="{{$user->tuesday_timing}}"/>
                                        @error('tuesday_timing')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Wednesday Timing:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Wednesday Timing" name ="wednesday_timing" value="{{$user->wednesday_timing}}"/>
                                        @error('wednesday_timing')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-5 mt-5">
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Thursday Timing:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Thursday Timing" name ="thursday_timing" value="{{$user->thursday_timing}}"/>
                                        @error('thursday_timing')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Friday Timing:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Friday Timing" name ="friday_timing" value="{{$user->friday_timing}}"/>
                                        @error('friday_timing')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Saturday Timing:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Saturday Timing" name ="saturday_timing" value="{{$user->saturday_timing}}"/>
                                        @error('saturday_timing')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-5 mt-5">
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Sunday Timing:</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Sunday Timing" name ="sunday_timing" value="{{$user->sunday_timing}}"/>
                                        @error('sunday_timing')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="required form-label">Status:</label>
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="radio" value="active" @if($user->status=='active') checked @endif name="status"  id="flexCheckboxLg"/>
                                            <label class="form-check-label" for="flexCheckboxLg">
                                                Active
                                            </label>
                                            <div class="p-5"></div>
                                            <input class="form-check-input" type="radio" value="inactive" @if($user->status=='inactive') checked @endif name="status"  id="flexCheckboxLg"/>
                                            <label class="form-check-label" for="flexCheckboxLg">
                                                Inactive
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="mb-10">
                                    <button type="submit" class="btn btn-info">Update</button>
                                    <a href="{{ route('change-password',$user->id) }}" class="btn btn-warning">Forget Password</a>
                                    <a href="{{ url('/users-list') }}" class="btn btn-secondary">Cancel</a>
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
