<div class="form-group row mb-5">
    <div class="col-md-6 mb-5">
        <label for="exampleFormControlInput1" class="form-label">Email:</label>
        <input type="text" disabled  class="form-control mb-2 mb-md-0" placeholder="Email" value="{{$user->email}}"  />

    </div>
    <div class="col-md-6 mb-5">
        <label class="form-label">Shipping Address:</label>
        <textarea class="form-control form-control-solid" placeholder="Shipping Address" disabled>{{ $user->shipping_address }}</textarea>
    </div>
</div>
