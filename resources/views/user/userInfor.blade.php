@extends('partials.main')
@section('content')
    <div class="card">
        <form action="{{ route('update_user_infor', $user->id) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="first_name">First name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                        value="{{ $user->first_name }}">
                    @error('first_name')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Last name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                        value="{{ $user->last_name }}">
                    @error('last_name')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                    @error('address')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                </div>


            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
@endsection
