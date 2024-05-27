@if($alertDiv=="1")
    <p id="nosn" style="color:red">No Product Found</p>
@else
    <p id="nosn" style="color:green">Product Found</p>

@if($warantyexpire=="0")
    @if(count($history)>0)
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
            <td>{{ $selectedSn }}</td>
            <td><a href="#" data-bs-toggle="modal" data-bs-target="#fault_detail_{{$row->repairid}}">View Details</a></td>
            <td>{{ $row->service_center_name }}</td>
            <td>{{ date ('d/m/Y',strtotime($row->repair_date)) }}</td>
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

    <form class="form w-100" method="POST" action="{{ route('save-repairticket') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="serial_no" value="{{ $selectedSn }}" />
        <div class="form-group row mb-5">
            <h2 class="mb-5">Fault Details</h2>
            <hr/>
            <div class="col-md-6 mb-5">
                <label class="form-label">Fault Detail:</label>
                <textarea class="form-control mb-2 mb-md-0" placeholder="What is the fault..." name="fault_detail"></textarea>
                @error('fault_detail')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-5">
                <label class="form-label">Fault video:</label>
                <input type="file" onchange="previewvideo();" id='uploadfile' name="fault_video" class="form-control mb-2 mb-md-0" accept=".mp4, .webm" required />
                @error('fault_video')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row mb-5" >
            <div class="col-md-6 mb-5">
                <button id="addSpartBtn" class="btn btn-light-success">Add</button>
            </div>
        </div>
    <div class="form-group row mb-5">
        <h2 class="mb-5">Spare Part to need</h2>
        <hr/>
        <table class="table table-row-dashed table-row-gray-300 gy-7">
            <thead>
            <tr class="fw-bold fs-6 text-gray-800" >
                <th>Part Name</th>
                <th>Total Quantity</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="inputRow">
            </tbody>
        </table>
    </div>
    <div class="form-group row mb-5">
        <h2 class="mb-5">Didn't Find the part. Tell us more</h2>
        <hr/>
        <div class="col-md-12 mb-5">
            <label class="form-label">Explain more:</label>
            <textarea class="form-control mb-2 mb-md-0" name="explain_more"></textarea>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ url('/all-repairtickets') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
    </form>
@else
    <p id="" style="color:red">Warranty expires</p>
@endif
@endif

<script type="text/javascript">
    $(document).ready(function() {
        var parts = @json($sparePartsForSc);

        $('#addSpartBtn').click(function(e) {
            e.preventDefault();  // This stops the default form submission action
            var selectHtml = '<select name="sparepart[]" class="form-control part-dropdown" required>';
            selectHtml += '<option value="">Select Spare Part</option>';
            parts.forEach(function(option) {
                selectHtml += '<option value="' + option.partid + '">' + option.partname + '</option>';
            });
            selectHtml += '</select>';
            var newRow = '<tr>' +
                '<td>' + selectHtml + '</td>' +
                '<td><input type="text" placeholder="Current Stock" name="current_stock[]" class="form-control current-stock" readonly ></td>' +
                '<td><input type="text" placeholder="Required Stock" name="needed_stock[]" class="form-control need-stock" required></td>' +
                '<td><button class="btn btn-light-danger btn-xs removeBtn">Remove</button></td>' +
                '</tr>';
            $('#inputRow').append(newRow);
            // updateGrandTotal();
        });
        // Event delegation to handle click on dynamically created remove buttons
        $('#inputRow').on('click', '.removeBtn', function() {
            $(this).closest('tr').empty(); // This empties the content of the td that contains the clicked button
        });
        $('#inputRow').on('change', '.part-dropdown', function() {
            var selectedPartId = $(this).val();
            var $currentstockField = $(this).closest('tr').find('.current-stock');

            if (selectedPartId) {
                $.ajax({
                    url: "{{ url('/sp-detail-sc') }}",
                    type: 'GET',
                    data: { partId: selectedPartId },
                    success: function(response) {
                        $currentstockField.val(response.currentStock);
                    },
                    error: function(xhr) {
                        console.error('Error fetching tax data:', xhr.responseText);
                    }
                });
            } else {
                $currentstockField.val(''); // Clear tax output if no part is selected
            }
        });



    });
    function previewvideo(){

        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadfile").files[0]);
        var checkvideo = $('#uploadfile').val().split('.').pop();
        checkvideo = checkvideo.toLowerCase();
        if(checkvideo=="mp4"  || checkvideo=="webm")
        {
            oFReader.onload = function (oFREvent) {
                //document.getElementById("video_cover").src = oFREvent.target.result;

            }

        }
        else
        {
            alert("Please upload only video files");
            return;
        }

    }

</script>



