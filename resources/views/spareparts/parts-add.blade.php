@extends('layouts.dashboard')
@push('scripts_top')
    <style>
        .add-form, .remove-form {
            margin-left: 10px;
        }
    </style>
@endpush
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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Add Spare Part</h1>
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
                        <li class="breadcrumb-item text-muted">Add Spare Part</li>
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
                        <form class="form w-100" method="POST" action="{{ route('save-spartpart') }}" enctype="multipart/form-data">
                            @csrf
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="form-group row mb-5">
                                <div class="col-md-4 mb-5">
                                    <label class=" required form-label">Factory Code:</label>
                                    <input type="text" class="form-control mb-2 mb-md-0" name="factory_code" placeholder="Factory Code" />
                                    @error('factory_code')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label for="exampleFormControlInput1" class="required form-label">Part Type</label>
                                    <select class="form-select form-select-solid" name="part_type" aria-label="Select example">
                                        <option value="0">Select Part Type</option>
                                        @foreach($sparePartCategory as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('part_type')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-5">
                                    <label for="exampleFormControlInput1" class="form-label">Part Image</label>
                                    <input type="file" name="part_image" class="form-control mb-2 mb-md-0" />
                                    @error('part_image')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror

                                </div>

                            </div>

                            <div class="form-group row mb-5">
{{--                                <div class="col-md-4 mb-5">--}}
{{--                                    <label class="required form-label">Voltage Rating :</label>--}}
{{--                                    <input type="text" class="form-control mb-2 mb-md-0" name="voltage_rating" placeholder="Voltage Rating" />--}}
{{--                                    @error('voltage_rating')--}}
{{--                                    <div class="alert alert-danger mt-2">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}

{{--                                <div class="col-md-4 mb-5">--}}
{{--                                    <label class=" required form-label">Ampere Rating :</label>--}}
{{--                                    <input type="text" class="form-control mb-2 mb-md-0" name="ampeare_rating" placeholder="Ampere Rating" />--}}
{{--                                    @error('ampeare_rating')--}}
{{--                                    <div class="alert alert-danger mt-2">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
                                <div class="col-md-6 mb-5">
                                    <label class="required form-label">Sale Price :</label>
                                    <input type="text" class="form-control mb-2 mb-md-0" name="sale_price" placeholder="Sale Price" />
                                    @error('sale_price')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
{{--                                <div class="col-md-4 mb-5">--}}
{{--                                    <label class="required form-label">Base Unit :</label>--}}
{{--                                    <input type="text" class="form-control mb-2 mb-md-0" name="base_unit" placeholder="Base Unit" />--}}
{{--                                    @error('base_unit')--}}
{{--                                    <div class="alert alert-danger mt-2">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
                                <div class="col-md-6 mb-5">
                                    <label class="required form-label">Pieces :</label>
                                    <input type="number" value="1" class="form-control mb-2 mb-md-0" name="pieces" placeholder="Pieces" required />
                                    @error('pieces')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group row mb-5">
                                <div class="col-md-12 mb-5">
                                    <label class="form-label">Technical Notes:</label>
                                    <textarea rows="7" cols="7" class="form-control mb-2 mb-md-0" name="technical_notes" placeholder="Technical Notes"></textarea>
                                    @error('technical_notes')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-5">

                                <div class="col-md-12 mb-5 mt-7">
                                    <button type="button" class="btn btn-success add-form">Add Product Modal</button>

                                </div>

                            </div>
                            <div id="form-container">

                                    <div class="form-group row mb-5 repeatable-section">
                                        <div class="col-md-4 mb-5 mt-2">
                                            <label for="exampleFormControlInput1" class=" required form-label">Product Model</label>
                                            <select name="inverter_modal[]" class="form-select form-select-solid" required>
                                                <option value="" selected>Select Product Modal</option>
                                                @foreach($inverters as $row)
                                                <option value="{{$row->id}}">{{ $row->modal_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-5">
                                            <label class=" required form-label">Dosage :</label>
                                            <input type="text" name="dosage[]" class="form-control mb-2 mb-md-0" placeholder="Dosage" required />
                                        </div>

                                    </div>
                            </div>

                            <div class="form-group row mb-5">
                            <div class="col-md-12 mb-5">
                                <label class=" required form-label">Spart Part Description:</label>
                                <textarea rows="7" cols="7" class="form-control mb-2 mb-md-0" name="name" placeholder="Spart Part Description" required></textarea>
                                @error('name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ url('/spareparts-list') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                        <!--end::Card body-->
                        </form>
                    </div>
                    <!--end::Card header-->
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
            // Function to add form groups
            $('.add-form').click(function() {
                var newFormGroup = $('.repeatable-section').first().clone(); // Clone the first repeatable section
                newFormGroup.find('input').val(''); // Clear the input value in the cloned section
                newFormGroup.find('select').val('Select Type'); // Reset the dropdown to the default option

                // Add a remove button to the newly added form group if not already there
                if (newFormGroup.find('.remove-form').length === 0) {
                    newFormGroup.append('<div class="col-md-4 mb-5 mt-7"><button type="button" class="btn btn-danger remove-form mb-2">-</button></div>');
                }

                $('#form-container').append(newFormGroup); // Append the new form group to the main container
            });

            // Function to remove form groups
            $(document).on('click', '.remove-form', function() {
                $(this).closest('.repeatable-section').remove(); // Remove the nearest repeatable section to the "-" button clicked
            });
        });
    </script>

@endpush
