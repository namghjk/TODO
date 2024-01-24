@extends('layouts.main')
@section('content')

    @if (isset($user))
        <h1 style="color: yellow">{{ $user->name }}</h1>
    @endif
@endsection
