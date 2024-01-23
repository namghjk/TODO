@extends('layouts.main')
@section('content')
    <div class="card">
        <form action="{{ route('updateUserInfor', $user->id) }}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="first_name">First name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                        value="{{ $user->first_name }}">
                    @if ($errors->has('first_name'))
                        <span type='error' style="color: red">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="last_name">Last name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                        value="{{ $user->last_name }}">
                    @if ($errors->has('last_name'))
                        <span type='error' style="color: red">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                    @if ($errors->has('address'))
                        <span type='error' style="color: red">{{ $errors->first('address') }}</span>
                    @endif
                </div>


            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
@endsection
