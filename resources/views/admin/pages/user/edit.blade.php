@extends('partials.main')
@section('content')
    <div class="card">
        <form action="{{ route('manage-user.update', $manage_user) }}" method="post">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="first_name">First name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                        value="{{ $manage_user->first_name }}">
                    @error('first_name')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Last name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                        value="{{ $manage_user->last_name }}">
                    @error('last_name')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $manage_user->address }}">
                    @error('address')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                    <div class="form-group" style='width:50%'>
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="0" {{ $manage_user->status == 0 ? 'selected' : '' }}>Waited</option>
                            <option value="1" {{ $manage_user->status == 1 ? 'selected' : '' }}>Confirmed</option>
                            <option value="2" {{ $manage_user->status == 2 ? 'selected' : '' }}>Refused</option>
                            <option value="3" {{ $manage_user->status == 3 ? 'selected' : '' }}>Locked</option>
                        </select>
                    </div>
                </div>


            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
@endsection
