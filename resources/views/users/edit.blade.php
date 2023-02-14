@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit User</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a class="btn btn-sm btn-outline-danger" href="{{ url()->previous() }}">Back</a>
            </div>
        </div>
    </div>
    <x-admin.flash-message />
    <form id="user-edit" action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input class="form-control" type="text" name="name" placeholder="Name"
                        value="{{ old('name', $user->name) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input class="form-control" type="email" name="email" placeholder="Email"
                        value="{{ old('email', $user->email) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="form-group">
                    <strong>Password:</strong>
                    <input id="password" class="form-control" type="password" name="password" placeholder="Password"
                        value="{{ old('password') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    <input class="form-control" type="password" name="confirm-password" placeholder="Confirm Password">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="form-group">
                    <strong>Phone:</strong>
                    <input class="form-control" type="number" name="phone" placeholder="Phone"
                        value="{{ old('phone') }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="form-group">
                    <strong>City:</strong>
                    <input class="form-control" type="text" name="city" placeholder="City"
                        value="{{ old('city', $user->city) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="form-group">
                    <strong>State:</strong>
                    <input class="form-control" type="text" name="state" placeholder="State"
                        value="{{ old('state', $user->state) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="form-group">
                    <strong>Country:</strong>
                    <input class="form-control" type="text" name="country" placeholder="Country"
                        value="{{ old('country', $user->country) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="block">
                    <div id="multiAddress">
                        @foreach (explode(',', $user->address) as $key => $address)
                            <div class="form-group">
                                <strong>Address:</strong>
                                <input class="form-control" type="text" name="address[]" placeholder="Address"
                                    value="{{ $address }}">
                                @if ($key >= 1)
                                    <a href="javascript:;" class="remove-address">remove</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <button type="button" name="add" id="add-address" class="btn btn-outline-primary">Add
                        Address</button>
                </div>
            </div>
            {{-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                <div class="form-group">
                    <strong>Role:</strong>
                    <select class="form-control" name="roles[]" id="" multiple>
                        @foreach ($roles as $key => $role)
                            <option value="{{ $role }}" @if (in_array($role, $user->getRoleNames()->toArray())) selected @endif>
                                {{ $role }}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
@push('js')
    <script>
        $("#add-address").click(function() {
            $("#multiAddress").append(
                '<div class="form-group"><strong>Address:</strong><input class="form-control" type="text" name="address[]" placeholder="Address"><a href="javascript:;" class="remove-address">remove</a></div>'
            );
        });
        $('body').on('click', '.remove-address', function() {
            console.log("here");
            $(this).parent('.form-group').remove();
        });
        if ($("#user-edit").length > 0) {
            $("#user-edit").validate({
                rules: {
                    'name': {
                        required: true,
                        maxlength: 10
                    },
                    'email': {
                        required: true,
                        email: true
                    },
                    'password': {
                        required: false,
                    },
                    'confirm-password': {
                        required: false,
                        equalTo: "#password"
                    },
                },
            })
        }
    </script>
@endpush
