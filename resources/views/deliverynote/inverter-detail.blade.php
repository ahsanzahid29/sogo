<div class="mb-10">
    <label for="exampleFormControlInput1" class="form-label">Product Description</label>
    <textarea class="form-control form-control-solid" cols="7" rows="7" placeholder="Product Description" readonly>{{ $inverter->inverter_name }}</textarea>
</div>
<div class="mb-10">
    <label for="exampleFormControlInput1" class="form-label">Available Quantity</label>
    <input type="type" class="form-control form-control-solid" placeholder="Available Quantity" readonly value="{{ $inverter->total_quantity }}"/>
</div>
