@extends('layouts.main')
@section('content')
    @include('layouts.alert')
    @if (isset($user))
        <h1 style="color: yellow">{{ $user->name }}</h1>
    @endif
@endsection
