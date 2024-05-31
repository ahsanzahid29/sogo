<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ route('dashboard') }}">
            <img alt="Logo" src="{{asset('public/assets/media/logos/default-dark.png')}}" class="h-25px app-sidebar-logo-default" />
            <img alt="Logo" src="{{asset('public/assets/media/logos/default-small.svg')}}" class="h-20px app-sidebar-logo-minimize" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <!--begin::Minimized sidebar setup:

        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                         @php
            $dashboardActive = '';
            if (Route::currentRouteName()=='dashboard'){
                $dashboardActive='active';
            }
            @endphp

                        <!--begin:Menu link-->
                        <a class="menu-link {{ $dashboardActive }} " href="{{url('/dashboard')}}">
												<span class="menu-icon">
													<i class="ki-duotone ki-element-11 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!-- begin: sidebar for super admin -->
                    @if(Auth::user()->role_id==1)
                        @php
                        $userActive = '';
                        if (Route::currentRouteName()=='users-list'|| Route::currentRouteName()=='user-add'
                        || Route::currentRouteName()=='edituser'){
                        $userActive='active';
                        }
                        @endphp
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Users</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $userActive }}" href="{{ url('/users-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-basket fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Users</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        @php
                            $productActive = '';
                            $productCategoryActive = '';
                            $productInventoryActive='';
                            $spCategoryActive='';
                            $spActive = '';
                            if (Route::currentRouteName()=='list-inverter'|| Route::currentRouteName()=='add-inverter'
                            || Route::currentRouteName()=='inverter-add' || Route::currentRouteName()=='edit-inverter'){
                            $productActive='active';
                            }
                            if (Route::currentRouteName()=='list-inverter-category'|| Route::currentRouteName()=='edit-product-category'){
                            $productCategoryActive='active';
                            }
                            if (Route::currentRouteName()=='list-inverter-inventory'|| Route::currentRouteName()=='add-inverter-inventory'){
                            $productInventoryActive='active';
                            }
                            if (Route::currentRouteName()=='list-category-spartpart'|| Route::currentRouteName()=='edit-sparepart-category'){
                            $spCategoryActive='active';
                            }
                             if (Route::currentRouteName()=='list-spartpart'|| Route::currentRouteName()=='add-spartpart'
                             || Route::currentRouteName()=='edit-sparepart'){
                            $spActive='active';
                            }
                        @endphp
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Products</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $productCategoryActive }}" href="{{ url('/product-category-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-text-align-center fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Products Category</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $productActive }}" href="{{ url('/inverters-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-text-align-center fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Products</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $productInventoryActive }}" href="{{ url('/inverters-inventory-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-text-align-center fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Products Inventory</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Spare Parts</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $spCategoryActive }}" href="{{ url('/spareparts-category-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-28 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Spare Parts Category</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $spActive }}" href="{{ url('/spareparts-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-28 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Spare Parts</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @php
                            $spInvActiveActive = '';
                            $invoiceActive='';
                            $spRequestActive='';
                            if (Route::currentRouteName()=='list-sparepart-inventory'|| Route::currentRouteName()=='add-sparepart-inventory'
                            ){
                            $spInvActiveActive='active';
                            }
                             if (Route::currentRouteName()=='list-sp-invoice'|| Route::currentRouteName()=='add-sp-invoice'
                             || Route::currentRouteName()=='viewinvoice'
                            ){
                            $invoiceActive='active';
                            }
                             if (Route::currentRouteName()=='list-sp-request'){
                            $spRequestActive='active';
                            }

                            @endphp
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $spInvActiveActive }}" href="{{ url('/sparepart-inventory-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-28 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Spare Parts Invertory</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Invoices</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $invoiceActive }}" href="{{ url('/invoice-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-38 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Spare Part Invoices</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $spRequestActive }}" href="{{ url('/sparepart-request-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-38 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Request Spare Part</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @php
                            $dNoteActive = '';
                            if (Route::currentRouteName()=='deliverynote-list'|| Route::currentRouteName()=='deliverynote-add'
                            || Route::currentRouteName()=='viewdeiverynote'
                            ){
                            $dNoteActive='active';
                            }
                            @endphp

                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Delivery Note</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $dNoteActive }}" href="{{ url('/deliverynote-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-credit-cart fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Inverters Delivery Note</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        @php
                            $repActive = '';
                            if (Route::currentRouteName()=='lists-repair-ticket'|| Route::currentRouteName()=='all-repairs-ticket'
                            || Route::currentRouteName()=='create-repair-ticket' || Route::currentRouteName()=='view-repair-ticket'
                            ){
                            $repActive='active';
                            }
                        @endphp
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Repair Tickets</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $repActive }}" href="{{ url('/repairticket-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-26 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Repair Tickets</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        @endif
                    <!-- end: sidebar for super admin -->
                    <!-- begin: sidebar for  admin -->
                    @if(Auth::user()->role_id==2)
                        @php
                            $productActive = '';
                            $productInventoryActive='';
                            $spInvActiveActive = '';
                            $spActive = '';
                            if (Route::currentRouteName()=='list-inverter'|| Route::currentRouteName()=='add-inverter'
                            || Route::currentRouteName()=='inverter-add' || Route::currentRouteName()=='edit-inverter'){
                            $productActive='active';
                            }
                            if (Route::currentRouteName()=='list-inverter-inventory'|| Route::currentRouteName()=='add-inverter-inventory'){
                            $productInventoryActive='active';
                            }
                            if (Route::currentRouteName()=='list-sparepart-inventory'|| Route::currentRouteName()=='add-sparepart-inventory'
                            ){
                            $spInvActiveActive='active';
                            }
                             if (Route::currentRouteName()=='list-spartpart'|| Route::currentRouteName()=='add-spartpart'
                             || Route::currentRouteName()=='edit-sparepart'){
                            $spActive='active';
                            }
                        @endphp
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Products</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $productActive }}" href="{{ url('/inverters-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-text-align-center fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Products</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $productInventoryActive }}" href="{{ url('/inverters-inventory-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-text-align-center fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Products Inventory</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Spare Parts</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $spActive }}" href="{{ url('/spareparts-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-28 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Spare Parts</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $spInvActiveActive }}" href="{{ url('/sparepart-inventory-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-28 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Spare Parts Invertory</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        @php
                            $invoiceActive='';
                             if (Route::currentRouteName()=='list-sp-invoice'|| Route::currentRouteName()=='add-sp-invoice'
                             || Route::currentRouteName()=='viewinvoice'
                            ){
                            $invoiceActive='active';
                            }
                        @endphp
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Invoices</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $invoiceActive }}" href="{{ url('/invoice-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-38 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Spare Part Invoices</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        @php
                            $dNoteActive = '';
                            if (Route::currentRouteName()=='deliverynote-list'|| Route::currentRouteName()=='deliverynote-add'
                            || Route::currentRouteName()=='viewdeiverynote'
                            ){
                            $dNoteActive='active';
                            }
                        @endphp

                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Delivery Note</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $dNoteActive }}" href="{{ url('/deliverynote-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-credit-cart fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Inverters Delivery Note</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        @php
                            $repActive = '';
                            if (Route::currentRouteName()=='lists-repair-ticket'|| Route::currentRouteName()=='all-repairs-ticket'
                            || Route::currentRouteName()=='create-repair-ticket' || Route::currentRouteName()=='view-repair-ticket'
                            ){
                            $repActive='active';
                            }
                        @endphp
                            <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Repair Tickets</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $repActive }}" href="{{ url('/repairticket-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-26 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Repair Tickets</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endif
                    <!-- end: sidebar for  admin -->

                    <!-- begin: sidebar for  dealer -->
                    @if(Auth::user()->role_id==3)
                        @php
                            $productActive = '';
                            $productInventoryActive='';
                            if (Route::currentRouteName()=='list-inverter'|| Route::currentRouteName()=='add-inverter'
                            || Route::currentRouteName()=='inverter-add' || Route::currentRouteName()=='edit-inverter'){
                            $productActive='active';
                            }
                            if (Route::currentRouteName()=='list-inverter-inventory'|| Route::currentRouteName()=='add-inverter-inventory'){
                            $productInventoryActive='active';
                            }
                        @endphp
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Products</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $productActive }}" href="{{ url('/inverters-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-text-align-center fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Products</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $productInventoryActive  }}" href="{{ url('/inverters-inventory-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-text-align-center fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Products Inventory</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        @php
                            $dNoteActive = '';
                            $spActive= '';
                            if (Route::currentRouteName()=='deliverynote-list'|| Route::currentRouteName()=='deliverynote-add'
                            || Route::currentRouteName()=='viewdeiverynote'
                            ){
                            $dNoteActive='active';
                            }
                             if (Route::currentRouteName()=='list-spartpart'|| Route::currentRouteName()=='add-spartpart'
                             || Route::currentRouteName()=='edit-sparepart'){
                            $spActive='active';
                            }
                        @endphp
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Delivery Note</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $dNoteActive }}" href="{{ url('/deliverynote-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-credit-cart fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Inverters Delivery Note</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Spare Parts</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $spActive }}" href="{{ url('/spareparts-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-28 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Spare Parts</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endif
                    <!-- end: sidebar for  dealer -->

                    <!-- begin: sidebar for  service center -->
                    @if(Auth::user()->role_id==4)
                        @php
                            $productActive = '';
                            $spActive = '';
                            $spInvActiveActive = '';
                            if (Route::currentRouteName()=='list-inverter'|| Route::currentRouteName()=='add-inverter'
                            || Route::currentRouteName()=='inverter-add' || Route::currentRouteName()=='edit-inverter'){
                            $productActive='active';
                            }
                             if (Route::currentRouteName()=='list-spartpart'|| Route::currentRouteName()=='add-spartpart'
                             || Route::currentRouteName()=='edit-sparepart'){
                            $spActive='active';
                            }
                            if (Route::currentRouteName()=='list-sparepart-inventory'|| Route::currentRouteName()=='add-sparepart-inventory'
                            ){
                            $spInvActiveActive='active';
                            }
                        @endphp

                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Products</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $productActive }}" href="{{ url('/inverters-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-text-align-center fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Products</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Spare Parts</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $spActive }}" href="{{ url('/spareparts-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-28 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Spare Parts</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $spInvActiveActive }}" href="{{ url('/sparepart-inventory-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-28 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Spare Parts Invertory</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                    @php
                        $invoiceActive='';
                            if (Route::currentRouteName()=='list-sp-invoice'|| Route::currentRouteName()=='add-sp-invoice'
                                     || Route::currentRouteName()=='viewinvoice'
                                    ){
                                    $invoiceActive='active';
                                    }
                    @endphp
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Invoices</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $invoiceActive }}" href="{{ url('/invoice-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-38 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Spare Part Invoices</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        @php
                            $repActive = '';
                            if (Route::currentRouteName()=='lists-repair-ticket'|| Route::currentRouteName()=='all-repairs-ticket'
                            || Route::currentRouteName()=='create-repair-ticket' || Route::currentRouteName()=='view-repair-ticket'
                            || Route::currentRouteName()=='request-repair-ticket-spareparts' || Route::currentRouteName()=='edit-repair-ticket'
                            ){
                            $repActive='active';
                            }
                        @endphp
                            <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Repair Tickets</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ $repActive }}" href="{{ url('/repairticket-list') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-abstract-26 fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Manage Repair Tickets</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                    @endif
                    <!-- end: sidebar for  service center -->



                    <!--begin:Menu item-->
                    <div class="menu-item pt-5">
                        <!--begin:Menu content-->
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Security</span>
                        </div>
                        <!--end:Menu content-->
                    </div>
                    <!--end:Menu item-->
                    @php
                        $profileActive = '';
                        if (Route::currentRouteName()=='edit-my-profile'){
                        $profileActive='active';
                        }
                    @endphp
                        <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ $profileActive }}" href="{{ url('edit-profile') }}">
												<span class="menu-icon">
													<i class="ki-duotone ki-user fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                            <span class="menu-title">Edit Profile</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="menu-link" onclick="event.preventDefault(); this.closest('form').submit();">
												<span class="menu-icon">
													<i class="ki-duotone ki-map fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
													</i>
												</span>
                                <span class="menu-title">Logout</span>
                            </a>
                        </form>
                        <!--begin:Menu link-->

                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->

                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>
<!--end::Sidebar-->
