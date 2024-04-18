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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Edit Profile</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.php" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Edit Profile</li>
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
                        <form class="form w-100" method="POST" action="{{ url('/update-profile') }}">
                            @csrf

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="required form-label">Name</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Name"/>
                            </div>

                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="required form-label">Email</label>
                                <input type="email" class="form-control form-control-solid" placeholder="User Email"/>
                            </div>
                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="form-label">New Password</label>
                                <input type="password" class="form-control form-control-solid" placeholder="New Password"/>
                            </div>
                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control form-control-solid" placeholder="Confirm New Password"/>
                            </div>
                            <div class="mb-10">
                                <label for="exampleFormControlInput1" class="form-label">Change Avatar</label>
                                <input type="file" class="form-control form-control-solid"/>
                            </div>
                            <div class="mb-10">
                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Cancel</a>
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
