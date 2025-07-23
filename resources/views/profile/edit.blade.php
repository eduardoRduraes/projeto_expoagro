@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Perfil</h2>

    @include('profile.partials.update-profile-information-form')

    <hr>

    @include('profile.partials.update-password-form')

    <hr>

    @include('profile.partials.delete-user-form')
@endsection
